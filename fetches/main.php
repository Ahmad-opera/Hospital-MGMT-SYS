<?php
    session_start();
    // include('../includes/checkreception.php');
    include('../includes/connection.php');
    header("Content-Type: application/json; charset=UTF-8");
    $content = file_get_contents("php://input");
    $userId = $_SESSION['username'];

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newrec'])){
        $data = json_decode($_POST['newrec'])->data;
        $fullname = $data->fullname;
        $dob = $data->dob;
        $genotype = $data->genotype;
        $bloodgroup = $data->bloodgroup;
        $phone = $data->phone;
        $gender = $data->gender;
        $address = $data->address;
        
        $query = $mysqli->query("INSERT INTO patients (full_name, gender, dob, address, phone_number, blood_group, genotype) VALUES ('$fullname', '$gender', $dob, '$address', '$phone', '$bloodgroup', '$genotype')");
        if($query){
            $lastID = $mysqli->insert_id;
            $result = $mysqli->query("SELECT * FROM patients WHERE id = '$lastID'");
            echo json_encode($result->fetch_assoc());
        }else{
            echo json_encode("Failed");
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getdocs'])){
        $keys = $_GET['getdocs'];
        // echo json_encode($keys);
        if ($result = $mysqli -> query("SELECT * FROM users WHERE role='doctor'")) {
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getrecs'])){
        $keys = $_GET['getrecs'];
        // echo json_encode($keys);
        if ($result = $mysqli -> query("SELECT * FROM patients WHERE full_name LIKE '%$keys%' OR id LIKE '$keys%'")) {
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getwaitlist'])){
        $keys = $_GET['getwaitlist'];
        $userId = $_SESSION['fullname'];
        // echo json_encode($keys);
        // $currentDoc = $_SESSION['username'];
        if ($result = $mysqli -> query("SELECT * FROM appointments WHERE doctor_name = '$userId' AND closed=0")) {
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getpatient'])){
        $keys = $_GET['getpatient'];
        // echo json_encode($keys);
        // $currentDoc = $_SESSION['username'];
        if ($result = $mysqli->query("SELECT * FROM patients WHERE id='$keys'")) {
            echo json_encode($result->fetch_assoc());
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delreceipt'])){
        $keys = json_decode($_GET['delreceipt']);
        // echo json_encode($keys);
        
        if ($result = $mysqli->query("DELETE FROM receipts WHERE id='$keys'")) {
            echo json_encode("Success!");
        }else{
            echo json_encode("Couldn't find Record!");
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getapp'])){
        $keys = $_GET['getapp'];
        // echo json_encode($keys);
        // $currentDoc = $_SESSION['username'];
        if ($result = $mysqli->query("SELECT * FROM appointments WHERE id='$keys'")) {
            echo json_encode($result->fetch_assoc());
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mod_patient'])){
        $data = json_decode($_POST['mod_patient'])->data->patient;
        // echo json_encode($keys);
        // $currentDoc = $_SESSION['username'];
        if ($result = $mysqli->query("UPDATE patients SET full_name = '$data->full_name', dob = '$data->dob', address = '$data->address', phone_number = '$data->phone_number', gender = '$data->gender', genotype='$data->genotype', blood_group='$data->blood_group' WHERE id = '$data->id'")) {
            echo json_encode("Success!");
        }else{
            echo json_encode("Failed!");
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['endsession'])){
        $keys = json_decode($_POST['endsession'])->data;
        // echo json_encode($keys);
        $id = $keys->id;
        $note = $keys->note;
        $drugs_prescription = $keys->drugs_prescription;
        if ($result = $mysqli->query("UPDATE appointments SET note = '$note', drugs_prescription = '$drugs_prescription', closed = 1 WHERE id='$id'")) {
            echo json_encode("Success");
        }
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['patient_data'])){
        $keys = json_decode($_POST['patient_data'])->data;
        // echo json_encode($keys);
        $patient_id = $keys->patient_id;
        $doctor_name = $keys->doctor_name;
        if ($result = $mysqli->query("INSERT INTO appointments (patient_id, doctor_name) VALUES ('$patient_id', '$doctor_name')")) {
            $lastID = $mysqli->insert_id;
            $appointment = $mysqli->query("SELECT * FROM appointments WHERE id='$lastID'");
            if($appointment){
                echo json_encode($appointment->fetch_assoc());
            }else{
                echo json_encode($result->fetch_assoc());
            }
        }
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['getmeds'])){
        $keys = $_GET['getmeds'];
        // echo json_encode($keys);
        if ($result = $mysqli -> query("SELECT * FROM drugs WHERE drug_name LIKE '%$keys%' OR id LIKE '$keys%'")) {
            echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        }
    }
    

    if(isset($content) && json_decode($content) != null){
        $data = json_decode($content)->data;
        // echo json_encode($data);
        $total = $data->total;
        $items = json_encode($data->drug_cart);

        if($generateBill = $mysqli->query("INSERT INTO receipts (total, sold_by, items) VALUES ('$total', '$userId', '$items')")){
            $lastID = $mysqli->insert_id;
            $result = $mysqli->query("SELECT * FROM receipts WHERE id='$lastID'");
            echo json_encode($result->fetch_assoc());
        }
    }

?>