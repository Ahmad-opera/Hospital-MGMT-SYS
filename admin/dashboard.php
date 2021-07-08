<?php
include_once('./components/header.php');
include('../includes/connection.php');
?>
<div class="md:ml-64">

<div
  class="h-screen px-3 pt-24 md:px-8 rounded-xl bg-gradient-to-tr from-purple-500 to-purple-700 shadow-lg-purple"
>
  <div class="container max-w-full mx-auto">
    <div class="h-auto px-3 bg-light-blue-500 pt-14 pb-28 md:px-8">
      <div class="container max-w-full mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4">
          
          <div class="px-4 mb-10">
            <div
              class="w-full p-4 bg-white shadow-md rounded-xl overflow-hdden undefined"
            >
              <div class="flex flex-wrap border-b border-gray-200 undefined">
                <div
                  class="flex-1 flex-grow w-full max-w-full pl-4 mb-2 text-right undefined"
                >
                  <h5
                    class="mb-1 text-base font-light tracking-wide text-gray-500 "
                  >
                    Workers
                  </h5>
                  <span class="text-3xl text-gray-900"><?php 
                    $sql = "SELECT * FROM users";
                    $result = $mysqli -> query($sql);
                    echo $result->num_rows;
                    ?></span>
                </div>
              </div>
            </div>
          </div>
          <div class="px-4 mb-10">
            <div
              class="w-full p-4 bg-white shadow-md rounded-xl overflow-hdden undefined"
            >
              <div class="flex flex-wrap border-b border-gray-200 undefined">
                
                <div
                  class="flex-1 flex-grow w-full max-w-full pl-4 mb-2 text-right undefined"
                >
                  <h5
                    class="mb-1 text-base font-light tracking-wide text-gray-500 "
                  >
                    Sales
                  </h5>
                  <span class="text-3xl text-gray-900"><?php 
                    $query = "SELECT count(id) AS total FROM drugs";
                    $result = $mysqli -> query($query);
                      while ($row = mysqli_fetch_assoc($result)){ 
                        echo $row['total'];
                      }
                      
                    ?></span>
                </div>
              </div>
            </div>
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
