<?php
if (!empty($_GET["productId"])) {
    $productId = $_GET["productId"];
    require_once("../dbManager.php");
    $db = new DbManager();
    $db->getProductById($productId);
    $db->close();
}
