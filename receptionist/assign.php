<?php 
    include_once('../includes/connection.php');

    session_start();
    $msg = "";
    
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
    <title>Document</title>
</head>
<body>
    <div id="vapp" >
    <form class="absolute right-0 m-5" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
          <button type="submit" name="logout" class="px-4 py-2 font-semibold bg-red-300 rounded-full">Logout</button>
        </form>
    <a href="./dashboard.php" class="absolute right-0 px-4 py-2 m-5 mt-16 font-semibold bg-red-300 rounded-full">Home</a>

        <div class="absolute w-full h-screen px-6 py-8 mx-auto" style="background-color: rgba(0, 0, 0, .12);" v-if="editprofile">
            <div class="w-6/12 px-6 py-4 mx-auto bg-white shadow-lg rounded-xl min-h-64">
                <h1 class="text-lg font-semibold">Edit Profile</h1>

                <div class="grid justify-center grid-cols-6 gap-4 py-6">
                <div class="col-span-6">
                <label for="fullname">Full Name</label>
                    <input name="fullname" type="text" v-model:value="editprofile.full_name" placeholder="Full Name" class="col-span-6 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                </div>
                
                <div class="col-span-4">
                <label for="address">Address</label>
                    <input name="address" type="text" v-model:value="editprofile.address" placeholder="Address" class="col-span-6 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                </div>
                <div class="col-span-4">
                <label for="phone">Phone Number</label>
                    <input name="phone" type="text" v-model:value="editprofile.phone_number" placeholder="Phone Number" class="col-span-6 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                </div>
                    <div class="flex col-span-4">
                        <span>DOB:</span>
                        <input type="date" v-model:value="editprofile.dob" class="px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                    </div>
                <div class="col-span-4">
                <label for="gender">Gender</label>
                    <select name="gender" v-model:value="editprofile.gender" id="gender" class="col-span-3 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                        <option value="male" selected>Male</option>
                        <option value="female">Female</option>
                    </select>
                    </div>
                <div class="col-span-4">
                <label for="genotype">Genotype</label>
                    <select name="genotype" v-model:value="editprofile.genotype" id="genotype" class="col-span-3 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                        <option value="aa" selected>AA</option>
                        <option value="AA">AA</option>
                        <option value="AS">AS</option>
                        <option value="SS">SS</option>
                    </select>
                    </div>
                <div class="col-span-4">
                <label for="blood group">Blood Group</label>
                    <select name="blood group" v-model:value="editprofile.blood_group" id="bloodgroup" class="col-span-3 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    </select>
                    </div>
                    <button type="submit" @click="editProfile(editprofile)" class="col-span-4 px-6 py-3 text-white bg-indigo-500 rounded-lg shadow">Update</button>
                    <h1 class="col-span-6 text-green-500" v-if="msg">{{msg}}</h1>
                </div>
            </div>
        </div>
    
    <div class="absolute w-full min-h-screen px-6 py-4 shadow" v-if="viewRecord" style="background-color: rgba(0, 0, 0, 0.2);">
        <div class="px-6 py-4 mx-auto bg-white shadow rounded-xl w-max">
            <div class="w-56 py-3 text-xl font-semibold border-b-2">Patient Record</div>
            <div class="divide-y divide-gray-100">
                <h1 class="py-2">Name: {{viewRecord.full_name}}</h1>
                <h1 class="py-2">Address: {{viewRecord.address}}</h1>
                <h1 class="py-2">Blood Group: {{viewRecord.blood_group}}</h1>
                <h1 class="py-2">Genotype: {{viewRecord.genotype}}</h1>
                <select v-model:value="docSelect" class="w-full px-4 py-2 my-2 shadow">
                    <option value="">Select Doctor</option>
                    <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.fullname">{{doctor.fullname}}</option>
                </select>
                <div class="flex gap-3">
                    <button @click="appointDoc(viewRecord)" class="w-full px-4 py-2 text-white bg-green-500 rounded-full shadow">Send</button>                             
                    <button @click="viewRecord = null" class="w-full px-4 py-2 text-white bg-red-400 rounded-full shadow">Close</button>                             
                </div>
                <div class="px-4 py-2 mt-3 text-green-500 rounded-full bg-green-50" v-if="assignSuccess">
                    Assigning Doctor Success!
                </div>
            </div>
        </div>
    </div>
        <div class="w-10/12 min-h-screen px-6 py-8 mx-auto bg-gray-50">
        <div class="px-6 py-4 bg-white shadow-lg rounded-xl min-h-64">
            <h1 class="py-4 text-lg font-semibold">Patient Records</h1>
            <input type="text" v-model:value="searchKeys" v-on:keyup="searchRec()" placeholder="Search Keyword" class="col-span-6 px-6 py-2 mx-auto rounded-lg shadow-inner w-max focus:outline-none bg-blue-50">
            <div class="pt-10" v-if="searchRes.length > 0">
            <table class="w-full table-auto min-w-max" >
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
                    <tr class="border-b border-gray-200 hover:bg-gray-100"  v-for="patient in searchRes" :key="patient.id">
                            <td class="w-12 px-6 py-3 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">
                                        {{patient.id}}
                                    </span>
                                </div>
                            </td>
                            
                            <td class="px-6 py-3 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">
                                        {{patient.full_name}}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">
                                        {{patient.blood_group}}
                                    </span>
                                </div>
                            </td>
                            
                            <td class="px-6 py-3 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                        <span class="font-medium">
                                        {{patient.genotype}}
                                        </span>
                                    </div>
                            </td>
                            <td>
                                <button class="w-8 h-8" @click="editprofile = patient">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3"></path>
                                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3"></path>
                                    <line x1="16" y1="5" x2="19" y2="8"></line>
                                    </svg>
                                </button>   
                                <button @click="viewRecord = patient" class="px-4 py-2 text-white bg-green-500 rounded-full shadow">Send</button>
                            </td>
                        </tr>
                </tbody>
            </table>
            </div>
            <div class="w-full h-56 pt-10" v-else>
                <h1 class="text-2xl font-semibold text-center text-gray-400">Please input a keyword to search...</h1>
            </div>
        </div>
    </div>
