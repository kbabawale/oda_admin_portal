<?php 
if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
    $sessionid = $_SESSION['id'];
    $sessionfullname = $_SESSION['fullname'];
    $sessiondisplayname = substr($_SESSION['fullname'], 0, strpos($_SESSION['fullname'], ' '));
    $sessionaccounttype = $_SESSION['account_type'];
    $sessiontoken = $_SESSION['token']; 
    $sessionpass = $_SESSION['pass'];
    $sessionreset = $_SESSION['reset'];
}else{
    $_SESSION = array();
    session_destroy();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-86400, '/');
    }
    header("Location:login.php");
    // header("Location:http://95.179.228.232:8080/login.php");
    exit;
}

?>