<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a New Animal</title>
</head>
<body>
    <?php
    include "databaseConnection.php";


    //getting the kennel ID since it is a foreign key in the animal table
    $kennelsql = "SELECT * FROM kennel WHERE kennelId = '$kennel_id";
    $result = $conn->query($kennelsql);
    ?>
    <!--Creating a form to add in the animals-->
    <form action="addAnimalProcess.php" method="POST" enctype="multipart/form-data">
        <h2>Animal Information</h2>

        <label>Animal ID:</label> <input type="text" name="animalID" required><br><br>

        <label>Name:</label> <input type="text" name="aname" required><br><br>

        <label>Species:</label> <input type="text" name="species" required><br><br>

        <label>Age:</label> <input type="text" name="age" required><br><br>

        <label>Breed:</label> <input type="text" name="breed" required><br><br>

        <label>Health Status:</label> <input type="text" name="healthStatus" required><br><br>

        <label> Rescue Date:</label> <input type="date" name="rescueDate" required><br><br>

        <label>Intake Type:</label> <input type="text" name="intakeType" required><br><br>

        <label>Rescue Location:</label> <input type="text" name="rescueLocation" required><br><br>

        <label>Rescue Type:</label> <input type="text" name="rescueType" required><br><br>

        <label>Availability Status:</label> <input type="text" name="availabilityStatus" required><br><br>

        <label>Kennel ID:</label> <input type="text" name="kennelID" required> <br> <br>

        <label>Animal Image:</label> <input type="file" id="picture" name="picture" required><br><br>

        <input type="submit" value="Create an animal record">
    </form>
</body>
</html>