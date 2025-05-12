<?php

namespace App\Form;

use App\Entity\MyCompany;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MyCompanyForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('logoFile', VichFileType::class, [
                'label' => 'Logo',
                'required' => false,
                'download_uri' => true,
                'download_label' => 'Voir le fichier actuel',
                'allow_delete' => true,
            ])
            ->add('siretNumber', null, [
                'required' => true,
                'label' => 'Numéro SIRET',
            ])
            ->add('tvaNumber', null, [
                'required' => true,
                'label' => 'Numéro TVA',
            ])
            ->add('adress', null, [
                'label' => 'Adresse',
            ])
            ->add('complementAdress', null, [
                'label' => 'Complément d\'adresse',
            ])
            ->add('zip', null, [
                'label' => 'Code postal',
            ])
            ->add('city', null, [
                'label' => 'Ville',
            ])
            ->add('tvaRate', null, [
                'label' => 'Taux TVA',
            ])
            ->add('iban', null, [
                'label' => 'IBAN',
            ])
            ->add('email', null, [
                'label' => 'Email',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MyCompany::class,
        ]);
    }
}
