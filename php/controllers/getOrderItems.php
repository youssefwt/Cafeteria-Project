<?php
if (!empty($_GET["orderId"])) {
    $orderId = $_GET["orderId"];
    require_once("../dbManager.php");
    $db = new DbManager();
    $db->getOrderItems($orderId);
    $db->close();
}
