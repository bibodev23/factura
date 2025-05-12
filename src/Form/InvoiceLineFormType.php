<?php

namespace App\Form;

use App\Entity\Invoice;
use App\Entity\InvoiceLine;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class InvoiceLineFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', null, [
                'empty_data' => '',
            ])
            ->add('unitPrice', null, [
                'empty_data' => '',
                'required' => true,
            ])
            ->add('quantity', IntegerType::class, [
                'empty_data' => 1,
                'required' => true,
            ])

            ->add('cmrFile', VichFileType::class, [
                'label' => 'Fichier cmr',
                'required' => false,
                'download_uri' => true,
                'download_label' => 'Voir le fichier actuel',
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvoiceLine::class,
        ]);
    }
}
