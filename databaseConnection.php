<?php 
// variable declaration
$serverName = "is3-dev.ict.ru.ac.za";
$user = "CtrlAlt404";
$password = "Ctrl@lt404";
$database = "ctrlalt404"; //check schema's name in my workbench

//connecttion string/ statement for oop
$conn = new mysqli($serverName, $user, $password, $database);

if ($conn->connect_error){
    die("Connection to server and database failed" .$conn->connect_error);
} else {
    //echo "successfully established connection"; //delete this when connection is established
}

?>
