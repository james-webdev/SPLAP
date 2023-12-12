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
}
