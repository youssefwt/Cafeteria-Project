<?php

if (!empty($_GET["orderId"]) && !empty($_GET["status"])) {

    $orderId = $_GET["orderId"];
    $status = $_GET["status"];
    require_once("../dbManager.php");
    $db = new DbManager();
    $db->changeOrderStatus($status, $orderId);
    $db->close();
}
