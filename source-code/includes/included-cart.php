<?php
//Instantiate auth classes 
include "classes/db.class.php";
include "classes/seat.class.php";
include "classes/seat-view.class.php";


if(isset($_SESSION["userid"])){
    $cart = new SeatView(0);
    $cart->setCart();
    $count = $cart->getCount();



}
