<?php
session_start();
if(!isset($_SESSION['nombre'])){
    header("location:pages/login.php");
}else{
    header("location:pages/index.php");
}