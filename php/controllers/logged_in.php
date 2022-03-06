<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['role'])){
    $myObj = [];
    $myObj['id'] = $_SESSION['id'];
    $myObj['name'] = $_SESSION['name'];
    $myObj['role'] = $_SESSION['role'];
    echo json_encode($myObj);
}

