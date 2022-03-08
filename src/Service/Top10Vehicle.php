<?php


namespace App\Service;


class Top10Vehicle
{   private $arrayVehicleExpense=[];

    public function SumAmountVehicle($arrayVehicle, $arrayExpense)
    {
        $event_name=0;
        $amountSumHT=0;
        $amountSumTTC=0;
        $keyvehicle=0;
        foreach ($arrayVehicle as $key1 =>$result1) {

            foreach ($arrayExpense as $key2 => $result2) {

                    $event_name_mark = $result1->getBrand().':'. $event_model = $result1->getModel();
                    $event_plate = $result1->getPlateNumber();
                    $amountSumHT = $amountSumHT + $result2->getValueTe();
                    $amountSumTTC = $amountSumTTC + $result2->getValueTi();

                    $this->arrayVehicleExpense[ $keyvehicle]["brandmodel"] = $event_name_mark;
                    $this->arrayVehicleExpense[ $keyvehicle]["platenumber"] = $event_plate;
                    $this->arrayVehicleExpense[ $keyvehicle]["amountHT"] = $amountSumHT;
                    $this->arrayVehicleExpense[ $keyvehicle]["amountTTC"] = $amountSumTTC;
                    $keyvehicle=$keyvehicle+1;
            }

        }

        return  $this->arrayVehicleExpense;
    }

    public function sortTenCustomers($arrayCustomerNet)
    {
        usort($arrayCustomerNet, function ($item1, $item2) {return $item2->getValueTe() > $item1->getValueTe();});

        return $arrayCustomerNet;
    }
    public function sortFiveCustomersMoreTransaction($arrayCustomerNet)
    {
        usort($arrayCustomerNet, function ($item1, $item2) {return $item2["count"]  > $item1["count"];});
        //dd($arrayListCustomer);
        return $arrayCustomerNet;
    }

}