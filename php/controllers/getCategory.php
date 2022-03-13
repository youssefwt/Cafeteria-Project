<?php

require_once("../dbManager.php");

$db = new DbManager();

$db->get_All_Category();

$db->close();

?>
