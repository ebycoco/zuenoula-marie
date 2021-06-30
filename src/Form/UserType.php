<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_link' => false,
                'image_uri' => false,
                'label' => 'Image d\'article (JPG or PNG file)',
                'attr' => [
                    'class' => 'filestyle',
                    'data-buttonname' => 'btn-secondary',
                ]
            ])
            ->add('email')
            ->add('pseudo')
            ->add('nom')
            ->add('prenom')
            ->add('ville')
            ->add('sexe', ChoiceType::class, [
                'placeholder' => 'Civilité',
                'choices' => $this->getChoices(),
            ])
            ->add('facebook')
            ->add('twitter')
            ->add('youtube')
            ->add('instagrame')
            ->add('personnel', ChoiceType::class, [
                'placeholder' => 'Personnel',
                'choices' => $this->getPersonnelChoices(),
            ])
            ->add('contact')
            ->add('profession')
            ->add('Valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    private function getPersonnelChoices()
    {
        $choices = User::PERSONNEL;
        $outputPer = [];
        foreach ($choices as $key => $value) {
            $outputPer[$value] = $key;
        }
        return $outputPer;
    }

    private function getChoices()
    {
        $choices = User::SEXE;
        $output = [];
        foreach ($choices as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }
}