<?php

namespace App\Controller;

use App\Entity\UserAbsenceDocument;
use App\Entity\UserAbsenceDocumentHistory;
use App\Form\UserAbsenceDocumentType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use JMS\Serializer\SerializerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Snappy\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserAbsenceDocumentController
 * @package App\Controller
 * @Rest\Route("/user-absence-document")
 * @IsGranted("ROLE_USER", statusCode=404, message="Post not found")
 */
class UserAbsenceDocumentController extends AbstractFOSRestController implements ClassResourceInterface
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
     * SurveyController constructor.
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     */
    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->em = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * List All Absence Documents belong to user
     * @Rest\Route("/list", methods={"POST", "GET"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function listAction(PaginatorInterface $paginator, Request $request)
    {
        $user = $this->getUser();

        $userAbsenceDocuments = $this->em->getRepository(UserAbsenceDocument::class)
            ->findBy(
                ['user' => $user],
                ['actualDate' => 'DESC']);

        return $this->render('user_absence_documents_list/index.html.twig', [
            'pagination' => $paginator->paginate(
                $userAbsenceDocuments, $request->query->getInt('page', 1), 5)
        ]);
    }

    /**
     * Create User Absence Document
     * @param Request $request
     * @Rest\Route("/add", methods={"POST", "GET"})
     * @return Response
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(UserAbsenceDocumentType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $absenceDoc = $form->getData();
            $absenceDoc->setUser($this->getUser());

            $this->em->persist($absenceDoc);
            $this->em->flush();

            return $this->render('user_absencedocument_pdf_layout/index.html.twig', [
                'absenceDoc' => $absenceDoc
            ]);
        }

        return $this->render('user_absence_document_add/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Delete User Absence Document
     * @Rest\Get("/{id}/delete")
     * @Rest\View()
     *
     * @param $id
     * @return
     * @throws Exception
     */
    public function deleteAction($id)
    {
        try {
            $this->em->beginTransaction();
            $this->clearAndCloneUAD($id);
            $this->em->commit();
        } catch (Exception $exception) {
            $this->em->rollback();
            throw $exception;
        }

        return [
            'id' => $id
        ];
    }

    public function clearAndCloneUAD($id)
    {
        /** @var UserAbsenceDocument $userAbsenceDocument */
        $userAbsenceDocument = $this->em->getRepository(UserAbsenceDocument::class)->find($id);
        $this->em->persist(new UserAbsenceDocumentHistory($userAbsenceDocument));
        $this->em->remove($userAbsenceDocument);
        $this->em->flush();
    }

    /**
     * Delete User Absence Document
     * @Rest\Route("{id}/pdf/download")
     * @param $id
     * @param Pdf $snappy
     * @return PdfResponse
     */
    public function downloadPdfAction($id, Pdf $snappy)
    {
        $filename = sprintf('test-%s.pdf', date('Y-m-d'));

        $userAbsenceDocument = $this->em->getRepository(UserAbsenceDocument::class)->find($id);

        $html = $this->renderView('user_absencedocument_pdf_layout/download.html.twig', [
            'absenceDoc' => $userAbsenceDocument,
            'filename' => $filename
        ]);

        return new PdfResponse(
            $snappy->getOutputFromHtml($html),
            $filename
        );
    }

    /**
     * Delete User Absence Document
     * @Rest\Route("{id}/pdf/show")
     * @param $id
     * @param Pdf $snappy
     * @return Response
     */
    public function showPdfAction($id, Pdf $snappy)
    {
        $filename = sprintf('absence_id_%s_%s.pdf', $id, date('Y-m-d'));

        $userAbsenceDocument = $this->em->getRepository(UserAbsenceDocument::class)->find($id);

        $html = $this->renderView('user_absencedocument_pdf_layout/download.html.twig', [
            'absenceDoc' => $userAbsenceDocument,
            'filename' => $filename
        ]);

        return new Response(
            $snappy->getOutputFromHtml($html), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename
            ]
        );
    }
}