<?php

include "dbManager.php";
$db = new DbManager();
try{

    $db->delete_Record("products", $_REQUEST["id"]);
    header("Location: ../HTML/product_table.html");
}catch(Exception $e){
    echo $e->getMessage();
}