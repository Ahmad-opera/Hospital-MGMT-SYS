<?php
include_once('../includes/checkadmin.php');

  if(isset($_POST['logout'])){
    session_destroy();
    header('location:../index.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/tailwind.min.css" />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
    <title>Admin Panel</title>
    <style>
      body {
        font-family: Roboto, sans-serif;
      }
    </style>
  </head>
  <body>
    <div
      class="fixed top-0 z-10 flex-row w-64 h-screen px-6 py-4 overflow-hidden overflow-y-auto transition-all duration-300 bg-white shadow-xl md:left-0 -left-64 flex-nowrap"
    >
      <div class="relative flex-col items-stretch min-h-full px-0 flex-nowrap">
        <a
          href="https://material-tailwind.com?ref=mtd"
          target="_blank"
          rel="noreferrer"
          class="inline-block w-full mt-2 text-center"
          ><h1
            class="mt-0 mb-2 text-xl font-bold leading-normal text-gray-900 "
          >
            ADMIN PANEL
          </h1></a
        >
        <div class="flex flex-col">
          <hr class="min-w-full my-4" />
          <ul class="flex flex-col min-w-full list-none">
            <li class="mb-2 rounded-lg">
              <a
                aria-current="page"
                class="flex items-center gap-4 px-4 py-3 text-sm font-light rounded-lg <?php if(strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false){
                  echo 'bg-gradient-to-tr from-blue-500 to-blue-700 text-white shadow-md';
                  }else{
                  echo 'text-gray-700';
                  }?>"
                href="dashboard.php"
                ><span class="text-2xl leading-none material-icons undefined"
                  >dashboard</span
                >Dashboard</a
              >
            </li>
            <li class="mb-2 rounded-lg">
              <a
                aria-current="page"
                class="flex items-center gap-4 px-4 py-3 text-sm font-light rounded-lg <?php if(strpos($_SERVER['REQUEST_URI'], 'users.php') !== false){
                  echo 'bg-gradient-to-tr from-blue-500 to-blue-700 text-white shadow-md';
                  }else{
                  echo 'text-gray-700';
                  }?>"
                href="users.php"
                ><span class="text-2xl leading-none material-icons undefined"
                  >people</span
                >Users</a
              >
            </li>
            <li class="mb-2 rounded-lg">
              <a
                aria-current="page"
                class="flex items-center gap-4 px-4 py-3 text-sm font-light rounded-lg <?php if(strpos($_SERVER['REQUEST_URI'], 'products.php') !== false){
                  echo 'bg-gradient-to-tr from-blue-500 to-blue-700 text-white shadow-md';
                  }else{
                  echo 'text-gray-700';
                  }?>"
                href="products.php"
                ><span class="text-2xl leading-none material-icons undefined"
                  >list_alt</span
                >Drugs</a
              >
            </li>
          </ul>
        </div>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
          <button name="logout" type="submit" class="absolute bottom-0 items-center w-full px-6 py-3 text-white rounded-lg bg-gradient-to-tl to-red-400 from-red-500"> <span class="my-auto material-icons">logout</span> Logout</button>
        </form>
      </div>
    </div>
    <!-- Ends Sidebar -->
    
    <!-- <div class="min-h-screen bg-gray-50">
      <nav class="w-3/12 px-6 py-4 mr-auto bg-white shadow-xl min-h-80">
        <h1 class="text-center">Admin Panel</h1>
      </nav>
    </div> -->
 