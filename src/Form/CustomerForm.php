<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('email', null, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Email',
                'attr' => [
                    'type' => 'email',
                ],
            ])
            ->add('phoneNumber', null, [
                'empty_data' => '',
                'label' => 'Téléphone',
                'attr' => [
                    'type' => 'tel',
                ],
            ])
            ->add('adress', null, [
                'empty_data' => '',
                'label' => 'Adresse',
                'required' => true,
            ])
            ->add('complementAdress', null, [
                'empty_data' => '',
                'label' => 'Complément d\'adresse',
            ])
            ->add('zip', null, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Code postal',
            ])
            ->add('city', null, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Ville',
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
            'data_class' => Customer::class,
        ]);
    }
}
