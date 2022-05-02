<?php 

class PaymentContr extends Payment{
    private $cnumber;
    private $ctitular;
    private $cmonth;
    private $cyear;
    private $ccvc; 

    public function __construct($cnumber, $ctitular, $cmonth, $cyear, $ccvc){
        $this->cnumber = $cnumber;
        $this->ctitular = $ctitular;
        $this->cmonth = $cmonth;
        $this->cyear = $cyear;
        $this->ccvc = $ccvc; 
    }

    //Method to generate Graphic Seat Plan 
    public function addPaymentInfo(){
        //execute error handling
        $this->errorHandlers("addPayment");
        $this->insertPaymentInfo($this->cnumber, $this->ctitular, $this->cmonth, $this->cyear, $this->ccvc); //add payment info 
    }

    private function errorHandlers($page){
        //Error handling for missing input 
        if($this->missingInput()){
            session_start();
            $_SESSION["message"] = "Error: Fill in all the Payment Information."; 
            header("location: ../{$page}.php?MissingPaymentInfo");
            exit();
        }
        if($this->checkMonth()){
            session_start();
            $_SESSION["message"] = "Error: Invalid month"; 
            header("location: ../{$page}.php?MissingPaymentInfo");
            exit();
        }
        if($this->isExpired()){
            session_start();
            $_SESSION["message"] = "Error: Your card is expired."; 
            header("location: ../{$page}.php?ExpiredCard");
            exit();
        }
        if($this->isValid()){
            session_start();
            $_SESSION["message"] = "Error: Your card information is invalid."; 
            header("location: ../{$page}.php?invalidCard");
            exit();
        }
    }

    //Missing Inputs
    private function missingInput(){
        $a = empty($this->cnumber);
        $b = empty($this->ctitular);
        $c = empty($this->cmonth);
        $d = empty($this->cyear);
        $e = empty($this->ccvc);


        if($a || $b || $c || $d || $e){
            return true;
        }
        return false;
    }

    //Check if invalid month
    private function checkMonth(){
        $month = $this->cmonth;

        if($month<1 || $month>12){
            return true; 
        }
        return false;
    }

     //Check if card is expired 
     private function isExpired(){
        date_default_timezone_set('America/Boise'); // change to MOUNTAIN TIME
        $currentyear = date('y'); 
        $currentmonth = date('m'); 
        $year = $this->cyear;
        $month = $this->cmonth;

        if($year<$currentyear){
            return true; 
        }
        else if($year==$currentyear && $month<$currentmonth){
            return true; 
        }
        return false;
    }   

     //Check if card is valid 
     private function isValid(){
        $ccode = $this->ccvc;
        $digits = $ccode !== 0 ? floor(log10($ccode) + 1) : 1;
        if($digits<3 || $digits>3){
            return true; 
        }

        return false;
    }       

}