<?php

namespace App\Form;

use App\Entity\Absence;
use App\Entity\UserAbsenceDocument;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserAbsenceDocumentType
 * @package App\Form
 */
class UserAbsenceDocumentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_from', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('date_to', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('absence', EntityType::class, [
                'class' => Absence::class,
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save'
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserAbsenceDocument::class,
        ]);
    }
}
