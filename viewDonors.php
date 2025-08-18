<?php
// Database connection
include 'databaseConnection.php';

$sql = "SELECT * FROM donations ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Donations Report</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h2 { text-align: center; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #007b5e; color: white; }
    tr:nth-child(even) { background: #f2f2f2; }
  </style>
</head>
<body>
  <h2>All Donations</h2>

  <table>
    <tr>
      <th>ID</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Donation Type</th>
      <th>Amount</th>
      <th>Date</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo $row['donation_type']; ?></td>
                <td>R <?php echo number_format($row['amount'], 2); ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="8">No donations found.</td></tr>
    <?php endif; ?>
  </table>
</body>
</html>
