<?php

namespace App\Form;

use App\Entity\Position;
use LogicException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

/**
 * Class UserType
 * @package App\Form
 */
class UserType extends AbstractType
{

    /**
     * @var Security
     */
    private $security;

    /**
     * UserType constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $user = $this->security->getUser();
            if (!$user) {
                throw new LogicException(
                    'The EditUserFormType cannot be used without an authenticated user!'
                );
            }

            $form = $event->getForm();

            $form->add(
                '_password', RepeatedType::class, [
                    'required' => false,
                    'type' => PasswordType::class,
                    'first_options' => array(
                        'label' => 'Password',
                        'attr' => [
                            'placeholder' => 'Password'
                        ]),
                    'second_options' => array(
                        'label' => false,
                        'attr' => [
                            'placeholder' => 'Confirm Password'
                        ]
                    )
                ]
            );
            $form->add(
                'position', EntityType::class, [
                    'class' => Position::class,
                    'property_path' => 'position',
                    'choice_label' => 'name',
                    'data' => $user->getPosition(),
                    'group_by' => function ($choice, $key, $value) {
                        return $choice->getDepartment()->getName();
                    }
                ]
            );

            $form->add('save', SubmitType::class, [
                'label' => 'Save'
            ]);
            $form->add('reset', ResetType::class, [
                'label' => 'Reset'
            ]);
        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'App\Model\User\EditUser',
            'csrf_protection' => false
        ]);
    }
}
