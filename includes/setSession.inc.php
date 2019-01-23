<?php
if(!isset($_SESSION)) {session_start();}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $_SESSION['id'] = $id;
}

if(isset($_GET['fullname'])){
    $fullname = $_GET['fullname'];
    $_SESSION['fullname'] = $fullname;
}

if(isset($_GET['account_type'])){
    $account_type = $_GET['account_type'];
    $_SESSION['account_type'] = $account_type;
}

if(isset($_GET['token'])){
    $token = $_GET['token'];
    $_SESSION['token'] = $token;
}

if(isset($_GET['pass'])){
    $pass = $_GET['pass'];
    $_SESSION['pass'] = $pass;
}

if(isset($_GET['reset'])){
    $reset = $_GET['reset'];
    $_SESSION['reset'] = $reset;
}

session_regenerate_id();
?>