<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class TableauDeBordController extends AbstractController
{
    #[Route('/tableau_de_bord', name: 'app_tableau_de_bord')]

    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);


        return $this->render('tableau_de_bord/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
