<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $age = $_POST['age'] ?? '';
    $accountType = $_POST['accountType'] ?? '';
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($phone) || empty($age) || empty($accountType)) {
        $error = 'All fields are required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } elseif (!preg_match('/^[A-Za-z\s]+$/', $name)) {
        $error = 'Name should contain only letters and spaces';
    } elseif (!preg_match('/^\d+$/', $phone)) {
        $error = 'Phone number should contain only numbers';
    } elseif (strlen($phone) < 10) {
        $error = 'Phone number should be at least 10 digits';
    } elseif ($age < 18) {
        $error = 'You must be at least 18 years old';
    } else {
        // Check if email is changed and already exists
        if ($email !== $user['email']) {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $_SESSION['user_id']]);
            if ($stmt->rowCount() > 0) {
                $error = 'Email already exists';
            }
        }
        
        if (!$error) {
            // Update user
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone = ?, age = ?, account_type = ? WHERE id = ?");
            if ($stmt->execute([$name, $email, $phone, $age, $accountType, $_SESSION['user_id']])) {
                $success = 'Profile updated successfully!';
                $_SESSION['name'] = $name;
                // Refresh user data
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch();
            } else {
                $error = 'Profile update failed. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AC School - Profile</title>
  <link rel="stylesheet" href="homestyles.css">
</head>
<body>
  <header>
    <div class="sweet">
      <h1>AC School!</h1>
      <nav>
        <ul class="navbar">
          <li><a href="index.php">Home</a></li> 
          <li><a href="reachus.php">Contact Us</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
      <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
    </div>
  </header>

  <div class="form">
    <?php if ($error): ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
      <div class="success-message"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <form id="profileForm" action="profile.php" method="post">
      <label for="name">Full Name:</label><br>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
      
      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
      
      <label for="phone">Phone Number:</label><br>
      <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
      
      <label for="age">Age:</label><br>
      <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
      
      <label for="accountType">Account Type:</label><br>
      <select id="accountType" name="accountType" style="width: 100%; padding: 8px; box-sizing: border-box;">
        <option value="April" <?php echo $user['account_type'] === 'April' ? 'selected' : ''; ?>>April</option>
        <option value="August" <?php echo $user['account_type'] === 'August' ? 'selected' : ''; ?>>August</option>
        <option value="November" <?php echo $user['account_type'] === 'November' ? 'selected' : ''; ?>>November</option>
      </select><br><br>
      
      <button type="submit" style="width: 100%; padding: 10px;">Update Profile</button>
    </form>
  </div>

  <footer>
    <ul class="rights">
      <p><b>AC sweets, Homemade with love for You!</b>
      <br>&copy; 2025 AC Sweets. All rights reserved</p>
    </ul>
  </footer>
</body>
</html>