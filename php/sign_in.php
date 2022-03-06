<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errors =[];

if (empty($_REQUEST["email"])&& $_REQUEST["email"]=="") {
    $errors['email']="emptyEmail";
}

if (empty($_REQUEST["password"]) ||$_REQUEST["password"]=="") {
    $errors["password"]="emptyPassword";
}

if (!(count($errors))){
    include ("dbManager.php");
    $d1 = new DbManager();
    $user_or_not = $d1->userExistence($_REQUEST["email"], $_REQUEST["password"]);

    if(!(count($user_or_not))) {
        $errors['wrong_info']="WrongCombination";
    }
}

$str="../html/sign_in.html?";
if (count($errors)>0) {
    foreach ($errors as $k=>$val) {
        $str.=$k."=".$val."&";
    }
    header("Location: $str");
    return;
}

session_start();
//$user_or_not = $d1->userExistence($_REQUEST["email"], $_REQUEST["password"]);
$_SESSION['id'] = $user_or_not[0][0];
$_SESSION['name'] = $user_or_not[0][1];
$_SESSION['role'] = $user_or_not[0][5];
