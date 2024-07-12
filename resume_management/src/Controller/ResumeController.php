<?php
namespace App\Controller;

use App\Entity\Resume;
use App\Form\ResumeType;
use App\Repository\ResumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ResumeController extends AbstractController
{
    #[Route('/resumes', name: 'resume_list', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $resumes = $entityManager->getRepository(Resume::class)->findAll();

        return $this->render('resume/index.html.twig', [
            'resumes' => $resumes,
        ]);
    }

    #[Route('/resume/new', name: 'resume_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $resume = new Resume();
        $form = $this->createForm(ResumeType::class, $resume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($resume);
            $entityManager->flush();

            return $this->redirectToRoute('resume_list');
        }

        return $this->render('resume/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/resume/{id}', name: 'resume_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $resume = $entityManager->getRepository(Resume::class)->find($id);

        if (!$resume) {
            throw $this->createNotFoundException('Resume not found');
        }

        return $this->render('resume/show.html.twig', [
            'resume' => $resume,
        ]);
    }


    #[Route('/resume/{id}/edit', name: 'resume_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $resume = $entityManager->getRepository(Resume::class)->find($id);

        if (!$resume) {
            throw $this->createNotFoundException('Resume not found');
        }

        $form = $this->createForm(ResumeType::class, $resume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('resume_list');
        }

        return $this->render('resume/edit.html.twig', [
            'resume' => $resume,
            'form' => $form->createView(),
        ]);
    }



    #[Route('/resume/{id}', name: 'resume_delete', methods: ['POST'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $resume = $entityManager->getRepository(Resume::class)->find($id);

        if (!$resume) {
            throw $this->createNotFoundException('Resume not found');
        }

        $entityManager->remove($resume);
        $entityManager->flush();

        return $this->redirectToRoute('resume_list');
    }
}
