<?php
// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $dbname = "evidence-in-php";
    $user = "root"; // change if needed
    $pass = "";     // change if needed

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact_no'];

    $stmt = $conn->prepare("CALL InsertManufacturer(?, ?, ?)");
    $stmt->bind_param("sss", $name, $address, $contact_no);

    if ($stmt->execute()) {
        $message = "✅ Manufacturer inserted successfully.";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Manufacturer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            padding-top: 50px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 20px;
            font-weight: bold;
            color: green;
            text-align: center;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add Manufacturer</h2>

    <?php if (!empty($message)): ?>
        <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : ''; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Address:</label>
        <input type="text" name="address" required>

        <label>Contact Number:</label>
        <input type="text" name="contact_no" required>

        <input type="submit" value="Insert Manufacturer">
    </form>
</div>
</body>
</html>
