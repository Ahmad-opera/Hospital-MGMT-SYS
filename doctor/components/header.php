<?php
  if(isset($_POST['logout'])){
    session_destroy();
    header('location:../index.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../assets/css/tailwind.min.css">
  <script src="../assets/js/vue_2.js"></script>
  <title>Doctor's Panel</title>
</head>
<body>