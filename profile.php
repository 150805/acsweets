<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found!";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - AC Sweets</title>
    <link rel="stylesheet" href="homestyles.css">
</head>
<body>
    <header>
        <div class="sweet">
            <h1>AC Sweets - User Profile</h1>
            <nav>
                <ul class="navbar">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="form">
        <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?></h2>

        <h3>Profile Information</h3>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Account Type:</strong> <?php echo $user['is_admin'] ? "Admin" : "User"; ?></p>
        <?php if (!empty($user['profile_pic'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" style="max-width:150px;">
        <?php endif; ?>

        <h3>Update Profile Picture</h3>
        <form action="profile.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="profile_pic" accept="image/*">
            <button type="submit">Update Profile Picture</button>
        </form>

        <h3>Change Password</h3>
        <form action="change_password.php" method="POST">
            <input type="password" name="old_password" placeholder="Old Password" required><br>
            <input type="password" name="new_password" placeholder="New Password" required><br>
            <button type="submit">Update Password</button>
        </form>

        <h3>Update Email</h3>
        <form action="update_email.php" method="POST">
            <input type="email" name="new_email" placeholder="New Email" required><br>
            <button type="submit">Update Email</button>
        </form>

        <h3>Your Order History</h3>
        <?php
        $sql = "SELECT * FROM orders WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $orders = $stmt->fetchAll();

        if ($orders) {
            foreach ($orders as $order) {
                echo "<p><strong>Cake:</strong> " . htmlspecialchars($order['title']) . "<br>
                          <strong>Ingredients:</strong> " . htmlspecialchars($order['ingredients']) . "<br>
                          <strong>Instructions:</strong> " . htmlspecialchars($order['instructions']) . "</p><hr>";
            }
        } else {
            echo "<p>You have no orders yet.</p>";
        }
        ?>
    </div>

    <footer>
        <p><b>AC Sweets, Homemade with love for You!</b><br>&copy; 2025 AC Sweets. All rights reserved</p>
    </footer>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    $profile_pic = $_FILES['profile_pic']['name'];
    $target = "uploads/" . basename($profile_pic);

    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
        $sql = "UPDATE users SET profile_pic=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$profile_pic, $user_id])) {
            header('Location: profile.php');
        } else {
            echo "Error updating profile picture!";
        }
    } else {
        echo "Failed to upload profile picture!";
    }
}
?>
