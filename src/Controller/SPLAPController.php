<?php

namespace App\Controller;

use App\Repository\SplapSavingsGoalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\SplapSavingsGoal;
use App\Form\SplapFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class SPLAPController extends AbstractController
{
    #[Route('/', name: 'splap_add')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $color = '#C8FACD';
        $savingsGoal = new SplapSavingsGoal();
        $form = $this->createForm(SplapFormType::class, $savingsGoal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $color = $request->request->get('color');

            $entityManager->persist($savingsGoal);
            $entityManager->flush();
            $savingsGoal = new SplapSavingsGoal();
            $form = $this->createForm(SplapFormType::class, $savingsGoal);

        }

        $savingsGoals = $entityManager->getRepository(SplapSavingsGoal::class)->findAll();



        return $this->render('splap-add.html.twig', [
            'form' => $form->createView(),
            'savingsGoals' => $savingsGoals,
            'color' => $color,
        ]);
    }

    #[Route('/delete/{id}', name: 'splap_delete', methods: ['POST'])]
    public function delete($id, EntityManagerInterface $entityManager): Response
    {
        $savingsGoal = $entityManager->getRepository(SplapSavingsGoal::class)->find($id);

        if ($savingsGoal) {
            $entityManager->remove($savingsGoal);
            $entityManager->flush();
        }

        return new JsonResponse(['status' => 'success']);
    }

    #[Route('/card/{id}', name: 'card_detail', methods: ['GET'])]
    public function cardDetail($id, EntityManagerInterface $entityManager): Response
    {
        $savingsGoal = $entityManager->getRepository(SplapSavingsGoal::class)->find($id);

        return $this->render('card_detail.html.twig', [
            'savingsGoal' => $savingsGoal,
        ]);
    }

    #[Route('/edit/{id}', name: 'splap_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $savingsGoal = $entityManager->getRepository(SplapSavingsGoal::class)->find($id);

        if (!$savingsGoal) {
            throw $this->createNotFoundException('The savings goal does not exist');
        }

        $form = $this->createForm(SplapFormType::class, $savingsGoal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('splap_add');
        }

        return $this->render('splap-edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
