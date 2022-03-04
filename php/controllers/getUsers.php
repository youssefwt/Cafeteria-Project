<?php
include "../dbManager.php";
$d1 = new DbManager();
$d1->SELECTUSERS();
$d1->close();
?>