<?php

namespace App\Form;

use App\Entity\Boitesuggestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoitesuggestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
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
            ->add('message', TextareaType::class, [
                'label' => 'Message:',
                'attr' => [
                    'class' => 'form-control',
                    'cols' => "30",
                    'rows' => "10",
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Boitesuggestion::class,
        ]);
    }
}