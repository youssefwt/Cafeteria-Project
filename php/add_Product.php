<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);


$file_name = $_FILES['img']['name'];

$file_tmp =$_FILES['img']['tmp_name'];
$file_type=$_FILES['img']['type'];

$extention = explode("/", $file_type)[1];

$extensions= array("jpeg","jpg","png", "gif");

$the_picture = $_REQUEST["productName"].".".$extention;
var_dump($the_picture);

move_uploaded_file($file_tmp, "../assets/images/products/".$_POST["productName"].".".$extention);

include("dbManager.php");



$db = new DbManager();

var_dump($_POST);
try {
   
    $db->addProduct($_POST['productName'], $_POST['Price'], $the_picture, $_POST['category_name']);
    header("Location:../HTML/product_table.html");
   
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>