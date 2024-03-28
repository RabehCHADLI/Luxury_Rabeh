<?php

namespace App\Form;

use App\Entity\Candidat;
use App\Entity\Experience;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'choices'  => [
                    'Choose an option...' => null,
                    'Female' => true,
                    'Male' => true,
                    'Undefined' => true,
                ],
                'label' => false
            ])
            ->add('firstName')
            ->add('lastName')
            ->add('adress')
            ->add('country')
            ->add('nationality')
            ->add('passport', CheckboxType::class, [
                'label'    => 'Show this entry publicly?'
            ])
            ->add('passportFile')
            ->add('profilPicture')
            ->add('curriculumVitae')
            ->add('currentLocation')
            ->add('dateOfBirth')
            ->add('email')
            ->add('availability', null, [
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('notes')
            ->add('file')
            ->add('experience', EntityType::class, [
                'class' => Experience::class,
                'choice_label' => 'name',
                'attr' => [
                    'style' => 'display: block'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
