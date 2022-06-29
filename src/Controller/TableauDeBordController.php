<?php

<?php

namespace App\Controller;

use App\Entity\Transactions;
use App\Repository\CategoriesRepository;
use App\Repository\TransactionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class TableauDeBordController extends AbstractController
{
    #[Route('/tableau_de_bord', name: 'app_tableau_de_bord')]

    public function index(TransactionsRepository $transactionsRepository, CategoriesRepository $categoriesRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $labels = [];
        $datasets = [];
        $categories = $categoriesRepository->findAll();
        $transactions = $transactionsRepository->findAll();
        foreach ($categories as $data) {
            if ($data->getComptabilite() == "1") {
                $categoriesDepenses[] = $data->getNomCategorie();
            } else {
                $categoriesRecettes[] = $data->getNomCategorie();
            }
        }

        foreach ($transactions as $data) {
            $labels[] = $data->getDateTransaction()->format('d-m-Y');
            if (in_array($data->getCategorie(), $categoriesDepenses)) {
                $datasets[] = $data->getMontantTransaction();
            }
        }
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $datasets,

                ]
            ],
        ]);
        return $this->render('tableau_de_bord/index.html.twig', [
            'croissants' => $transactionsRepository->findAll(),
            'chart' => $chart,
        ]);
    }
}
