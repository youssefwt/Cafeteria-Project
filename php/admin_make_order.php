<?php
session_start();
if(!isset($_SESSION['id']) || !isset($_GET['order'])){
    header("Location:../index.html");
    return;
}
//|| $_SESSION['role'] != 'admin'
include("dbManager.php");
$order = json_decode($_GET['order']);
$db = new DbManager();
$sum = 0;
foreach ($order as $key=>$value){
    if($key == "room" || $key=="notes" || $key =="id"){
        continue;
    }
    $price = $db->get_price($key);
    if($price[0][0]) {
        $sum += $price[0][0] * $value;
    }
}

var_dump($sum);
//for ($i =0; $i < count($order) - 2;$i+=2){
//    $price = $db->get_price($order[$i]);
//    if($price) {
//        $sum += $price[0][0] * $order[$i + 1];
//    }
//}
$by_admin ="yes";
$db->user_make_order($sum, $order->id, $order->room, $order->notes, $by_admin, $order);
header("Location:../Html/users-orders.html");

