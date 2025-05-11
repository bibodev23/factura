<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Invoice;
use App\Enum\InvoiceStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;

class InvoiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', null, [
                'empty_data' => '',
                'label' => 'N° Facture',
                'required' => true,
            ])
            ->add('status', EnumType::class, [
                'class' => InvoiceStatus::class,
                'label' => 'Statut',
                'choice_label' => 'getLabel',
                'placeholder' => 'Sélectionner un statut',
            ])
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => 'name',
                'label' => 'Client',
            ])
            ->add('invoiceLines', LiveCollectionType::class, [
                'entry_type' => InvoiceLineFormType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'd-flex',
                    ],
                ],
                'label' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'button_delete_options' => [
                    'label' => 'X',
                    'attr' => [
                        'class' => 'btn-outline-danger',
                        'data-turbo-method' => 'delete',
                    ],
                ],
                'button_add_options' => [
                    'label' => 'Ajouter une prestation',
                    'attr' => [
                        'class' => 'btn-outline-primary',
                        'data-turbo-method' => 'add',
                    ],
                ]
            ])
            ->add('notes', null, [
                'empty_data' => '',
                'label' => 'Notes',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
