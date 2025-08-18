<?php
// Some Code has been modified and edited to suit the needs of the project 
// initially was learnt through Stack Overflow and a ChatGPT explanation
header('Content-Type: application/json');

require_once __DIR__ . '/../databaseConnection.php';

$data = [];

// Helper to run a count safely without breaking the page if a table does not exist yet
$tryCount = function (mysqli $conn, array $queries) {
	foreach ($queries as $sql) {
		$res = $conn->query($sql);
		if ($res && ($row = $res->fetch_row())) {
			$res->free();
			return (int)$row[0];
		}
	}
	return null;
};

$data['totalAnimals'] = $tryCount($conn, [
	"SELECT COUNT(*) FROM animal",
	"SELECT COUNT(*) FROM Animal",
]);

$data['availableAnimals'] = $tryCount($conn, [
	"SELECT COUNT(*) FROM animal WHERE availabilityStatus = 'Available'",
	"SELECT COUNT(*) FROM Animal WHERE availabilityStatus = 'Available'",
]);

$data['adoptedAnimals'] = $tryCount($conn, [
	"SELECT COUNT(*) FROM animal WHERE availabilityStatus = 'Adopted'",
	"SELECT COUNT(*) FROM Animal WHERE availabilityStatus = 'Adopted'",
]);

// Kennel occupancy (sum currentOccupancy and capacity)
$occQueries = [
	"SELECT COALESCE(SUM(currentOccupancy),0), COALESCE(SUM(capacity),0) FROM kennel",
	"SELECT COALESCE(SUM(currentOccupancy),0), COALESCE(SUM(capacity),0) FROM Kennel",
];
foreach ($occQueries as $q) {
	$resOcc = $conn->query($q);
	if ($resOcc && ($row = $resOcc->fetch_row())) {
		$data['kennelCapacityUsed'] = (int)$row[0];
		$data['kennelCapacityTotal'] = (int)$row[1];
		$resOcc->free();
		break;
	}
}

echo json_encode($data);


