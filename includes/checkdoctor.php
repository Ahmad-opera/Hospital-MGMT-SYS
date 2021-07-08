<?php 
    session_start();
    if(!$_SESSION['username'] || $_SESSION['role']!='doctor'){
        echo 'Not a doctor!';
        header('location:../index.php');
    }
?>