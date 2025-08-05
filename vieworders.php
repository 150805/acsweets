<?php
session_start();
require_once 'db_connect.php';

// Redirect if not admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

// Fetch orders
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();
?>
s
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Orders - AC Sweets</title>
  <link rel="stylesheet" href="homestyles.css">
</head>
<body>
  <header class="sweet">
    <h1>AC Sweets - Admin Dashboard</h1>
    <nav>
      <ul class="navbar">
        <li><a href="admindashboard.php">Dashboard</a></li>
        <li><a href="viewOrders.php">View Orders</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="form">
    <h2>Submitted Cake Orders</h2>
    <?php if (count($orders) === 0): ?>
      <p>No orders submitted yet.</p>
    <?php else: ?>
      <table border="1" cellpadding="10">
        <tr>
          <th>ID</th>
          <th>Type</th>
          <th>Ingredients</th>
          <th>Instructions</th>
          <th>Image</th>
          <th>Submitted At</th>
        </tr>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['title']); ?></td>
            <td><?php echo nl2br(htmlspecialchars($order['ingredients'])); ?></td>
            <td><?php echo nl2br(htmlspecialchars($order['instructions'])); ?></td>
            <td>
              <?php if ($order['image_path']): ?>
                <img src="<?php echo $order['image_path']; ?>" alt="Cake Image" width="100">
              <?php else: ?>
                No image
              <?php endif; ?>
            </td>
            <td><?php echo $order['created_at']; ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php endif; ?>
  </div>

  <footer>
    <p><b>AC sweets, Homemade with love for You!</b><br>&copy; 2025 AC Sweets. All rights reserved</p>
  </footer>
</body>
</html>
