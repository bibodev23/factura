<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Entity\InvoiceLine;
use App\Enum\InvoiceStatus;
use App\Form\InvoiceFormType;
use App\Repository\InvoiceRepository;
use App\Service\Pdf\PdfService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[Route('/')]
final class InvoiceController extends AbstractController
{
    #[Route(path: 'invoice', name: 'app_invoice_index', methods: ['GET'])]
    public function index(InvoiceRepository $invoiceRepository): Response
    {
        return $this->render('invoice/index.html.twig', [
            'invoices' => $invoiceRepository->findAll(),
        ]);
    }

    #[Route('invoice/new', name: 'app_invoice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $invoice = new Invoice();
        $invoice->setStatus(InvoiceStatus::PendingSending);
        $form = $this->createForm(InvoiceFormType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($invoice);
            $entityManager->flush();

            return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invoice/new.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
        ]);
    }

    #[Route('invoice/{id}', name: 'app_invoice_show', methods: ['GET'])]
    public function show(Invoice $invoice): Response
    {
        return $this->render('invoice/show.html.twig', [
            'invoice' => $invoice,
        ]);
    }

    #[Route('invoice/{id}/edit', name: 'app_invoice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Invoice $invoice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InvoiceFormType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invoice->setUpdatedAt(new \DateTimeImmutable());
            if ($request->request->has('button_add')) {
                $invoiceLine = new InvoiceLine();
                $invoice->addInvoiceLine($invoiceLine);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invoice/edit.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
        ]);
    }

    #[Route('invoice/{id}', name: 'app_invoice_delete', methods: ['POST'])]
    public function delete(Request $request, Invoice $invoice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $invoice->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($invoice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('invoice/{id}/pdf', name: 'app_invoice_pdf')]
    public function generateInvoicePdf(Invoice $invoice, PdfService $pdfService): Response
    {
        $pdfContent = $pdfService->generatePdf('invoice/pdf.html.twig', [
            'invoice' => $invoice,
        ]);
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="facture_' . $invoice->getId() . '.pdf"',
        ]);
    }

    #[Route('invoice/{id}/send', name: 'app_invoice_send', methods: ['POST'])]
    public function sendInvoiceByEmail(Invoice $invoice, Request $request, MailerInterface $mailer, PdfService $pdfService, Environment $twig): Response
    {
        $customer = $invoice->getCustomer();


        if (!$customer || !$invoice->getCustomerEmail()) {
            $this->addFlash('error', 'Le client n\'a pas été trouvé');
            return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        if (!$this->isCsrfTokenValid('send_invoice' . $invoice->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Jeton CSRF invalide');
        }

        $htmlContent = $twig->render('emails/invoice.html.twig', [
            'invoice' => $invoice,
        ]);

        $pdfContent = $pdfService->generatePdf('invoice/pdf.html.twig', [
            'invoice' => $invoice,
        ]);

        $email = new Email()
            ->from('contact@boualemdahmane.com')
            ->to($invoice->getCustomerEmail())
            ->subject('Facture #' . $invoice->getNumber())
            ->html($htmlContent);

        $email->attach(
            $pdfContent,
            'facture_' . $invoice->getId() . '.pdf',
            'application/pdf'
        );

        foreach ($invoice->getInvoiceLines() as $line) {
            $filePath = $line->getCmr();

            if ($filePath) {
                $absolutePath = $this->getParameter('kernel.project_dir') . '/public/images/cmrs/' . $filePath;

                if (file_exists($absolutePath)) {
                    $email->attachFromPath(
                        $absolutePath,
                        basename($filePath) // Nom du fichier dans l’email
                    );
                }
            }
        }
        $mailer->send($email);
        return $this->redirectToRoute('app_invoice_show', ['id' => $invoice->getId()]);
    }
}
