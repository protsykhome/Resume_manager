<?php

namespace App\Controller;

use App\Entity\ResumeFeedback;
use App\Entity\Resume;
use App\Entity\Company;
use App\Form\ResumeFeedbackType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResumeFeedbackController extends AbstractController
{
    #[Route('/resume/feedback/choose', name: 'resume_feedback_choose', methods: ['GET', 'POST'])]
    public function choose(Request $request, EntityManagerInterface $entityManager): Response
    {
        $feedback = new ResumeFeedback();
        $form = $this->createForm(ResumeFeedbackType::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resumeId = $request->request->get('resume_id');
            $companyId = $request->request->get('company_id');

            $resume = $entityManager->getRepository(Resume::class)->find($resumeId);
            $company = $entityManager->getRepository(Company::class)->find($companyId);

            if ($resume && $company) {
                $feedback->setResume($resume);
                $feedback->setCompany($company);
                $feedback->setFeedbackType(true);
                $entityManager->persist($feedback);
                $entityManager->flush();

                return $this->redirectToRoute('resume_feedback_list');
            } else {
                $this->addFlash('error', 'Invalid resume or company');
            }
        }

        $resumes = $entityManager->getRepository(Resume::class)->findAll();
        $companies = $entityManager->getRepository(Company::class)->findAll();

        return $this->render('resumefeedback/choose.html.twig', [
            'form' => $form->createView(),
            'resumes' => $resumes,
            'companies' => $companies,
        ]);
    }

    #[Route('/feedbacks', name: 'resume_feedback_list', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $feedbacks = $entityManager->getRepository(ResumeFeedback::class)->findAll();

        return $this->render('resumefeedback/index.html.twig', [
            'feedbacks' => $feedbacks,
        ]);
    }

    #[Route('/resume/feedback/{id}', name: 'resume_feedback_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $feedback = $entityManager->getRepository(ResumeFeedback::class)->find($id);

        if (!$feedback) {
            throw $this->createNotFoundException('Feedback not found');
        }

        return $this->render('resumefeedback/show.html.twig', [
            'feedback' => $feedback,
        ]);
    }

    #[Route('/resume/feedback/{id}/edit', name: 'resume_feedback_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $feedback = $entityManager->getRepository(ResumeFeedback::class)->find($id);

        if (!$feedback) {
            throw $this->createNotFoundException('Feedback not found');
        }

        $form = $this->createForm(ResumeFeedbackType::class, $feedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('resume_feedback_list');
        }

        return $this->render('resumefeedback/edit.html.twig', [
            'form' => $form->createView(),
            'feedback' => $feedback,
        ]);
    }

    #[Route('/resume/feedback/{id}', name: 'resume_feedback_delete', methods: ['DELETE', 'POST'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $feedback = $entityManager->getRepository(ResumeFeedback::class)->find($id);

        if (!$feedback) {
            throw $this->createNotFoundException('Feedback not found');
        }

        $entityManager->remove($feedback);
        $entityManager->flush();

        return $this->redirectToRoute('resume_feedback_list');
    }

    #[Route('/feedbacks', name: 'feedbacks_statistics', methods: ['GET'])]
    public function statistics(Request $request, EntityManagerInterface $entityManager): Response
    {
        $resumes = $entityManager->getRepository(Resume::class)->findAll();
        $selectedResumeId = $request->query->get('resume_id');

        $approvalCount = 0;
        if ($selectedResumeId) {
            $approvalCount = $entityManager->getRepository(ResumeFeedback::class)->count([
                'resume' => $selectedResumeId,
                'feedback_type' => 'positive',
            ]);
        }

        return $this->render('resumefeedback/statistics.html.twig', [
            'resumes' => $resumes,
            'approvalCount' => $approvalCount,
            'selectedResumeId' => $selectedResumeId,
        ]);
    }

}
