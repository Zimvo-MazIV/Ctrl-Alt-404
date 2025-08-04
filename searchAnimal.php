<?php
include 'databaseConnection.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$aname = $_GET['aname'] ?? '';
$species = $_GET['species'] ?? '';
$status = $_GET['availabilityStatus'] ?? '';

$sql = "SELECT * FROM animal WHERE 1=1";
$params = [];
$types = "";

if (!empty($aname)) {
    $sql .= " AND aname LIKE ?";
    $params[] = "%$aname%";
    $types .= "s";
}

if (!empty($species)) {
    $sql .= " AND species LIKE ?";
    $params[] = "%$species%";
    $types .= "s";
}

if (!empty($status)) {
    $sql .= " AND availabilityStatus = ?";
    $params[] = $status;
    $types .= "s";
}

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Search Results</h2>";

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>Picture</th>
            <th>Name</th>
            <th>Species</th>
            <th>Breed</th>
            <th>Age</th>
          //  <th>Status</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    $imgPath = htmlspecialchars($row['picture']);
    if (!empty($imgPath) && file_exists($imgPath)) {
        echo "<td><img src='" . $imgPath . "' width='80' height='80' alt='Animal Photo'></td>";
    } else {
        echo "<td><span style='color: #888;'>No image</span></td>";
    }
    echo "<td>" . htmlspecialchars($row['aname']) . "</td>";
    echo "<td>" . htmlspecialchars($row['species']) . "</td>";
    echo "<td>" . htmlspecialchars($row['breed']) . "</td>";
    echo "<td>" . (int)$row['age'] . "</td>";
    echo "<td>" . htmlspecialchars($row['availabilityStatus']) . "</td>";
    echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>No animals found.</p>";
}

$stmt->close();
$conn->close();
?>
