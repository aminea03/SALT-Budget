<?php

namespace App\Controller;


use App\Repository\CategoriesRepository;
use App\Repository\TransactionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use App\Entity\Transactions;
use App\Form\Transactions1Type;




class TableauDeBordController extends AbstractController
{
    #[Route('/tableau_de_bord', name: 'app_tableau_de_bord')]

    public function index(TransactionsRepository $transactionsRepository, CategoriesRepository $categoriesRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $userId = $this->getUser()->getId();
        $labels = [];
        $datasetsDepenses = [];
        $datasetsRecettes = [];
        $categories = $categoriesRepository->findAll();
        $nbCategoriesDepense = 0;
        $nbCategoriesRecettes = 0;
        $transactions =
            $transactionsRepository->findBy(array("user" => $userId));
        $categoriesDepenses = [];
        $categoriesRecettes = [];
        foreach ($categories as $data) {
            if ($data->getComptabilite() == "dépense") {
                $categoriesDepenses[] = $data->getNomCategorie();
                $nbCategoriesDepense++;
            } else {
                $categoriesRecettes[] = $data->getNomCategorie();
                $nbCategoriesRecettes++;
            }
        }

        $depensesParCategories = array_flip($categoriesDepenses);
        foreach ($depensesParCategories as $key => $data) {
            $depensesParCategories[$key] = 0;
        }
        $recettesParCategories = array_flip($categoriesRecettes);
        foreach ($recettesParCategories as $key => $data) {
            $recettesParCategories[$key] = 0;
        }

        foreach ($transactions as $data) {
            if (in_array($data->getCategorie(), $categoriesDepenses)) {
                $datasetsDepenses[] = $data->getMontantTransaction();
                foreach ($depensesParCategories as $key => $value) {
                    if ($key == $data->getCategorie()) {
                        $depensesParCategories[$key]
                            =  $depensesParCategories[$key] + $data->getMontantTransaction();
                    }
                }
            } else {
                $datasetsRecettes[] = $data->getMontantTransaction();
                foreach ($recettesParCategories as $key => $value) {
                    if ($key == $data->getCategorie()) {
                        $recettesParCategories[$key]
                            =  $recettesParCategories[$key] + $data->getMontantTransaction();
                    }
                }
            }
        }







        /* Total dépenses / recettes */
        $chart1 = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        $chart1->setData([
            'labels' => ["Dépenses", "Recettes"],
            'datasets' => [
                [
                    'backgroundColor' => ['rgb(255, 99, 132)', '#009b81'],
                    'data' => [array_sum($datasetsDepenses), array_sum($datasetsRecettes)],

                ]
            ],
        ]);

        /* Détail dépenses */
        $chart2 = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart2->setData([
            'title' => "Hello",
            'labels' => $categoriesDepenses,
            'datasets' => [
                [
                    'label' => 'Dépenses',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' =>  $depensesParCategories,

                ]
            ],
        ]);

        /* Détail recettes */
        $chart3 = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart3->setData([
            'title' => "Hello",
            'labels' => $categoriesRecettes,
            'datasets' => [
                [
                    'label' => 'Recettes',
                    'backgroundColor' => '#009b81',
                    'data' =>  $recettesParCategories,

                ]
            ],
        ]);




        return $this->render('tableau_de_bord/index.html.twig', [
            'croissants' => $transactionsRepository->findAll(),
            'chart1' => $chart1,
            'chart2' => $chart2,
            'chart3' => $chart3,
        ]);
    }
}
