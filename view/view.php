<?php
// Database connection
$db = new mysqli("localhost", "root", "", "evidence-in-php"); // Adjust db name & credentials

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Create or replace the view for products with price > 5000
$createView = "CREATE OR REPLACE VIEW products_view AS
               SELECT id, name, price, manufacturer_id FROM Product WHERE price > 5000";

$viewMessage = "";
$viewMessageClass = "";

if ($db->query($createView)) {
    $viewMessage = "✅ View 'products_view' created successfully.";
    $viewMessageClass = "success";
} else {
    $viewMessage = "❌ Error creating view: " . htmlspecialchars($db->error);
    $viewMessageClass = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Products View - Price > 5000</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .message {
            width: 80%;
            margin: 20px auto;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 10px #ccc;
        }
        th, td {
            border: 1px solid #999;
            padding: 10px 15px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        caption {
            caption-side: top;
            font-weight: bold;
            font-size: 1.4em;
            margin-bottom: 10px;
            color: #333;
        }
    </style>
</head>
<body>

<h1>Products with Price Greater Than 5000</h1>

<div class="message <?php echo $viewMessageClass; ?>">
    <?php echo $viewMessage; ?>
</div>

<?php
// Query the view data
$sql = "SELECT * FROM products_view";
$result = $db->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<caption>Expensive Products</caption>";
    echo "<thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Manufacturer ID</th></tr></thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['price']) . "</td>";
        echo "<td>" . htmlspecialchars($row['manufacturer_id']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p style='text-align:center; font-size: 18px; color: #555;'>No products found with price greater than 5000.</p>";
}

$db->close();
?>

</body>
</html>
