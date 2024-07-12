<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CompanyController extends AbstractController
{
    #[Route('/companies', name: 'company_list', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $companies = $entityManager->getRepository(Company::class)->findAll();

        return $this->render('company/index.html.twig', [
            'companies' => $companies,
        ]);
    }

    #[Route('/company/new', name: 'company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('company_list');
        }

        return $this->render('company/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/company/{id}', name: 'company_show', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $company = $entityManager->getRepository(Company::class)->find($id);

        if (!$company) {
            throw $this->createNotFoundException('Company not found');
        }

        return $this->render('company/show.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/company/{id}/edit', name: 'company_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $company = $entityManager->getRepository(Company::class)->find($id);

        if (!$company) {
            throw $this->createNotFoundException('Company not found');
        }

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('company_list');
        }

        return $this->render('company/edit.html.twig', [
            'form' => $form->createView(),
            'company' => $company,
        ]);
    }

    #[Route('/company/{id}', name: 'company_delete', methods: ['POST'])]
    public function delete(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $company = $entityManager->getRepository(Company::class)->find($id);

        if (!$company) {
            throw $this->createNotFoundException('Company not found');
        }

        $entityManager->remove($company);
        $entityManager->flush();

        return $this->redirectToRoute('company_list');
    }
}

