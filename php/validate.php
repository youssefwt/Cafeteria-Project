<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errors =[];

if (empty($_REQUEST["username"])&& $_REQUEST["username"]=="") {
    $errors['username']="username_is_empty";
}

if (empty($_REQUEST["password"]) ||$_REQUEST["password"]=="") {
    $errors["password"]="password_is_empty";
}


$str="../html/Sign_in.html?";
if (count($errors)>0) {
    foreach ($errors as $k=>$val) {
        if(count($errors) == 1){
            $str.=$k."=".$val;
        }
        else if ($k =="password") {
            $str.=$k."=".$val;
        } else {
            $str.=$k."=".$val."&";
        }
    }
    header("Location: $str");
    return;
}
