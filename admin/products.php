<?php
include_once('./components/header.php');
include('../includes/connection.php');

$msg = "";

if(isset($_POST['updateprod'])){
  $id = $_POST['id'];
  $name = $_POST['name'];
  $qty_type = $_POST['qty_type'];
  $in_stock = $_POST['in_stock'];
  $price = $_POST['price'];
  $manufacturer = $_POST['manufacturer'];

  $result = $mysqli->query("UPDATE  drugs  SET drug_name = '$name', drug_manufacturer = '$manufacturer', price = '$price', qty_type = '$qty_type', in_stock = '$in_stock' WHERE id = '$id'");
  
  if($result){
    $msg = '<div class="px-4 py-1 text-center text-green-500 bg-green-50">Successfully Updated!</div>';
  }else{
    $msg = '<div class="px-4 py-1 text-center text-red-500 bg-red-50">Failed!</div>';
  }  
}

if(isset($_POST['newcat'])){
  $name = $_POST['name'];
  $qty_type = $_POST['qty_type'];
  $price = $_POST['price'];
  $manufacturer = $_POST['manufacturer'];
  
  $result = $mysqli->query("INSERT INTO drugs(drug_name, drug_manufacturer, qty_type, price, in_stock) VALUES ('$name', '$manufacturer', '$qty_type', '$price', 1)");
  if($result){
    $msg = '<div class="px-4 py-1 text-center text-green-500 bg-green-50">Successfully Added!</div>';
  }else{
    $msg = '<div class="px-4 py-1 text-center text-red-500 bg-red-50">Failed to Add!</div>';
  }  
}
if(isset($_POST['confirmdel'])){
  $id = $_POST['id'];
  $result = $mysqli->query("DELETE FROM drugs WHERE id = '$id'");
  if($result){
    $msg = '<div class="px-4 py-1 text-center text-green-500 bg-green-50">Successfully Deleted!</div>';
  }else{
    $msg = '<div class="px-4 py-1 text-center text-red-500 bg-red-50">Failed to Delete!</div>';
  }
}

