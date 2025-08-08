<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Kennels</title>
</head>
<body>
    <?php
    include 'databaseConnection.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $capacity = $_POST['capacity'];
        $species = $_POST['species'];
        $currentOcc = $_POST['currentOccupancy'];
        $size = $_POST['asize'];

        //insert sql in the database table
        $sql2 = "INSERT INTO kennel(capacity, species, currentOccupancy, asize)
                    VALUES('$capacity', '$species', '$currentOcc','$size')";

        $res = $conn->query($sql2);
        if($res === TRUE){
            echo "<br>The Kennel has been succesfully added!";
        } else {
            echo "<br>Error adding kennel" . $conn->error ."</br>";
        }

        $conn->close();
    }
    ?>
</body>

</html>
