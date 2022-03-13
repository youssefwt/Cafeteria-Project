<?php

$errors =[];

if (empty($_REQUEST["productName"])&& $_REQUEST["productName"]=="") {
    $errors['productName']="productName_is_empty";
}
// var_dump($_FILES);
$file_name = $_FILES['img']['name'];
 var_dump($file_name);
$file_tmp =$_FILES['img']['tmp_name'];
$file_type=$_FILES['img']['type'];

$extention = explode("/", $file_type)[1];
var_dump($extention);

$extensions= array("jpeg","jpg","png", "gif");

if (in_array($extention, $extensions)=== false) {
    $errors["file"]="extension not allowed, please choose a JPEG, jpg, gif or PNG file.";
}

$str="addProduct.php?";
if (count($errors)>0) {
    foreach ($errors as $k=>$val) {
        $str.=$k."=".$val."&";
    }
    header("Location: $str");
    return;
}

echo"<br>";


$the_picture = $_REQUEST["productName"].".".$extention;
var_dump($the_picture);


move_uploaded_file($file_tmp, "../assets/images/test-images/".$_REQUEST["productName"].".".$extention);

include("dbManager.php");

$db = new DbManager();

try {
   
    $db->addProduct($_REQUEST['productName'], $_REQUEST['Price'], $the_picture, $_REQUEST['status']);
    header("Location: product_table.php");
   
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