function render_edit_form($id){
  include('../includes/connection.php');
  // $getQTYs = $mysqli->query("SELECT * FROM qty_types");
  // $qty_types = "";
  $result = $mysqli ->query("SELECT * FROM drugs WHERE id='$id'");
  

  
  if($result){
    while ($row = $result -> fetch_assoc()) {
      
    //   if($getQTYs){
        
    //     while ($rows = $getQTYs -> fetch_assoc()) {
    //       if($row['qty_type'] == $rows['name']){
    //       $qty_types = $qty_types .'<option value="'. $rows['name'] .'" selected>'. $rows['name'] .'</option>';
    //     }else{
    //       $qty_types = $qty_types .'<option value="'. $rows['name'] .'">'. $rows['name'] .'</option>';
    //       }
    //     }
    // }
      echo '
      <div class="fixed absolute top-0 z-40 w-full h-screen overflow-hidden" style="background-color: rgba(111,111,111,0.4)">
          <div class="w-2/5 mx-auto mt-5 md:mt-0 md:col-span-2">
              <form action="'.$_SERVER['PHP_SELF'].'" method="POST">
                <div class="overflow-hidden shadow sm:rounded-md">
                  <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                      <div class="col-span-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" autocomplete="name" value="'. $row['drug_name'] .'" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                        <input type="text" name="id" value="'. $row['id'] .'" class="hidden">
                      </div>
                      
                      <div class="col-span-6">
                        <label for="manufacturer" class="block text-sm font-medium text-gray-700">Manufacturer</label>
                        <input type="text" name="manufacturer" value="'. $row['drug_manufacturer'] .'" autocomplete="manufacturer" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" min="10" required>
                      </div>
                      
                      <div class="col-span-6">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" value="'. $row['price'] .'" autocomplete="price" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" min="10" required>
                      </div>
                      <div class="col-span-6">
                      <label for="qty_type" class="block text-sm font-medium text-gray-700">Quantity Type</label>
                      <select id="qty_type" name="qty_type" autocomplete="qty_type" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      <option value="">Select Option</option>
                      <option value="tablet">Tablet</option>
                      </select>
                    </div>
                      <div class="col-span-6">
                      <label for="in_stock" class="block text-sm font-medium text-gray-700">Availability</label>
                      <select id="in_stock"  name="in_stock" autocomplete="in_stock" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      <option value="1" class="" selected>In Stock</option>
                      <option value="0" class="">Out of Stock</option>
                      </select>
                      </div>
                    
                      </div>
                  </div>
                  <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                    <button type="submit" name="updateprod" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
  include('../includes/connection.php');
    echo '
        <div class="fixed absolute top-0 z-40 w-full h-screen overflow-hidden" style="background-color: rgba(111,111,111,0.4)">
          <div class="w-2/5 mx-auto mt-5 md:mt-0 md:col-span-2">
              <form action="'.$_SERVER['PHP_SELF'].'" method="POST">
                <div class="overflow-hidden shadow sm:rounded-md">
                  <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                      <div class="col-span-6">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" autocomplete="name" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                      </div>

                      <div class="col-span-6">
                        <label for="manufacturer" class="block text-sm font-medium text-gray-700">Manufacturer</label>
                        <input type="text" name="manufacturer" autocomplete="manufacturer" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" min="10" required>
                      </div>
                      
                      <div class="col-span-6">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" autocomplete="price" class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" min="10" required>
                      </div>
                      
                      <div class="col-span-6">
                      <label for="qty_type" class="block text-sm font-medium text-gray-700">Quantity Type</label>
                      <select id="qty_type" name="qty_type" autocomplete="qty_type" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      <option value="tablet">Tablet</option>
                      <option value="capsules">Capsules</option>
                      </select>
                    </div>
                    
                    </div>
                  </div>
                  <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                    <button type="submit" name="newcat" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
  
function render_delete_form($id){
  include('../includes/connection.php');
  $result = $mysqli ->query("SELECT * FROM drugs WHERE id='$id'");
  if($result){
    while ($row = $result -> fetch_assoc()) {
    echo '
      <div class="fixed absolute top-0 z-40 w-full h-screen py-10 overflow-hidden" style="background-color: rgba(111,111,111,0.4)">
        <div class="w-2/5 mx-auto mt-5 md:mt-0 md:col-span-2">
            <form action="'.$_SERVER['PHP_SELF'].'" method="POST">
              <div class="overflow-hidden shadow sm:rounded-md">
                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                <input type="text" name="id" class="hidden" value="'.$row['id'].'">
                <h1 class="text-2xl font-semibold">Are you sure to delete '.$row['drug_name'].'!</h1>
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
                class="flex items-center justify-start w-full h-24 px-8 py-4 mt-2 mb-4 text-white bg-gradient-to-tr from-blue-500 to-blue-700 rounded-xl shadow-lg-blue undefined"
              >
                <h2 class="text-2xl text-white">Users</h2>
                <a href="?adduser" class="px-4 py-2 ml-auto font-semibold text-gray-700 bg-white rounded-lg shadow focus:outline-none"><button >Add New</button></a>
              </div>
              <?= $msg ?>
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
                          ID
                        </th>
                        <th
                          class="px-2 py-3 text-sm font-light text-left text-purple-500 align-middle border-b border-gray-200 border-solid whitespace-nowrap"
                        >
                          Name
                        </th>
                        <th
                          class="px-2 py-3 text-sm font-light text-left text-purple-500 align-middle border-b border-gray-200 border-solid whitespace-nowrap"
                        >
                          Price
                        </th>
                        <th
                          class="px-2 py-3 text-sm font-light text-left text-purple-500 align-middle border-b border-gray-200 border-solid whitespace-nowrap"
                        >
                          In Stock
                        </th>
                        <th
                          class="px-2 py-3 text-sm font-light text-left text-purple-500 align-middle border-b border-gray-200 border-solid whitespace-nowrap"
                        >
                          QTY Type
                        </th>
                        <th class="px-2 py-3">
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                          $sql = "SELECT * FROM drugs";
                          if ($result = $mysqli -> query($sql)) {
                            while ($row = $result -> fetch_assoc()) {
                            echo '<tr>
                            <th class="px-2 py-4 text-sm font-light text-left align-middle border-b border-gray-200 whitespace-nowrap">
                              '. $row['id'].'
                            </th>
                            <th class="px-2 py-4 text-sm font-light text-left align-middle border-b border-gray-200 whitespace-nowrap">
                            '. $row['drug_name'].'
                            </th>
                            <th class="px-2 py-4 text-sm font-light text-left align-middle border-b border-gray-200 whitespace-nowrap">
                            ₦'. $row['price'].'
                            </th>
                            <th class="px-2 py-4 text-sm font-light text-left align-middle border-b border-gray-200 whitespace-nowrap">
                            '. $row['in_stock'].'
                            </th>
                            <th class="px-2 py-4 text-sm font-light text-left align-middle border-b border-gray-200 whitespace-nowrap">
                            '. $row['qty_type'].'
                            </th>
                            <th class="px-2 py-4 text-sm font-light text-left border-b border-gray-200 align-end whitespace-nowrap">
                                <a href="?edit='. $row['id'] .'"><span class="text-3xl leading-none text-gray-500 material-icons">edit</span></a>
                                <a href="?delete='. $row['id'] .'"><span class="text-3xl leading-none text-gray-500 material-icons">delete</span></a>
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