<?php
include "dbManager.php";
$errors = [];

if (empty($_REQUEST["firstname"]) && $_REQUEST["firstname"] == "") {
    $errors['firstname'] = "FirstName_is_empty";
}
if (empty($_REQUEST["lastname"]) && $_REQUEST["lastname"] == "") {
    $errors['lastname'] = "LastName_is_empty";
}

if (empty($_REQUEST["password"]) || $_REQUEST["password"] == "") {
    $errors["password"] = "password_is_empty";
}

// $pass_pattern = "/^[a-z0-9_]{8}$/";

// if (!preg_match_all($pass_pattern, $_REQUEST["password"], $matches)) {
//     $errors["invalidpassword"] = "invalid_password";
// }

if (empty($_REQUEST["confirmpassword"]) && $_REQUEST["confirmpassword"] == "") {
    $errors['confirmpassword'] = "confirmpassword_is_empty";
}

if ($_REQUEST["password"] != $_REQUEST["confirmpassword"]) {
    $errors['confirmpassword'] = "confirmpassword_doesn't_match";
}

if (empty($_REQUEST["email"]) || $_REQUEST["email"] == "") {
    $errors["email"] = "email_is_empty";
}
$str = "EditUser.php?";

$file_name = $_FILES['img']['name'];
$file_tmp = $_FILES['img']['tmp_name'];
$file_type = $_FILES['img']['type'];

$extention = explode("/", $file_type)[1];
$extensions = array("jpeg", "jpg", "png", "gif");

if (in_array(strtolower( $extention ) , $extensions) === false) {
    $errors["img"] = "Please Enter a Valid Extension JPEG, jpg, gif or PNG file.";
}
$profileImage = "../assets/ProfileImages/" . $_REQUEST["firstname"] . "." . $extention;
move_uploaded_file($file_tmp, $profileImage);

if (count($errors) > 0) {
    foreach ($errors as $k => $val) {
        $str .= $k . "=" . $val . "&";
    }
    header("Location: $str");
    return;
}

$d1 = new DbManager();
$stmt = $d1->UPDATEUSER($_REQUEST["firstname"], $_REQUEST["lastname"], $_REQUEST["password"], $_REQUEST["email"], $profileImage, $_COOKIE["id"]);
if ($stmt->rowCount()) {
    header("Location: FillUsersTable.php");
}




















































// if (!filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL)) {
//     $errors["wrongformat"]="invalid_email";
// }

// $pattern = "/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/";
// if (!preg_match_all($pattern, $_REQUEST["email"], $matches)) {
//     $errors["wrongformat"] = "invalid_email";
// }
// var_dump($_FILEs);
// $file_name = $_FILES['img']['name'];
// $file_tmp = $_FILES['img']['tmp_name'];
// $file_type = $_FILES['img']['type'];

// $extention = explode("/", $file_type)[1];
// $extensions = array("jpeg", "jpg", "png", "gif");

// if (in_array(strtolower( $extention ) , $extensions) === false) {
//     $errors["file"] = "extension not allowed, please choose a JPEG, jpg, gif or PNG file.";
// }



// move_uploaded_file($file_tmp, "Images/" . $_REQUEST["name"] . "." . $extention);

// try {
//     $text = fopen("file.txt", "a");
//     fwrite($text, $_REQUEST["email"] . ":");
//     fwrite($text, $_REQUEST["password"] . ":");
//     fwrite($text, PHP_EOL);
//     fclose($text);
// } catch (Exception $e) {
//     // $e->get_message();
// }

// header("location: login.php");
