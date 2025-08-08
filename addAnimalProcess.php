<?php
include "databaseConnection.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['aname'];
    $species = $_POST['species'];
    $age = $_POST['age'];
    $breed = $_POST['breed'];
    $status = $_POST['healthStatus'];
    $resDate = $_POST['rescueDate'];
    $intake = $_POST['intakeType'];
    $location = $_POST['rescueLocation'];
    $rtype = $_POST['rescueType'];
    $availabilty = $_POST['availabilityStatus'];
    $kennel_id = $_POST['kennelID'];
    $picture = $_FILES['picture']['name'];
    
    $destination = "animals/" .$picture;
    move_uploaded_file($_FILES['picture']['tmp_name'], $destination);

    //insert statement to add in the database table for animals
    $sql1 = "INSERT INTO animal(aname, species, age, breed, healthStatus,
     rescueDate, intakeType, rescueLocation, rescueType, availabilityStatus, kennelID, picture)
                VALUES('$name', '$species', '$age', '$breed', '$status', '$resDate',
                 '$intake','$location', '$rtype', '$availabilty', '$kennel_id', '$picture')";

    $result = $conn->query($sql1); //query statement to connect to the database and execute
    if($result == FALSE) {
        die("Unable to add the animal" . $conn->error); //produces the error

    } else {
        echo "<br> Animal successfully added! </br>";
    }

    $conn->close(); 

    //navigation to other forms

}
?>
