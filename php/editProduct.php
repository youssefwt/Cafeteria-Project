<?php

$file_name = $_FILES['img']['name'];
// var_dump($file_name);
$file_tmp =$_FILES['img']['tmp_name'];
// var_dump($file_tmp);
$file_type=$_FILES['img']['type'];

$extention = explode("/", $file_type)[1];
var_dump($extention);

$extensions= array("jpeg","jpg","png", "gif");

$the_picture = $_REQUEST["productName"].".".$extention;
// var_dump($the_picture);

move_uploaded_file($file_tmp, "../assets/images/products/".$_POST["productName"].".".$extention);

include("dbManager.php");

$db = new DbManager();

try {
   var_dump($_POST);
$the_old_img=$db->fetch_img($_POST['productId']);
unlink("../assets/images/test-images/$the_old_img");
$the_picture =$_POST['productName'].".".$extention;
    
    $db->update_Table("products", $_POST['productId'], "name", $_POST['productName'], "Price", $_POST['Price'],  "image_url", $the_picture,"category_name",$_POST["category_name"] );
header("Location: ../HTML/product_table.html");

   
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>