<?php

require_once("../dbManager.php");

$db = new DbManager();
$db->getUsersTotal();
$db->close();
