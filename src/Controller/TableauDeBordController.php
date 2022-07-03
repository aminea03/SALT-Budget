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
        $currentYearMonthsDepenses = ["01" => 0, "02" => 0, "03" => 0, "04" => 0, "05" => 0, "06" => 0, "07" => 0, "08" => 0, "09" => 0, "10" => 0, "11" => 0, "12" => 0];
        $currentYearMonthsRecettes = ["01" => 0, "02" => 0, "03" => 0, "04" => 0, "05" => 0, "06" => 0, "07" => 0, "08" => 0, "09" => 0, "10" => 0, "11" => 0, "12" => 0];
        foreach ($categories as $data) {
            if ($data->getComptabilite() == "Dépense") {
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
                if ($data->getDateTransaction()->format("Y") == date("Y")) {
                    $currentYearMonthsDepenses[$data->getDateTransaction()->format("m")] =
                        $currentYearMonthsDepenses[$data->getDateTransaction()->format("m")] +
                        $data->getMontantTransaction();
                }
            } else {
                $datasetsRecettes[] = $data->getMontantTransaction();
                foreach ($recettesParCategories as $key => $value) {
                    if ($key == $data->getCategorie()) {
                        $recettesParCategories[$key]
                            =  $recettesParCategories[$key] + $data->getMontantTransaction();
                    }
                }
                if ($data->getDateTransaction()->format("Y") == date("Y")) {
                    $currentYearMonthsRecettes[$data->getDateTransaction()->format("m")] =
                        $currentYearMonthsRecettes[$data->getDateTransaction()->format("m")] +
                        $data->getMontantTransaction();
                }
            }
        }

        $currentYearMonthsDepenses = ["Janvier" => $currentYearMonthsDepenses["01"], "Février" => $currentYearMonthsDepenses["02"], "Mars" => $currentYearMonthsDepenses["03"], "Avril" => $currentYearMonthsDepenses["04"], "Mai" => $currentYearMonthsDepenses["05"], "Juin" => $currentYearMonthsDepenses["06"], "Juillet" => $currentYearMonthsDepenses["07"], "Août" => $currentYearMonthsDepenses["08"], "Septembre" => $currentYearMonthsDepenses["09"], "Octobre" => $currentYearMonthsDepenses["10"], "Novembre" => $currentYearMonthsDepenses["11"], "Décembre" => $currentYearMonthsDepenses["12"]];
        $currentYearMonthsRecettes = ["Janvier" => $currentYearMonthsRecettes["01"], "Février" => $currentYearMonthsRecettes["02"], "Mars" => $currentYearMonthsRecettes["03"], "Avril" => $currentYearMonthsRecettes["04"], "Mai" => $currentYearMonthsRecettes["05"], "Juin" => $currentYearMonthsRecettes["06"], "Juillet" => $currentYearMonthsRecettes["07"], "Août" => $currentYearMonthsRecettes["08"], "Septembre" => $currentYearMonthsRecettes["09"], "Octobre" => $currentYearMonthsRecettes["10"], "Novembre" => $currentYearMonthsRecettes["11"], "Décembre" => $currentYearMonthsRecettes["12"]];










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
            'labels' => $categoriesRecettes,
            'datasets' => [
                [
                    'label' => 'Recettes',
                    'backgroundColor' => '#009b81',
                    'data' =>  $recettesParCategories,

                ]
            ],
        ]);

        /* Détail dépenses */
        $chart2 = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart2->setData([
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

        /* Dépenses année courrante par mois */
        $chart4 = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart4->setData([
            'labels' => ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
            'datasets' => [
                [
                    'label' => 'Dépenses',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'data' =>   $currentYearMonthsDepenses

                ]
            ],
        ]);

        /* Recettes année courrante par mois */
        $chart5 = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart5->setData([
            'labels' => ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
            'datasets' => [
                [
                    'label' => 'Recettes',
                    'backgroundColor' => '#009b81',
                    'data' =>   $currentYearMonthsRecettes

                ]
            ],
        ]);




        return $this->render('tableau_de_bord/index.html.twig', [
            'croissants' => $transactionsRepository->findAll(),
            'chart1' => $chart1,
            'chart2' => $chart2,
            'chart3' => $chart3,
            'chart4' => $chart4,
            'chart5' => $chart5,
        ]);
    }
}
