<?php

namespace App\Controller;

use App\Entity\MyCompany;
use App\Form\MyCompanyForm;
use App\Repository\MyCompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/settings/mycompany')]
final class MyCompanyController extends AbstractController
{
    #[Route(name: 'app_my_company_index', methods: ['GET'])]
    public function index(MyCompanyRepository $myCompanyRepository): Response
    {
        $mycompany = $myCompanyRepository->find(1);
        if (!$mycompany) {
            return $this->redirectToRoute('app_my_company_new');
        }

        return $this->render('my_company/show.html.twig', [
            'mycompany' => $mycompany,
        ]);
    }

    #[Route('/new', name: 'app_my_company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $myCompany = new MyCompany();
        $myCompany->setCreatedAt(new \DateTimeImmutable());
        $form = $this->createForm(MyCompanyForm::class, $myCompany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($myCompany);
            $entityManager->flush();

            return $this->redirectToRoute('app_my_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('my_company/new.html.twig', [
            'my_company' => $myCompany,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_my_company_show', methods: ['GET'])]
    public function show(MyCompany $myCompany): Response
    {
        return $this->render('my_company/show.html.twig', [
            'my_company' => $myCompany,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_my_company_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MyCompany $myCompany, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MyCompanyForm::class, $myCompany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $myCompany->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            return $this->redirectToRoute('app_my_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('my_company/edit.html.twig', [
            'my_company' => $myCompany,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_my_company_delete', methods: ['POST'])]
    // public function delete(Request $request, MyCompany $myCompany, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$myCompany->getId(), $request->getPayload()->getString('_token'))) {
    //         $entityManager->remove($myCompany);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_my_company_index', [], Response::HTTP_SEE_OTHER);
    // }
}
