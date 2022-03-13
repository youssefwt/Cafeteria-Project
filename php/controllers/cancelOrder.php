<?php
require_once("../dbManager.php");

if (!empty($_GET["orderId"])) {
    $orderId=$_GET["orderId"];
    $db = new DbManager();
    $db->cancelUserOrder($orderId);
    $db->close();
}