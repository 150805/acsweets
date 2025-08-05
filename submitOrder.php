<?php
session_start();
require_once 'db_connect.php';

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $ingredients = $_POST['ingredients'] ?? '';
    $instructions = $_POST['instructions'] ?? '';
    $imagePath = '';

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = basename($_FILES['image']['name']);
        $fileTmp = $_FILES['image']['tmp_name'];
        $targetPath = $uploadDir . time() . "_" . $fileName;

        if (move_uploaded_file($fileTmp, $targetPath)) {
            $imagePath = $targetPath;
        } else {
            $error = 'Failed to upload image.';
        }
    }

    // Insert into database
    if (empty($error)) {
        $stmt = $pdo->prepare("INSERT INTO orders (title, ingredients, instructions, image_path, created_at) VALUES (?, ?, ?, ?, NOW())");
        if ($stmt->execute([$title, $ingredients, $instructions, $imagePath])) {
            $success = "Order submitted successfully!";
        } else {
            $error = "Error saving order to the database.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit an Order - AC Sweets</title>
  <link rel="stylesheet" href="homestyles.css">
</head>
<body>
  <header class="sweet">
    <h1>AC Sweets!</h1>
    <nav>
      <ul class="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="Sweets.html">Sweets</a></li>
        <li><a href="submitOrder.php">Submit Order</a></li>
        <li><a href="reachus.php">Contact Us</a></li>
      </ul>
    </nav>
    <h2>Submit Your Order</h2>
  </header>

  <div class="form">
    <?php if ($success): ?>
      <p style="color: green;"><?php echo $success; ?></p>
    <?php elseif ($error): ?>
      <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="submitOrder.php" method="POST" enctype="multipart/form-data">
      <label for="title">Cake Type:</label><br>
      <select id="title" name="title" required>
        <option value="">Select a cake type</option>
        <option value="Chocolate cake">Chocolate cake</option>
        <option value="Fruit cake">Fruit cake</option>
        <option value="Vegeterian/Special cake">Vegeterian/Special cake</option>
        <option value="Forest/Velvet cake">Forest/Velvet cake</option>
      </select><br><br>

      <label for="ingredients">Ingredients or Preferences:</label><br>
      <textarea id="ingredients" name="ingredients" required></textarea><br><br>

      <label for="instructions">Instructions or Allergies:</label><br>
      <textarea id="instructions" name="instructions" required></textarea><br><br>

      <label for="image">Cake Image (optional):</label><br>
      <input type="file" name="image"><br><br>

      <input type="submit" value="Submit Order">
    </form>
  </div>

  <footer>
    <p><b>AC sweets, Homemade with love for You!</b><br>&copy; 2025 AC Sweets. All rights reserved</p>
  </footer>
</body>
</html>
