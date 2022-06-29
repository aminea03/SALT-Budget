<?php

namespace App\Controller;

use App\Entity\Transactions;
use App\Form\Transactions1Type;
use App\Repository\TransactionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transactions')]

class TransactionsController extends AbstractController
{



    #[Route('/', name: 'app_transactions_index', methods: ['GET'])]

    public function index(TransactionsRepository $transactionsRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $userId = $this->getUser()->getId();
        return $this->render('transactions/index.html.twig', [
            'transactions' => $transactionsRepository->findBy(array("user" => $userId))

        ]);
    }

    #[Route('/new', name: 'app_transactions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TransactionsRepository $transactionsRepository): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');
        $transaction = new Transactions();
        $form = $this->createForm(Transactions1Type::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transaction->setUser($this->getUser());
            $transactionsRepository->add($transaction, true);

            return $this->redirectToRoute('app_transactions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transactions/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_transactions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transactions $transaction, TransactionsRepository $transactionsRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $form = $this->createForm(Transactions1Type::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionsRepository->add($transaction, true);

            return $this->redirectToRoute('app_transactions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transactions/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transactions_delete', methods: ['POST'])]
    public function delete(Request $request, Transactions $transaction, TransactionsRepository $transactionsRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($this->isCsrfTokenValid('delete' . $transaction->getId(), $request->request->get('_token'))) {
            $transactionsRepository->remove($transaction, true);
        }

        return $this->redirectToRoute('app_transactions_index', [], Response::HTTP_SEE_OTHER);
    }
}
