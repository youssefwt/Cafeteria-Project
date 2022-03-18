<?php

require_once("../dbManager.php");

$start = $_GET["start"];
$end = $_GET["end"];

$db = new DbManager();
$db->getUsersTotal($start, $end);
$db->close();
