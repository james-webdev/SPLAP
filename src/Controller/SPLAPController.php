<?php

namespace App\Controller;

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

    #[Route('/show', name: 'splap_show')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $savingsGoals = $entityManager->getRepository(SplapSavingsGoal::class)->findBy(['user' => $this->getUser()]);

        return $this->render('splap-show.html.twig', [
            'savingsGoals' => $savingsGoals,
        ]);
    }
    #[Route('/add', name: 'splap_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $color = '#C8FACD';
        $savingsGoal = new SplapSavingsGoal();
        $form = $this->createForm(SplapFormType::class, $savingsGoal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $color = $request->request->get('color');
            $savingsGoal->setUser($this->getUser());

            $entityManager->persist($savingsGoal);
            $entityManager->flush();
            $savingsGoal = new SplapSavingsGoal();
            $form = $this->createForm(SplapFormType::class, $savingsGoal);
            return $this->redirectToRoute('splap_show');
        }

        return $this->render('splap-add.html.twig', [
            'form' => $form->createView(),
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

            return $this->redirectToRoute('splap_show');
        }

        return $this->render('splap-edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
