<?php

require_once("../dbManager.php");

$db = new DbManager();
$db->SELECTUSERS();
$db->close();
?>