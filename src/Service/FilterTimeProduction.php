<?php


namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Entity\Expense;
use App\Entity\Vehicle;
use App\Entity\GasStation;
use Symfony\Component\Validator\Constraints\DateTime;
use CrEOF\Spatial\PHP\Types\Geometry\Point;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Command\CsvGeneratorCommand;
use App\Service\CsvProduction;
use App\Repository\ExpenseRepository;


class FilterTimeProduction
{
    private $dataExpense=[];
    private $categoryArray=[];
    private $expenseArray=[];
    private  $sommeHT=0;
    private  $sommeTVA=0;
    private  $sommeTTC=0;
    private $arrayVehicleExpense=[];
    private $keyn;


    public function getFilter($date_begin,$date_end,$categoryArray){

                $this->categoryArray=$categoryArray;
                $secTimeBegin=$this->procesDate($date_begin);
                $sectTimeEnd=$this->procesDate($date_end);


        foreach ($categoryArray as $key1 =>$result1) {

            $timeStringBDD =$result1->getIssuedOn()->format('Y-m-d');

            $sectimeBdd1=$this->getDiffTimeNow($timeStringBDD);


            if($sectimeBdd1<=$secTimeBegin AND $sectimeBdd1>=$sectTimeEnd){

                $this->sommeHT = $this->sommeHT+$result1->getValueTe();
                $this->sommeTVA=$this->sommeTVA+$result1->getTaxRate();
                $this->sommeTTC= $this->sommeTTC+$result1->getValueTi();
            }
        }



                $this->dataExpense[0]=$this->sommeHT;
                $this->dataExpense[1]=$this->sommeTVA;
                $this->dataExpense[2]=$this->sommeTTC;

        return $this->dataExpense;
    }

    public function getFilterCategory($date_begin,$date_end,$category_value,$categoryArray){

                $this->categoryArray=$categoryArray;
                $secTimeBegin=$this->procesDate($date_begin);
                $sectTimeEnd=$this->procesDate($date_end);

        foreach ($categoryArray as $key1 =>$result1) {

          if($result1->getCategory()==$category_value){

                  $timeStringBDD =$result1->getIssuedOn()->format('Y-m-d');

                  $sectimeBdd1=$this->getDiffTimeNow($timeStringBDD);

            if($sectimeBdd1<=$secTimeBegin AND $sectimeBdd1>=$sectTimeEnd){

                  $this->sommeHT = $this->sommeHT+$result1->getValueTe();
                  $this->sommeTVA=$this->sommeTVA+$result1->getTaxRate();
                  $this->sommeTTC= $this->sommeTTC+$result1->getValueTi();

              }


          }

        }

                 $this->dataExpense[0]=$this->sommeHT;
                 $this->dataExpense[1]=$this->sommeTVA;
                 $this->dataExpense[2]=$this->sommeTTC;
                 $this->dataExpense[3]=$category_value;


        return $this->dataExpense;
    }

    public function getVehicleFilter($expenseArray){

                $this->expenseArray= $expenseArray;



        foreach ($this->expenseArray as $key1 =>$result1) {

                $this->constructArrayVehicle($result1);

        }


        // dd($this->arrayVehicleExpense);
        return $this->arrayVehicleExpense;
    }



    public function constructArrayVehicle($result)
    {

               $this->keyn=$this->keyn+1;
               $this->arrayVehicleExpense[$this->keyn]=$result;

    }

    public function sortTenCustomers($arrayCustomerNet)
    {

                usort($arrayCustomerNet, function ($item1, $item2) {return $item2["amount"]  > $item1["amount"];});

        return $arrayCustomerNet;
    }
    public function sortFiveCustomersMoreTransaction($arrayCustomerNet)
    {
               usort($arrayCustomerNet, function ($item1, $item2) {return $item2["count"]  > $item1["count"];});
        //dd($arrayListCustomer);
        return $arrayCustomerNet;
    }


   public function procesDate($date_input){

               $dataArray=explode("/", $date_input); // step 1

               $timeInvers=$this->inversDayMonthYear($dataArray); // step 2

               $timeRecompose=$this->recomposeArrayToString($timeInvers); // step 3

               $getDiffTime=$this->getDiffTimeNow($timeRecompose); // step 4

       return $getDiffTime;
   }

    public function inversDayMonthYear($dataArray){

              $intermed=$dataArray[2];
              $dataArray[2]=$dataArray[0];
              $dataArray[0]=$intermed;

        return $dataArray;

    }

    public function  recomposeArrayToString($dataArray){

              $dataString=$dataArray[0].'-'.$dataArray[1].'-'.$dataArray[2];

        return $dataString;

    }

    public function  getDiffTimeNow($tData){

              $secDiffData=time()-strtotime($tData);

        return $secDiffData;

    }



}