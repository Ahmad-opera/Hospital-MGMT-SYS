<?php 
    session_start();
    if(!$_SESSION['username'] || $_SESSION['role']!='receptionist'){
        echo 'Not a receptionist manager!';
        header('location:../index.php');
    }
?>