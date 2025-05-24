<?php
// Connection setup
$host = "localhost";
$dbname = "evidence-in-php";
$user = "root"; // change if needed
$pass = "";     // change if needed

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['manufacturer_id'])) {
    $manufacturer_id = $_POST['manufacturer_id'];

    $stmt = $conn->prepare("DELETE FROM Manufacturer WHERE id = ?");
    $stmt->bind_param("i", $manufacturer_id);

    if ($stmt->execute()) {
        $message = "✅ Manufacturer and related products deleted successfully.";
    } else {
        $message = "❌ Error deleting record: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch manufacturers for dropdown
$manufacturers = $conn->query("SELECT id, name FROM Manufacturer");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Manufacturer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
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

        label, select, input[type="submit"] {
            display: block;
            width: 100%;
            margin-top: 15px;
        }

        select, input[type="submit"] {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #dc3545;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #c82333;
        }

        .message {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Delete Manufacturer</h2>

    <?php if (!empty($message)): ?>
        <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : ''; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <label for="manufacturer_id">Select Manufacturer:</label>
        <select name="manufacturer_id" id="manufacturer_id" required>
            <option value="">-- Select --</option>
            <?php while ($row = $manufacturers->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['id'] . ' - ' . htmlspecialchars($row['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="submit" value="Delete Manufacturer">
    </form>
</div>
</body>
</html>
<?php $conn->close(); ?>
