<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('complementAdresse')
            ->add('ville')
            ->add('codePostal')
            ->add('mail', EmailType::class)
            ->add('telephone', TelType::class)
            ->add('portable', TelType::class)
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('lieuNaissance')
            ->add('numeroPermis')
            ->add('datePermis', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('villeDelivrancePermis');
        //->add('presence')
        //->add('date_inscription')
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
