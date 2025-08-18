<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../databaseConnection.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$species = isset($_GET['species']) ? trim($_GET['species']) : '';
$breed = isset($_GET['breed']) ? trim($_GET['breed']) : '';

$animals = [];

// Helper to build WHERE with bindings (manual escaping for simplicity)
function buildConditions(mysqli $conn, array $map) {
	$conds = [];
	foreach ($map as $key => $value) {
		if ($value === null) continue;
		$conds[] = $key . " LIKE '%" . $conn->real_escape_string($value) . "%'";
	}
	return $conds;
}

// Attempt 1: MySQL schema used in existing PHP (animal.aname, picture)
$baseV1 = "SELECT animalID, aname AS name, species, age, breed, availabilityStatus, rescueDate, picture FROM animal WHERE availabilityStatus = 'Available for Adoption'";
$whereV1 = [];
if ($q !== '') { $whereV1[] = "(aname LIKE '%" . $conn->real_escape_string($q) . "%' OR breed LIKE '%" . $conn->real_escape_string($q) . "%')"; }
if ($species !== '') { $whereV1[] = "species = '" . $conn->real_escape_string($species) . "'"; }
if ($breed !== '') { $whereV1[] = "breed LIKE '%" . $conn->real_escape_string($breed) . "%'"; }
$sqlV1 = $baseV1 . (count($whereV1) ? (' AND ' . implode(' AND ', $whereV1)) : '') . " ORDER BY rescueDate DESC LIMIT 60";

if ($result = $conn->query($sqlV1)) {
	while ($row = $result->fetch_assoc()) {
		$imageFile = isset($row['picture']) ? trim($row['picture']) : '';
		$imageUrl = $imageFile !== '' ? ('images/' . $imageFile) : null;
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
// ONLY if no animals found in first attempt
if (count($animals) === 0) {
	$baseV2 = "SELECT animalID, name, species, age, breed, availabilityStatus, rescueDate FROM Animal WHERE availabilityStatus = 'Available'";
	$whereV2 = [];
	if ($q !== '') { $whereV2[] = "(name LIKE '%" . $conn->real_escape_string($q) . "%' OR breed LIKE '%" . $conn->real_escape_string($q) . "%')"; }
	if ($species !== '') { $whereV2[] = "species = '" . $conn->real_escape_string($species) . "'"; }
	if ($breed !== '') { $whereV2[] = "breed LIKE '%" . $conn->real_escape_string($breed) . "%'"; }
	$sqlV2 = $baseV2 . (count($whereV2) ? (' AND ' . implode(' AND ', $whereV2)) : '') . " ORDER BY rescueDate DESC LIMIT 60";

	if ($result2 = $conn->query($sqlV2)) {
		while ($row = $result2->fetch_assoc()) {
			// NO FALLBACK IMAGES - only show real animals with their actual data
			$animals[] = [
				'id' => (int)$row['animalID'],
				'name' => $row['name'],
				'species' => $row['species'],
				'age' => $row['age'] !== null ? (int)$row['age'] : null,
				'breed' => $row['breed'] ?? null,
				'availability' => $row['availabilityStatus'] ?? null,
				'rescueDate' => $row['rescueDate'] ?? null,
				'imageUrl' => null, // No fallback images for "show all" page
			];
		}
		$result2->free();
	}
}

echo json_encode(['animals' => $animals]);

?>