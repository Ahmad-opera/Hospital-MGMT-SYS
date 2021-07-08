<?php
include_once('../includes/checkdoctor.php');
include('../includes/connection.php');
include_once('./components/header.php');
?>

<div id="vapp">


  <div class="absolute w-full min-h-screen px-6 py-6 " style="background-color: rgba(0, 0, 0, .2);" v-if="viewRecord">
    <div class="w-8/12 px-4 py-3 mx-auto bg-white rounded-lg">
      <h1 class="py-6 text-2xl font-semibold text-center">Patient's Record</h1>
      <div class="flex flex-row justify-between px-16 py-10 font-semibold divide-y divide-gray-50">
        <p>Full Name: {{viewRecord.patient_id.full_name}}</p>
        <p>Blood Group: {{viewRecord.patient_id.blood_group}}</p>
        <p>DOB: {{viewRecord.patient_id.dob}}</p>
      </div>
      <div class="flex flex-col w-full gap-4 px-6 pb-6">
      <textarea  rows="6" placeholder="Note goes here..." v-model:value="sessionData.note" class="block w-full px-4 py-3 bg-gray-100 border rounded-lg shadow-inner focus:outline-none"></textarea>
      <textarea rows="6" placeholder="Drug prescription goes here... " v-model:value="sessionData.drugs_prescription" class="w-full px-4 py-3 bg-gray-100 border rounded-lg shadow-inner focus:outline-none block3 borer bg-gray-50"></textarea>
      </div>
      <div class="flex gap-1 px-6 py-2 mr-auto w-max">
        <button @click="viewRecord = null" class="px-6 py-2 text-white bg-red-500 rounded-full shadow">Close</button>
        <button @click="endSession()" class="px-6 py-2 text-white bg-green-500 rounded-full shadow">End Session</button>
      </div>
    </div>
  </div>

  
    <div class="container w-full min-h-screen bg-gray-50">
      <nav class="flex items-center px-6 py-4 bg-white shadow">
        <h1 class="text-lg font-semibold">Doctor Panel</h1>
        <form class="ml-auto" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
          <button type="submit" name="logout" class="px-4 py-2 font-semibold bg-red-300 rounded-full">Logout</button>
        </form>
      </nav>
      <div class="flex">
      <div class="w-56 px-4 py-4 m-6 mr-auto font-semibold text-center bg-white rounded-lg shadow">
          <div class="w-full px-4 py-2 mt-3 border shadow rounded-xl">
            My Waiting List
          </div>
        </div>
      <div class="w-full min-h-screen px-6 m-5 bg-white shadow rounded-xl">
        <h1 class="w-full py-4 text-lg font-semibold text-center uppercase bg-gray-100 rounded-b-xl">My Wait List</h1>

        
        <table class="w-10/12 py-6 mx-auto mt-8 rounded-lg table-auto" v-if="waitingList.length > 0">
                <thead>
                    <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                        <th class="w-12 px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Full Name</th>
                        <th class="px-6 py-3 text-left">Blood Group</th>
                        <th class="px-6 py-3 text-left">Genotype</th>
                        <th class="px-6 py-3 text-left"></th>
                    </tr>
                </thead>
                <tbody class="text-sm font-light text-gray-600">
                    <tr class="border-b border-gray-200 hover:bg-gray-100"  v-for="appointment in waitingList" :key="appointment.id">
                            <td class="w-12 px-6 py-3 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">
                                      {{appointment.id}}
                                    </span>
                                </div>
                            </td>
                            
                            <td class="px-6 py-3 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">
                                        {{appointment.patient_id.full_name}}
                                      </span>
                                    </div>
                                  </td>
                                  <td class="px-6 py-3 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                      <span class="font-medium">
                                        {{appointment.patient_id.blood_group}}                                        
                                      </span>
                                </div>
                              </td>
                              
                              <td class="px-6 py-3 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                  <span class="font-medium">
                                          {{appointment.patient_id.genotype}} 
                                        </span>
                                    </div>
                            </td>
                            <td>
                                <button @click="viewRecord = appointment; sessionData.id = viewRecord.id" class="px-4 py-2 font-semibold text-white bg-green-500 rounded-full shadow">Attend to</button>
                            </td>
                        </tr>
                </tbody>
            </table>
            <div class="px-10 py-8 text-3xl text-center rounded-full bg-gray-50" v-else>
                You have no one in your waiting list...yet!
        </div>
      </div>
    </div>
    </div>

</div>

  
<script>
    const vueApp = new Vue({
      el: '#vapp',
      data: {
        sessionData: {
          id: '',
          note: '',
          drugs_prescription: '',
        },
        temp: null,
        viewRecord: null,
        waitingList: null,
      },
      methods: {
        endSession(){
          let comp = this;
          let dbParam = JSON.stringify({data: this.sessionData});
          const xmlhttp = new XMLHttpRequest();
          xmlhttp.onload = function() {
          let myObj = JSON.parse(this.responseText);
          if(myObj == "Success") comp.viewRecord = null;
          window.location.reload();
          }
          xmlhttp.open("POST", "http://localhost/Hospital-MGMT-SYS/fetches/main.php");
          xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xmlhttp.send("endsession=" + dbParam);
        }
      },
      mounted(){
        let comp = this;
        fetch('http://localhost/Hospital-MGMT-SYS/fetches/main.php?getwaitlist')
        .then(res => res.json())
        .then(data => {
          comp.temp = data;
          comp.temp.forEach(e => {
            fetch('http://localhost/Hospital-MGMT-SYS/fetches/main.php?getpatient='+e.patient_id)
              .then(res =>  res.json())
              .then(data => {
                comp.temp[comp.temp.indexOf(e)].patient_id = data;
              })
          });
          if(comp.temp){
            comp.waitingList = comp.temp;
          }
          
          console.log(comp.waitingList)
        })
      }
      })
</script>
</body>
</html>
