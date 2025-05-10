<?php

namespace App\Twig\Components;

use App\Entity\Invoice;
use App\Entity\InvoiceLine;
use App\Form\InvoiceFormType;
use App\Form\InvoiceLineFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent]
final class InvoiceForm extends AbstractController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;

    #[LiveProp(fieldName: 'invoice')]
    public ?Invoice $invoice;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(InvoiceFormType::class, $this->invoice);
    }

    
}
