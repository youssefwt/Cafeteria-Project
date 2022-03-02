<?php 
include "dbManager.php";
$d1 = new DbManager();
$stmt = $d1->DELETEUSER($_REQUEST["id"]);
if ($stmt->rowCount()) {
    header("Location: FillUsersTable.php");
}




?>