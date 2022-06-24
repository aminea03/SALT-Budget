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
        return $this->render('transactions/index.html.twig', [
            'transactions' => $transactionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_transactions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TransactionsRepository $transactionsRepository): Response
    {
        $transaction = new Transactions();
        $form = $this->createForm(Transactions1Type::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionsRepository->add($transaction, true);

            return $this->redirectToRoute('app_transactions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transactions/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transactions_show', methods: ['GET'])]
    public function show(Transactions $transaction): Response
    {
        return $this->render('transactions/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transactions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transactions $transaction, TransactionsRepository $transactionsRepository): Response
    {
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
        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->request->get('_token'))) {
            $transactionsRepository->remove($transaction, true);
        }

        return $this->redirectToRoute('app_transactions_index', [], Response::HTTP_SEE_OTHER);
    }
}
