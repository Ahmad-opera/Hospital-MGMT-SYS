<?php 
    include_once('./includes/connection.php');

    session_start();

    $msg = '';
    
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        
        $sql = "SELECT * FROM users WHERE username=? AND password=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        session_regenerate_id();
        $_SESSION['username'] = $row['username'];
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['role'] = $row['role'];
        session_write_close();

        if($result->num_rows==1 && $_SESSION['role']=='doctor'){
            header('location:doctor/dashboard.php');
        } else {
            $msg = "Invalid Doctor Login credentials!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/tailwind.min.css">
    <title>Document</title>
</head>
<body>
    <div class="justify-center min-h-screen px-4 py-1 bg-gray-50 sm:px-6 lg:px-8">
      <div class="w-full max-w-xs p-8 mx-auto mt-10 space-y-10 bg-white shadow rounded-xl">
        <div>
          <h2 class="mt-6 text-2xl font-extrabold text-center text-gray-900">Doctor Login</h2>
          
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="mt-8 space-y-6">
          <input type="hidden" name="remember" defaultValue="true" />
          <div class="-space-y-px rounded-md shadow-sm">
            <div>
              <label htmlFor="email-address" class="sr-only">
                Email address
              </label>
              <input
                id="username"
                type="text"
                name="username"
                class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="username"
              />
            </div>
            <div>
              <label htmlFor="password" class="sr-only">
                Password
              </label>
              <input
                id="password"
                type="password"
                name="password"
                class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                placeholder="Password"
              />
            </div>
          </div>

          <div>
            <button
              type="submit"
              name="login"
              class="relative flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md group hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              <span class="absolute inset-y-0 left-0 flex items-center pl-3">
              </span>
              Sign in
            </button>
            
                <?php if($msg) {
                  echo '<div class="py-2 mt-2 text-center text-red-500 rounded-full bg-red-50">'. $msg .'</div>';
                  }
                  ?>
            </div>
            </form>
        </div>
    </div>
  
</body>
</html>