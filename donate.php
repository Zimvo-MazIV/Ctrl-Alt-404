<?php
// Database connection
//include 'databaseConnection.php';

/*$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
*/
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $donation_type = $_POST['donation_type'];
    $amount     = $_POST['amount'];

    $sql = "INSERT INTO donations (first_name, last_name, email, phone, donation_type, amount)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssd", $first_name, $last_name, $email, $phone, $donation_type, $amount);

    if ($stmt->execute()) {
        $message = "Thank you for your donation!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Donate</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .container { max-width: 600px; margin: auto; }
    label { display: block; margin-top: 10px; }
    input, select { width: 100%; padding: 8px; margin-top: 5px; }
    button { margin-top: 15px; padding: 10px; background: blue; color: white; border: none; cursor: pointer; }
    .message { margin-top: 15px; color: blue; }
    .bank-details { margin-top: 30px; padding: 15px; border: 1px solid #ccc; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Make a Donation</h1>
    <?php if ($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST">
      <label>First Name (Required)</label>
      <input type="text" name="first_name" required>
      
      <label>Last Name (Required)</label>
      <input type="text" name="last_name" required>
      
      <label>Email (Required)</label>
      <input type="email" name="email" required>
      
      <label>Phone Number</label>
      <input type="text" name="phone">
      
      <label>Donation Type</label>
      <select name="donation_type" required>
        <option value="Monthly">Monthly</option>
        <option value="Once-off">Once-off</option>
      </select>
      
      <label>Enter Amount (Required)</label>
      <input type="number" name="amount" step="10" required>
      
      <label>
        <div style="display: flex; align-items: center;">
          <input type="checkbox" required style="width: auto; margin-right: 8px;">
          I agree to the processing of my personal information.
        </div>
     </label>
      
      <button type="submit">Donate</button>
    </form>

    <div class="bank-details">
      <h2>Other Payment Methods</h2>
      <p><b>Bank:</b> Standard Bank</p>
      <p><b>Branch:</b> 123456 / 654321 (Internet banking)</p>
      <p><b>Account Number:</b> 9876543210</p>
      <p><b>SWIFT:</b> SBZA ZA JJ</p>
      <p><b>Account Type:</b> Cheque</p>
      <p><b>Account Name:</b> Hope4Paws Foundation</p>
      <p><b>Beneficiary Reference:</b> Your Name and Email</p>
      <p><b>Send proof of payment to:</b> donations@Hope4Paws.org</p>
    </div>
  </div>
</body>
</html>
