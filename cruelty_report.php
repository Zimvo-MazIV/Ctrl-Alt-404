<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cruelty Report | SPCA GHT</title>
</head>
<body>

<h1>Report Succesfully Logged</h1>
<?php
include "databaseConnection.php";
//sql to insert the data into the database

//retrieve data from html
$repName   = $_POST['name'];
$phone     = $_POST['phone'];
$email     = $_POST['email'];
$inciddate = $_POST['inciddate'];
$location  = $_POST['location'];
$descr     = $_POST['inciddescr'];
$evidence  = $_POST['incidevidence'];
$resolved  = 0; // Default value, will be turned to 1 when case is resolved.

$sql = "INSERT INTO cruelty_reports 
    (reporter_name, `description`, `date`, phone_num, email, `location`, evidence, resolved)
    VALUES (
        '$repName', 
        '$descr', 
        '$inciddate',
        '$phone', 
        '$email', 
        '$location', 
        '$evidence', 
        $resolved
    )";
$result = $conn->query($sql);
if($result === TRUE){
    echo "Please find your reference number below. <br>";
}else{
    "There was an issue retrieving your case reference number \n Please Contact SPCA GHT";
}

//let us deal with the case reference numbers
$sql_id = "SELECT reportID from cruelty_reports"; //sql for report ID
$result_id =$conn->query($sql_id); //running sql for reportID.

if($conn->query($sql_id)){
    $repID = $conn->insert_id; // Gets the last auto-incremented ID
    echo "<h3>Your case reference number is: $repID</h3>";

}else{
    echo "There was an issue retrieving your case reference number \n Please Contact SPCA GHT";
}

$conn -> close();

?>
    
</body>
</html>