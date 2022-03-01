<?php

require_once("../dbManager.php");

$db = new DbManager();
$db->getProducts();
$db->close();
