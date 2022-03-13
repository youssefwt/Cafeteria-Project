<?php
session_start();
if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    require_once("../dbManager.php");
    $db = new DbManager();
    $db->getLastProductsOrdered($userId);
    $db->close();
}
