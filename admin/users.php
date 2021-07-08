<?php
include_once('./components/header.php');
include('../includes/connection.php');

if(isset($_POST['updateuser'])){
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $status = $_POST['status'];
  $email = $_POST['email'];
  if($password == ''){
    $result = $mysqli->query("UPDATE  users  SET email = '$email' , status = '$status' WHERE username = '$username'");
  }else{
    $result = $mysqli->query("UPDATE  users  SET email = '$email' , password = '$password', status = '$status' WHERE username = '$username'");
  }
  if($result){
    echo "successfully altered!";
  }else{
    echo "failed!";
  }  
}
if(isset($_POST['newuser'])){
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $status = $_POST['status'];
  $email = $_POST['email'];
  $role = $_POST['role'];
  
  $result = $mysqli->query("INSERT INTO users(username, email, role, password, status) VALUES ('$username','$email','$role','$password','$status')");
  if($result){
    echo "Successfully added!";
  }else{
    echo "Failed!";
  }  
}
if(isset($_POST['confirmdel'])){
  $username = $_POST['username'];
  $email = $_POST['email'];
  $result = $mysqli->query("DELETE FROM users WHERE username = '$username'");
  if($result){
    echo "Successfully Deleted!";
  }else{
    echo "Failed!";
  }
}

function render_edit_form($username){
  include('../includes/connection.php');
  $result = $mysqli ->query("SELECT * FROM users WHERE username='$username'");
  if($result){
    while ($row = $result -> fetch_assoc()) {
      echo '
      <div class="fixed absolute top-0 z-40 w-full h-screen py-10 overflow-hidden" style="background-color: rgba(111,111,111,0.4)">
        <div class="w-2/5 mx-auto mt-5 md:mt-0 md:col-span-2">
          <form action="'.$_SERVER['PHP_SELF'].'" method="POST">
            <div class="overflow-hidden shadow sm:rounded-md">
              <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-6 ">
                    <label for="username" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input type="text" disabled="true" value="'. $row['username'].'"  autocomplete="email" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <input type="text" name="username" value="'. $row['username'].'" id="username" autocomplete="email" class="hidden">
                  
                    <div class="col-span-6">
                      <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                      <input type="text" name="email" value="'. $row['email'].'" id="email" autocomplete="email" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    
      
                    <div class="col-span-6 sm:col-span-3">
                      <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                      <select id="status" name="status" autocomplete="status" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                      </select>
                    </div>
      
                    <div class="col-span-6 sm:col-span-3">
                      <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                      <select id="role" name="role" autocomplete="role" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="admin">Admin</option>
                        <option value="doctor">Doctor</option>
                        <option value="pharmacist">Pharmacist</option>
                        <option value="receptionist">Receptionist</option>
                      </select>
                    </div>
                    <div class="col-span-6">
                      <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                      <input type="text" name="password" id="password" autocomplete="password" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    </div>
                </div>
              <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                <button name="updateuser" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Cancel
                </button>
                <button type="submit" name="updateuser" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Update
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    </div>';
    }
  }
}

function render_add_form(){
    echo '
    <div class="fixed absolute top-0 z-40 w-full h-screen overflow-hidden" style="background-color: rgba(111,111,111,0.4)">
    <div class="w-2/5 mx-auto mt-5 md:mt-0 md:col-span-2">
        <form action="'.$_SERVER['PHP_SELF'].'" method="POST">
          <div class="overflow-hidden shadow sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
              <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6">
                  <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                  <input type="text" name="username" autocomplete="username" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                  </div>
                
                <div class="col-span-6 ">
                  <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                  <input type="text" name="email" id="email" autocomplete="email" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                </div>
                
  
                <div class="col-span-6 sm:col-span-3">
                  <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                  <select id="status" name="status" autocomplete="status" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                </div>

                <div class="col-span-6 sm:col-span-3">
                      <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                      <select id="role" name="role" autocomplete="role" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="admin">Admin</option>
                        <option value="doctor">Doctor</option>
                        <option value="pharmacist">Pharmacist</option>
                        <option value="receptionist">Receptionist</option>
                      </select>
                </div>
  
                <div class="col-span-6">
                  <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                  <input type="text" name="password" id="password" autocomplete="password" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                </div>
  
              </div>
            </div>
            <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
            <button name="updateuser" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Cancel
                </button>
              <button type="submit" name="newuser" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Add
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>';
  }
  
