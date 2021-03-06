<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = [
            'Employé' => 'ROLE_PERSONNEL',
            'conducteur' => 'ROLE_CONDUCTEUR',
            'Administrateur' => 'ROLE_ADMIN'
        ];
        $builder
            ->add('fonction', ChoiceType::class, [
                'choices' => $roles,
                'label' => "Rôle de l\'utilisateur",
                'required' => true,
            ])
            ->add('password', PasswordType::class)
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('complementAdresse')
            ->add('ville')
            ->add('mail')
            ->add('telephone')
            ->add('portable')
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('lieuNaissance')
            ->add('numeroPermis')
            ->add('datePermis', DateType::class, [
                'widget' => 'single_text',
            ])
            //->add('presence')
            /* ->add('date_inscription', DateTimeType::class, [
                'widget' => 'single_text',
            ]) */;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
