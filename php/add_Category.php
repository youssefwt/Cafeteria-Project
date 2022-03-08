<?php

include "dbManager.php";
$db = new DbManager();
try{

    $db->add_Category($_REQUEST["categoryName"]);
    header("Location: ../HTML/addProduct.html");
}catch(Exception $e){
    echo $e->getMessage();
}