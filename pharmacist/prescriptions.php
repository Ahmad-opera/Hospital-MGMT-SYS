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
    
    <div v-if="bill" class="absolute z-40 w-full h-screen px-16 py-6 pt-16" style="background-color: rgba(0, 0, 0, .3);">
        <div class="w-64 px-6 py-3 mx-auto bg-white rounded-xl">
            <div class="px-10 py-1 mx-auto mt-2 border-t-2 border-b-2 border-dashed ">
                <h1 class="text-xl font-semibold text-center ">RECEIPT</h1>
            </div>
            <div class="flex py-3 text-xs">
                <h1 class="">#: {{ bill.id }}</h1>
                <h1 class="ml-auto ">{{ bill.date }} &nbsp;&nbsp; {{bill.time}}</h1>
                        
            </div>
            <ul v-if="bill.items" class="py-6 text-xs font-semibold text-black border-t-2 border-b-2 border-dashed">
                <li v-for="item in bill.items" :key="item.id" class="flex">{{item.qty}} x {{item.drug_name}} <div class="ml-auto">₦{{item.price * item.qty}}</div></li>
            </ul>
            <div class="px-4 py-2 border-b-2 border-dashed">
                <h1 class="flex w-full text-lg font-semibold">Total: <div class="ml-auto">₦{{bill.total}}</div></h1>
            </div>
            <div class="py-2 font-semibold text-center border-b-2 border-dashed">
                ******** THANK YOU! *******
            </div>
            <div class="flex justify-between gap-3 py-2 mx-auto text-white bg-gray-50">
                <button @click="confirmBill(bill.id)" class="w-full px-4 py-3 bg-green-500 shadow rounded-xl">
                <svg  class="mx-auto icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M5 12l5 5l10 -10"></path>
                    </svg></button>
                <button @click="cancelBill(bill.id)" class="w-full px-4 py-3 bg-red-500 shadow rounded-xl">
                <svg class="mx-auto icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg></button>
            </div>
        </div>
    </div>
    
        <div class="flex flex-row w-full min-h-screen px-6 py-8 mx-auto bg-white shadow-lg bg-gray-50">
            <div class="w-full px-8 py-4 h-80 rounded-xl">
                <h1 class="py-4 text-lg font-semibold">Search for records</h1>
                <input type="text" v-model:value="searchKeys" v-on:keyup="searchRec()" placeholder="Search Keyword" class="col-span-6 px-6 py-2 rounded-lg shadow-inner focus:outline-none bg-blue-50">
                <div class="pt-10" v-if="searchRes">
                <table class="table-auto min-w-max" >
                    <thead>
                        <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                            <th class="w-12 px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Prescribed For</th>
                            <th class="px-6 py-3 text-left">Age</th>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left"></th>
                        </tr>
                    </thead>
                    <tbody class="text-sm font-light text-gray-600">
                        <tr class="border-b border-gray-200 hover:bg-gray-100" >
                                <td class="w-12 px-6 py-3 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">
                                            {{searchRes.id}}
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-3 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">
                                            {{searchRes.patient_id.full_name}}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">
                                            {{searchRes.patient_id.dob}}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">
                                            {{searchRes.date}}
                                        </span>
                                    </div>
                                </td>
                                
                                <td>
                                    <button @click="previewPrescription = searchRes" class="px-4 py-2 text-white bg-green-500 rounded-full shadow">View</button>
                                </td>
                            </tr>
                    </tbody>
                </table>
                <div class="h-56 px-6 py-4 mt-5 border border-gray-200 rounded-lg" v-if="previewPrescription">
                    {{previewPrescription.drugs_prescription}}
                </div>
                </div>
            </div>
            <div class="w-full px-6 border border-gray-200 rounded-lg">
                <h1 class="py-4 text-2xl font-semibold text-center">Drug Search & Sales</h1>
                <input type="text" v-model:value="drugSearchKey" v-on:keyup="searchDrug()" placeholder="Search Keyword" class="w-64 px-6 py-2 mx-auto rounded-lg shadow-inner focus:outline-none bg-blue-50">
                <div class="grid h-56 grid-cols-1 gap-3 px-6 py-6 mt-5 overflow-y-scroll bg-gray-100 border border-gray-200 rounded-lg" v-if="drugSearchRes">
                    <div class="flex items-center px-4 py-2 bg-white rounded-full shadow-lg max-h-12" v-for="drug in drugSearchRes" :key="drug.id">
                        <span class="text-sm">{{drug.drug_name}}</span>
                        <button @click="addToCart(drug)" :title="drug.price" class="right-0 w-8 h-8 ml-auto text-white transition bg-green-500 rounded-full focus:outline-none duration-350 hover:bg-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto icon icon-tabler icon-tabler-plus" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                    </div>
                </div>
                <div class="grid h-56 grid-cols-1 gap-3 px-6 py-6 mt-5 overflow-y-scroll bg-gray-100 border border-gray-200 rounded-lg" v-else>
                    Please input a keyword to search...
                </div>
                <div class="flex w-full">
                    <div class="w-full h-56 px-6 py-4 mt-5 overflow-y-scroll border border-gray-200 rounded-lg " v-if="drug_cart">
                        <!-- Here starts an item in cart list -->
                        <div  v-for="drug in drug_cart" :key="drug.id" class="flex py-1 text-sm focus:shadow">
                            <span class="w-10/12">{{drug.drug_name}} <span class="right-0 ml-auto">({{drug.qty_type}})</span> </span>
                            <input type="number" min="1" v-model:value="drug_cart[drug_cart.indexOf(drug)].qty" class="w-12 px-2 py-1 mx-2 rounded-lg shadow-inner focus:outline-none bg-green-50">
                            <button class="focus:outline-none" v-on:click="delEnt(drug)">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-300 hover:text-red-400 icon icon-tabler icon-tabler-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>
                        <!-- Here ends an item in cart list -->
                    </div>
                </div>
                <div class="flex items-center w-full transition duration-250" v-if="total > 0">
                    <h1 class="p-4 text-xl font-semibold">Total: ₦{{total}}</h1>
                    <div class="p-4" v-else>&nbsp;</div>
                    <button @click="genReceipt()" class="right-0 flex items-center h-12 px-8 py-4 ml-auto font-semibold text-white bg-green-600 border border-green-400 rounded-lg rounded-full w-max">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-receipt-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2" />
                            <path d="M14 8h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5m2 0v1.5m0 -9v1.5" />
                            </svg>
                            Checkout
                    </button>
                    
                </div>
            </div>
        <form class="absolute bottom-0 mb-4 mr-auto" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
          <button type="submit" name="logout" class="px-4 py-2 font-semibold rounded-full hover:bg-red-300">Logout</button>
        </form>
        </div>
    </div>

    <script>
        const vueApp = new Vue({
        el: '#vapp',
        data: {
            bill: null,
            previewPrescription: null,
            searchRes: null,
            drugSearchRes: null,
            searchKeys: '',
            assignSuccess: false,
            drugSearchKey: '',
            drug_cart: []
        },
        computed: {
            total: function(val){
                let total = 0;
                this.drug_cart.forEach(e => {
                    total += Number(e.price * e.qty);
                })
                return Number(total);
            }
        },
        methods: {
            genReceipt(){
                let comp = this;
                const dbParam = JSON.stringify({data: {drug_cart: this.drug_cart, total: this.total}});
                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function() {
                    let myObj = JSON.parse(this.responseText);
                    myObj.items = JSON.parse(myObj.items);
                    comp.bill = myObj;
                }
                xmlhttp.open("POST", "http://localhost/Hospital-MGMT-SYS/fetches/main.php");
                xmlhttp.setRequestHeader("Content-type", "application/json");
                xmlhttp.send(dbParam);
            },
            searchRec(){
                let comp = this;
                this.viewPrescription = null;
                fetch('http://localhost/Hospital-MGMT-SYS/fetches/main.php?getapp='+this.searchKeys)
                .then(res => res.json())
                .then(data => {
                comp.searchRes = data;
                fetch('http://localhost/Hospital-MGMT-SYS/fetches/main.php?getpatient=' + comp.searchRes.patient_id)
                .then(res => res.json())
                .then(data => {
                    comp.searchRes.patient_id = data;
                    let date = new Date();
                    comp.searchRes.patient_id.dob = (date.getFullYear() - new Date(comp.searchRes.patient_id.dob).getFullYear());
                })
                });
            },
            confirmBill(){
                this.bill = null;
                this.drug_cart = [];
            },
            cancelBill(receipt_id){
                let comp = this;

                fetch("http://localhost/Hospital-MGMT-SYS/fetches/main.php?delreceipt="+receipt_id)
                .then(res => res.json())
                .then(data => {
                    this.bill = null;
                    console.log(data)
                });
            },
            addToCart(item){
                if(this.drug_cart.findIndex(x => x.id === item.id) === -1){
                        this.drug_cart.push({
                        id: item.id, 
                        drug_name: item.drug_name, 
                        qty: 1, 
                        qty_type: item.qty_type,
                        price: Number(item.price)})
                    }else{
                    console.log("Already There!")
                }
            },
            searchDrug(){
                let comp = this;
                fetch('http://localhost/Hospital-MGMT-SYS/fetches/main.php?getmeds='+this.drugSearchKey)
                .then(res => res.json())
                .then(data => {
                    comp.drugSearchRes = data
                    console.log(data)
                })
            },
            delEnt(item){
                this.drug_cart.splice(this.drug_cart.indexOf(item), 1)
            },
        }
    })
        
    </script>
</body>
</html>