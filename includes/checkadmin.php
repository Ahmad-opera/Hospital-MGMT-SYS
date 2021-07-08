<?php 
    session_start();
    if(!$_SESSION['username'] || $_SESSION['role']!='admin'){
        echo 'Not an Admin!';
        header('location:../index.php');
    }
?>