function render_delete_form($username){
  include('../includes/connection.php');
  $result = $mysqli ->query("SELECT * FROM users WHERE username='$username'");
  if($result){
    while ($row = $result -> fetch_assoc()) {
    echo '
      <div class="fixed absolute top-0 z-40 w-full h-screen py-10 overflow-hidden" style="background-color: rgba(111,111,111,0.4)">
        <div class="w-2/5 mx-auto mt-5 md:mt-0 md:col-span-2">
            <form action="'.$_SERVER['PHP_SELF'].'" method="POST">
              <div class="overflow-hidden shadow sm:rounded-md">
                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                <input type="text" name="username" class="hidden" value="'.$row['username'].'">
                <input type="text" name="email" class="hidden" value="'.$row['email'].'">
                <h1 class="text-2xl font-semibold">Are you sure to delete '.$row['username'].'!</h1>
                  <a href=""><button class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  No
                  </button></a>
                  <button type="submit" name="confirmdel" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>';
    }
  }
}


if (isset($_GET['adduser'])) {
  render_add_form();
}
if (isset($_GET['edit'])) {
  render_edit_form($_GET['edit']);
}
if (isset($_GET['delete'])) {
  render_delete_form($_GET['delete']);
}

?>

<div class="md:ml-64">

      <div class="h-screen px-3 pt-24 md:px-8 rounded-xl bg-gradient-to-tr from-indigo-300 to-indigo-200 shadow-lg-indigo">
        <div class="container max-w-full mx-auto">
          <div class="grid grid-cols-1 px-4 pb-16">
            <div
              class="w-full p-4 bg-white shadow-md rounded-xl undefined"
            >
              <div
                class="flex items-center justify-start w-full h-24 px-8 py-4 mt-2 mb-4 text-white bg-gradient-to-tr from-green-500 to-green-700 rounded-xl shadow-lg-green undefined"
              >
                <h2 class="text-2xl text-white">Users</h2>
                <a href="?adduser" class="px-4 py-2 ml-auto font-semibold text-gray-700 bg-white rounded-lg shadow focus:outline-none"><button>Add New</button></a>
              </div>
              <div class="p-4 undefined">
                <div class="overflow-x-auto">
                  <table
                    class="items-center w-full bg-transparent border-collapse"
                  >
                    <thead>
                      <tr>
                        <th
                          class="px-2 py-3 text-sm font-light text-left text-purple-500 align-middle border-b border-gray-200 border-solid whitespace-nowrap"
                        >
                          Username
                        </th>
                        <th
                          class="px-2 py-3 text-sm font-light text-left text-purple-500 align-middle border-b border-gray-200 border-solid whitespace-nowrap"
                        >
                          Email
                        </th>
                        <th
                          class="px-2 py-3 text-sm font-light text-left text-purple-500 align-middle border-b border-gray-200 border-solid whitespace-nowrap"
                        >
                          Role
                        </th>
                        <th
                          class="px-2 py-3 text-sm font-light text-left text-purple-500 align-middle border-b border-gray-200 border-solid whitespace-nowrap"
                        >
                          Status
                        </th>
                        <th
                          class="px-2 py-3 text-sm font-light text-left text-purple-500 align-middle border-b border-gray-200 border-solid whitespace-nowrap"
                        >
                          Password
                        </th>
                        <th class="px-2 py-3">
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                          if ($result = $mysqli -> query("SELECT * FROM users")) {
                            while ($row = $result -> fetch_assoc()) {
                              // printf ("%s (%s)\n", $row[0], $row[1]);
                            echo '<tr>
                            <th class="px-2 py-4 text-sm font-light text-left align-middle border-b border-gray-200 whitespace-nowrap">
                              '. $row['username'].'
                            </th>
                            <th class="px-2 py-4 text-sm font-light text-left align-middle border-b border-gray-200 whitespace-nowrap">
                            '. $row['email'].'
                            </th>
                            <th class="px-2 py-4 text-sm font-light text-left align-middle border-b border-gray-200 whitespace-nowrap">
                            '. $row['role'].'
                            </th>
                            <th class="px-2 py-4 text-sm font-light text-left align-middle border-b border-gray-200 whitespace-nowrap">
                              '. $row['status'] .'
                            </th>
                            <th class="px-2 py-4 text-sm font-light text-left align-middle border-b border-gray-200 whitespace-nowrap">
                                ●●●●●●●
                            </th>
                            <th class="px-2 py-4 text-sm font-light text-left align-middle border-b border-gray-200 whitespace-nowrap">
                            <a href="?edit='. $row['username'] .'"><span class="text-3xl leading-none text-gray-500 material-icons">edit</span></a>
                            <a href="?delete='. $row['username'] .'"><span class="text-3xl leading-none text-gray-500 material-icons">delete</span></a>
                            </th>
                          </tr>
                        <tr>';
                            }
                            $result -> free_result();
                          }

                      
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



<?php
include_once('./components/footer.php');
?>