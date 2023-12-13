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
        $savingsGoal = new SplapSavingsGoal();
        $form = $this->createForm(SplapFormType::class, $savingsGoal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($savingsGoal);
            $entityManager->flush();

        }

        $savingsGoals = $entityManager->getRepository(SplapSavingsGoal::class)->findAll();



        return $this->render('splap-add.html.twig', [
            'form' => $form->createView(),
            'savingsGoals' => $savingsGoals,
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
}
