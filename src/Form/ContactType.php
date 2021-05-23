<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom ou Prénom:',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'jackson',
                ]
            ])
            ->add('email', null, [
                'label' => 'Votre E-mail:',
                'help' => 'Nous ne partagerons jamais votre email avec qui que ce soit.'
            ])
            ->add('objet', TextType::class, [
                'label' => 'Objet:',
                'help' => 'Quel est l\'objet de votre demande.'
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message:',
                'attr' => [
                    'class' => 'form-control',
                    'cols' => "30",
                    'rows' => "10",
                ]
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'name',
                'label' => 'Services:',
                'placeholder' => 'Choisissez...'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}