<?php

namespace App\Controller;

use App\Service\Top10Vehicle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Command\CsvGeneratorCommand;
use App\Service\CsvProduction;
use App\Service\FilterTimeProduction;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Vehicle;
use App\Entity\Expense;
use App\Entity\GasStation;
use App\Repository\ExpenseRepository;

class BaseController extends AbstractController
{
    /**
     *
     * @Route("/", name="base")
     */
    public function index(CsvProduction $dataCsv,KernelInterface $appKernel,EntityManagerInterface $em,ExpenseRepository $expenseRepository): Response
    {


         $dataCsv->executeCSV($appKernel);

         /*nombre des lignes Csv*/

        $nbrRowCsv=$dataCsv->getNbrRow();

        /*validation Period*/

        $expenseBdd=$this->getDoctrine()->getManager()->getRepository('App\Entity\Expense')->findAll();

        $firstPeriodDate=$expenseBdd[array_key_first($expenseBdd)];

        $firstPeriodDateBdd= $firstPeriodDate->getIssuedOn()->format('Y-m-d H:i:s');

        /* true or false*/

        $validPeriod=$dataCsv->verifyPeriod($firstPeriodDateBdd);

        /* ok period pour Array-->Obj--->Bdd*/

        if($validPeriod==true){
            $dataone=$dataCsv->ArrayToObject($em);
        }else{
            $this->addFlash('success', 'Cette période est déjà intégré!');
        }


        /*trié fct DataTime table : Expense */

        $beginPeriodDate=$this->getDoctrine()->getRepository('App\Entity\Expense')->findBy(array(), array('issuedOn' => 'ASC'));

       /* period begin and end ASC*/

        $firstPeriodDate= $beginPeriodDate[array_key_first($beginPeriodDate)];
        $endPeriodDate= $beginPeriodDate[$nbrRowCsv-1];


        /*convert Date-->String*/

        $firstPeriodDateString =$firstPeriodDate->getIssuedOn()->format("d M Y H:i:s ");
        $endPeriodDateString=$endPeriodDate->getIssuedOn()->format('d M Y H:i:s');


        return $this->render('base/index.html.twig', [
            'nbrRowCsv' =>  $nbrRowCsv,
            'debutPeriode' =>  $firstPeriodDateString,
            'finPeriode' =>  $endPeriodDateString ,
        ]);
    }
}
