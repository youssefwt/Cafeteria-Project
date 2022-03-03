<?php
if (!empty($_GET["userId"])) {
    $userId = $_GET["userId"];
    require_once("../dbManager.php");
    $db = new DbManager();
    $db->getOrdersByUser($userId);
    $db->close();
}
