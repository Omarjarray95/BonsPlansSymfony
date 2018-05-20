<?php

namespace GrapheBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
class DefaultController extends Controller
{
    public function PieAction()
    {
            $em=$this->getDoctrine()->getManager();
            $users=$em->getRepository('MainBundle:User')->findAll();
            $events=$em->getRepository('MainBundle:Evenement')->findAll();
            $offers=$em->getRepository('MainBundle:Offre')->findAll();
            $nbr_offres=count($offers);
            $nbr_events=count($events);
            $nbr_users=count($users);


            $pieChart = new PieChart();
            $ColumChart=new ColumnChart();
            $ColumChart2=new ColumnChart();
            $etablissements = $em->getRepository("MainBundle:Etablissement")->findAll();
            $nbr_visits_total=count($em->getRepository('MainBundle:Visited')->findAll());
            $nbr_likes_total=count($em->getRepository('MainBundle:Wishliste')->findAll());
            $totalEtab=count($etablissements);
            $types=array('Restaurants/Cafés','Shops','hotels','Autres');

            $data= array();
            $stat=['Type établissement', 'Nombre établissement par type'];
            $nb=0;
            array_push($data,$stat);

            $data2= array();
            $stat2=['Type établissement', 'Nombre de visites'];
            $nb2=0;
            array_push($data2,$stat2);

            $data3= array();
            $stat3=['Type établissement', 'Nombre de likes'];
            $nb3=0;
            array_push($data3,$stat3);



        foreach($types as $type) {
                $stat=array();

                array_push($stat,$type,$em->getRepository("MainBundle:Etablissement")->NbrParType($type)*100/$totalEtab);

                $nb=$em->getRepository("MainBundle:Etablissement")->NbrParType($type)*100/$totalEtab;
                $stat=[$type,$nb];
                array_push($data,$stat);

            }

        foreach($types as $type) {
            $stat2=array();

            array_push($stat2,$type,$em->getRepository("MainBundle:Etablissement")->NbrVisitesParType($type)*100/$nbr_visits_total);

            $nb=$em->getRepository("MainBundle:Etablissement")->NbrVisitesParType($type)*100/$nbr_visits_total;
            $stat2=[$type,$nb];
            array_push($data2,$stat2);

        }
        foreach($types as $type) {
            $stat3=array();

            array_push($stat2,$type,$em->getRepository("MainBundle:Etablissement")->NbrLikesParType($type)*100/$nbr_likes_total);

            $nb=$em->getRepository("MainBundle:Etablissement")->NbrLikesParType($type)*100/$nbr_likes_total;
            $stat3=[$type,$nb];
            array_push($data3,$stat3);

        }
            $ColumChart->getData()->setArrayToDataTable(
                $data2);
            $ColumChart2->getData()->setArrayToDataTable(
                $data3);
            $pieChart->getData()->setArrayToDataTable(
                $data
            );
            $ColumChart->getOptions()->setHeight(500);
            $ColumChart->getOptions()->setWidth(450);
            $ColumChart->getOptions()->getLegend()->setPosition('top');
            $pieChart->getOptions()->setHeight(500);
            $pieChart->getOptions()->setWidth(900);
            $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
            //$pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
         //   $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
            $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
            $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@Main/Default/Dash.html.twig',
            array('colchart'=>$ColumChart,'colchart2'=>$ColumChart2,'piechart' => $pieChart,'users'=>$nbr_users,'etabs'=>$totalEtab,'offres'=>$nbr_offres,'events'=>$nbr_events));
    }
}
