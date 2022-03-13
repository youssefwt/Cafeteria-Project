<?php
if (!empty($_GET["userId"])) {

    $start = $_GET["start"];
    $end = $_GET["end"];

    $userId = $_GET["userId"];
    require_once("../dbManager.php");
    $db = new DbManager();
    $db->getOrdersByUser($userId, $start, $end);
    $db->close();
}
