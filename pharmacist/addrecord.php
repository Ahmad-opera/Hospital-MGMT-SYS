<?php 
    include_once('../includes/connection.php');

    session_start();
    $msg = "";

   
    
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
    <div v-if="newRecord.full_name" class="absolute z-40 w-full h-screen px-16 py-6 pt-16" style="background-color: rgba(0, 0, 0, .3);">
        <div class="w-8/12 px-6 py-4 bg-white rounded-lg shadow">
            <h1>New Record Generated!</h1>
            <button @click="closeRecord()" class="px-6 py-2 font-bold text-white bg-red-500 rounded-full focus:outline-none hover:bg-red-400">Close</button>
            <button @click="printRecord()" class="px-6 py-2 font-bold text-white bg-green-500 rounded-full focus:outline-none hover:bg-green-400">Print</button>
        </div>
    </div>
    
        <div class="w-6/12 min-h-screen px-6 py-8 mx-auto bg-gray-50">
        <div class="px-6 py-4 bg-white shadow-lg rounded-xl min-h-64">
            <h1 class="text-lg font-semibold">Create New Record</h1>

            <div class="grid justify-center grid-cols-6 gap-4 py-6">
                <input type="text" v-model:value="newUser.fullname" placeholder="Full Name" class="col-span-6 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                <input type="text" v-model:value="newUser.address" placeholder="Address" class="col-span-6 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                <input type="text" v-model:value="newUser.phone" placeholder="Phone Number" class="col-span-6 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                <div class="flex col-span-4">
                    <span>DOB:</span>
                    <input type="date" v-model:value="newUser.dob" class="px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                </div>
                <select v-model:value="newUser.gender" id="gender" class="col-span-3 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                    <option value="male" selected>Male</option>
                    <option value="female">Female</option>
                </select>
                <select v-model:value="newUser.genotype" id="genotype" class="col-span-3 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                    <option value="aa" selected>AA</option>
                    <option value="as">AS</option>
                </select>
                <select v-model:value="newUser.bloodgroup" id="bloodgroup" class="col-span-3 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                    <option value="a" selected>A</option>
                    <option value="b">B</option>
                </select>
                <button type="submit" @click="createRecord()" class="col-span-4 px-6 py-3 text-white bg-green-500 rounded-lg shadow">Create</button>
                <h1 class="col-span-6 text-green-500"><?= $msg ?></h1>
            </div>
        </div>
    </div>
</div>

    <script>
        const vueApp = new Vue({
        el: '#vapp',
        data: {
            newUser: {
                fullname: "",
                address: "",
                phone: "",
                dob: "",
                gender: "",
                genotype: "",
                bloodgroup: ""
            },
            newRecord: {
            }
        },
        methods: {
            createRecord(){
                let comp = this;
                let dbParam = JSON.stringify({data: this.newUser});
                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function() {
                let myObj = JSON.parse(this.responseText);
                comp.newRecord = myObj;
                console.log(comp.newRecord)
                console.log(myObj);
                }
                xmlhttp.open("POST", "http://localhost/Hospital-MGMT-SYS/fetches/main.php");
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("newrec=" + dbParam);
            },
            closeRecord(){
                this.newRecord = {};
                console.log(this.newRecord);
            },
            printRecord(){
                this.newRecord = {};
            }
            
        }
    })
        
    </script>
</body>
</html>