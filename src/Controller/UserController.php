<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Model\User\EditUser;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserAbsenceDocumentController
 * @package App\Controller
 * @Rest\Route("/user")
 * @IsGranted("ROLE_USER", statusCode=404, message="Post not found")
 */
class UserController extends AbstractFOSRestController implements ClassResourceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * SurveyController constructor.
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $entityManager;
        $this->serializer = $serializer;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     * @Rest\Get("/edit")
     */
    public function editAction(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, new EditUser($user));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->ifEditUser($user, $form->getData());
            $this->em->persist($user);
            $this->em->flush();
        }

        return $this->render('user_edit/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param User $user
     * @param EditUser $editUser
     */
    public function ifEditUser(User $user, EditUser $editUser): void
    {
        if ($editUser->getPassword()) {
            if ($user->getPassword() !== $editUser->getPassword()) {
                $user->setPassword($this->passwordEncoder->encodePassword(
                    $user, $editUser->getPassword()
                ));
            }
        }
        if ($user->getPosition() !== $editUser->getPosition()) {
            $user->setDepartment($editUser->getPosition()->getDepartment());
            $user->setPosition($editUser->getPosition());
        }
    }
}
