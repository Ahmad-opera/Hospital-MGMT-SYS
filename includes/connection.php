<?php
$mysqli = new mysqli("localhost","root","","hospital_mgmt_sys");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
?>