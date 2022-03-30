<?php

require_once("../dbManager.php");

$db = new DbManager();
$db->getavailProducts();
$db->close();

?>
