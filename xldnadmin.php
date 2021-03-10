<?php
session_start();
$_SESSION['tai_khoan']=$_POST['user'];
$_SESSION['mat_khau']=md5($_POST['pass']);
$_SESSION['pass']=md5('admin');
if($_SESSION["tai_khoan"]!="admin"|| $_SESSION["mat_khau"]!=$_SESSION['pass']){
    header("Location: login.php");
}
else{
    header("Location: admin.php");
} 

?>