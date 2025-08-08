<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a New Animal</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { max-width: 500px; margin: 40px auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 8px #ccc; }
        h2 { text-align: center; }
        label { display: block; margin-top: 12px; }
        input[type="text"], input[type="date"], input[type="file"], select {
            width: 100%; padding: 8px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px;
        }
        button {
            margin-top: 18px;
            width: 100%;
            padding: 10px;
            background: #005379;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        button:hover { background: #0287a8; }
    </style>
</head>
<body>

<div class="container">
    <h2>Add a New Animal</h2>

    <form action="addAnimalProcess.php" method="POST" enctype="multipart/form-data">
        <label for="aname">Name:</label>
        <input type="text" name="aname" id="aname" required>

        <label for="species">Species:</label>
        <input type="text" name="species" id="species" required>

        <label for="age">Age:</label>
        <input type="text" name="age" id="age" required>

        <label for="breed">Breed:</label>
        <input type="text" name="breed" id="breed" required>

        <!-- Health Status dropdown -->
        <label for="healthStatus">Health Status:</label>
        <select name="healthStatus" id="healthStatus" required>
            <option value="">-- Select Health Status --</option>
            <option value="Healthy">Healthy</option>
            <option value="Injured">Injured</option>
            <option value="Sick">Sick</option>
            <option value="Recovering">Recovering</option>
            <option value="Vaccinated">Vaccinated</option>
            <option value="Not Vaccinated">Not Vaccinated</option>
            <option value="Unknown">Unknown</option>
        </select>

        <label for="rescueDate">Rescue Date:</label>
        <input type="date" name="rescueDate" id="rescueDate" required>

        <!-- Intake Type dropdown -->
        <label for="intakeType">Intake Type:</label>
        <select name="intakeType" id="intakeType" required>
            <option value="">-- Select Intake Type --</option>
            <option value="Stray">Stray</option>
            <option value="Owner Surrender">Owner Surrender</option>
            <option value="Transferred from Another Shelter">Transferred from Another Shelter</option>
            <option value="Confiscated">Confiscated</option>
            <option value="Born in Shelter">Born in Shelter</option>
        </select>

        <label for="rescueLocation">Rescue Location:</label>
        <input type="text" name="rescueLocation" id="rescueLocation" required>

        <!-- Rescue Type dropdown -->
        <label for="rescueType">Rescue Type:</label>
        <select name="rescueType" id="rescueType" required>
            <option value="">-- Select Rescue Type --</option>
            <option value="Field Rescue">Field Rescue</option>
            <option value="Emergency Rescue">Emergency Rescue</option>
            <option value="Public Drop-off">Public Drop-off</option>
            <option value="Animal Control Pickup">Animal Control Pickup</option>
            <option value="Welfare Inspection">Welfare Inspection</option>
        </select>

        <!-- Availability Status dropdown -->
        <label for="availabilityStatus">Availability Status:</label>
        <select name="availabilityStatus" id="availabilityStatus" required>
            <option value="">-- Select Availability --</option>
            <option value="Available for Adoption">Available for Adoption</option>
            <option value="Under Veterinary Care">Under Veterinary Care</option>
            <option value="In Quarantine">In Quarantine</option>
            <option value="Adopted">Adopted</option>
            <option value="Deceased">Deceased</option>
            <option value="Fostered">Fostered</option>
        </select>

        <!-- Kennel dropdown -->
        <label for="kennelID">Kennel ID:</label>
        <select name="kennelID" id="kennelID" required>
            <option value="">-- Select Kennel --</option>
            <?php
            include "databaseConnection.php";
            $kennelsql = "SELECT kennelID FROM kennel";
            $result = $conn->query($kennelsql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['kennelID'] . "'>" . $row['kennelID'] . "</option>";
                }
            } else {
                echo "<option disabled>No kennels available</option>";
            }
            ?>
        </select>

        <label for="picture">Animal Image:</label>
        <input type="file" name="picture" id="picture">

        <button type="submit">Create Animal Record</button>
    </form>
</div>

</body>
</html>
