<?php
session_start();
if(isset($_POST["logout"])){
    session_destroy();
    //aadressi reas avatakse login.php
    header('Location:login.php');
    exit();
}
session_start();
if(isset($_SESSION["tuvustamine"])){
    header('Location :login.php');
    exit();
}