</div>

    <script>
        const vueApp = new Vue({
        el: '#vapp',
        data: {
            viewRecord: null,
            searchRes: [],
            searchKeys: '',
            docSelect: '',
            assignSuccess: false,
            doctors: null,
            editprofile: null,
            msg: null
        },
        methods: {
            editProfile(patient){
                let comp = this;
                const dbParam = JSON.stringify({data:{ patient }});
                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function() {
                let myObj = JSON.parse(this.responseText);
                comp.assignSuccess = true
                comp.msg = myObj;
                setTimeout(() => {
                    comp.assignSuccess = false;
                    comp.editprofile = null;
                    comp.msg = null;
                    comp.searchKeys = '';
                }, 2000);
                console.log(myObj);
                }
                xmlhttp.open("POST", "http://localhost/Hospital-MGMT-SYS/fetches/main.php");
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("mod_patient=" + dbParam);
            },
            searchRec(){
                let comp = this;
                fetch('http://localhost/Hospital-MGMT-SYS/fetches/main.php?getrecs='+this.searchKeys)
                .then(res => res.json())
                .then(data => {
                    if(data != []){
                        comp.searchRes = data;
                    }
                });
            },
            appointDoc(patient){
                let comp = this;
                // let patient = JSON.stringify({id: patient});

                const dbParam = JSON.stringify({data:{ 
                    patient_id: patient.id,
                    doctor_name: comp.docSelect
                }});
                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function() {
                let myObj = JSON.parse(this.responseText);
                comp.viewRecord = myObj;
                comp.assignSuccess = true
                setTimeout(() => {
                    comp.assignSuccess = false;
                    comp.viewRecord = null;
                    comp.searchKeys = '';
                }, 2000);
                console.log(myObj);
                }
                xmlhttp.open("POST", "http://localhost/Hospital-MGMT-SYS/fetches/main.php");
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("patient_data=" + dbParam);
            }
        },
        mounted() {
            let comp = this;
            fetch("http://localhost/Hospital-MGMT-SYS/fetches/main.php?getdocs")
            .then(res => res.json())
            .then(data => {
                return comp.doctors = data
            })
        }
    })
        
    </script>
</body>
</html>