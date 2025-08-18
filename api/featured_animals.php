<?php
//Fallback knowledge was learnt from Copilot
header('Content-Type: application/json');

require_once __DIR__ . '/../databaseConnection.php';

function getSpeciesFallbackImage($species)
{
	$species = strtolower((string)$species);
	if ($species === 'dog') {
		return 'images/Dog/pexels-jhelmuth-3995454.jpg';
	}
	if ($species === 'cat') {
		return 'images/Cat/pexels-athenea-codjambassis-rossitto-472760075-26263095.jpg';
	}
	if ($species === 'bird') {
		return 'images/Parrot/pexels-anntarazevich-6796544.jpg';
	}
	return 'images/General/Kennel2.jpg';
}

$animals = [];

// Attempt 1: MySQL schema used in existing PHP (animal.aname, picture)
$sqlV1 = "SELECT animalID, aname AS name, species, age, breed, availabilityStatus, rescueDate, picture
          FROM animal
          WHERE availabilityStatus = 'Available for Adoption'
          ORDER BY rescueDate DESC
          LIMIT 6";

$result = $conn->query($sqlV1);

if ($result instanceof mysqli_result) {
	while ($row = $result->fetch_assoc()) {
		$imageFile = isset($row['picture']) ? trim($row['picture']) : '';
		$imageUrl = $imageFile !== '' ? ('images/' . $imageFile) : getSpeciesFallbackImage($row['species']);

		$animals[] = [
			'id' => (int)$row['animalID'],
			'name' => $row['name'],
			'species' => $row['species'],
			'age' => $row['age'] !== null ? (int)$row['age'] : null,
			'breed' => $row['breed'] ?? null,
			'availability' => $row['availabilityStatus'] ?? null,
			'rescueDate' => $row['rescueDate'] ?? null,
			'imageUrl' => $imageUrl,
		];
	}
	$result->free();
}

// Attempt 2: Schema from create_users_table.sql (Animal.name, no picture)
if (count($animals) === 0) {
	$sqlV2 = "SELECT animalID, name, species, age, breed, availabilityStatus, rescueDate
              FROM Animal
              WHERE availabilityStatus = 'Available'
              ORDER BY rescueDate DESC
              LIMIT 6";
	if ($result2 = $conn->query($sqlV2)) {
		while ($row = $result2->fetch_assoc()) {
			$imageUrl = getSpeciesFallbackImage($row['species']);
			$animals[] = [
				'id' => (int)$row['animalID'],
				'name' => $row['name'],
				'species' => $row['species'],
				'age' => $row['age'] !== null ? (int)$row['age'] : null,
				'breed' => $row['breed'] ?? null,
				'availability' => $row['availabilityStatus'] ?? null,
				'rescueDate' => $row['rescueDate'] ?? null,
				'imageUrl' => $imageUrl,
			];
		}
		$result2->free();
	}
}

echo json_encode(['animals' => $animals]);


