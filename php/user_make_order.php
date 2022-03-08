<?php

include("dbManager.php");
$order = explode(",",$_GET['order']);
$db = new DbManager();
$sum = 0;
for ($i =0; $i < count($order) - 2;$i+=2){
    $price = $db->get_price($order[$i]);
    if($price) {
        $sum += $price[0][0] * $order[$i + 1];
    }
}
session_start();
$db->user_make_order($sum, $_SESSION['id'], $order[count($order)-1], $order);

