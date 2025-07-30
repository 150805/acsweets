<?php
session_start();
require_once 'db_connect.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $age = $_POST['age'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $accountType = $_POST['accountType'] ?? '';

    // Validate inputs
    if (empty($name) || empty($email) || empty($phone) || empty($age) || empty($password) || empty($confirmPassword) || $accountType === '--Select Account--') {
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
    } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W]/', $password)) {
        $error = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = 'Email already exists';
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, age, password, account_type) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $phone, $age, $hashedPassword, $accountType])) {
                $success = "Welcome $name, you are now registered as an AC Baker!";
                // Clear form
                $_POST = array();
            } else {
                $error = 'Registration failed. Please try again.';
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
  <title>AC School - Sign Up</title>
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
          <?php if(isset($_SESSION['user_id'])): ?>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
          <?php else: ?>
            <li><a href="login.php">Login</a></li>
          <?php endif; ?>
        </ul>
      </nav>
      <h2>Become an AC Baker</h2>
    </div>
  </header>

  <div class="form">
    <?php if ($error): ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
      <div class="success-message"><?php echo $success; ?></div>
    <?php else: ?>
      <form id="contactForm" action="signup.php" method="post">
        <label for="name">Full Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        
        <label for="phone">Phone Number:</label><br>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        
        <label for="age">Age:</label><br>
        <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($_POST['age'] ?? ''); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        
        <label for="confirmPassword">Confirm Password:</label><br>
        <input type="password" id="confirmPassword" name="confirmPassword" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        
        <label for="accountType">Apply for:</label><br>
        <select id="accountType" name="accountType" style="width: 100%; padding: 8px; box-sizing: border-box;">
          <option value="--Select Account--" <?php echo ($_POST['accountType'] ?? '') === '--Select Account--' ? 'selected' : ''; ?>>--Select Account--</option>
          <option value="April" <?php echo ($_POST['accountType'] ?? '') === 'April' ? 'selected' : ''; ?>>April</option>
          <option value="August" <?php echo ($_POST['accountType'] ?? '') === 'August' ? 'selected' : ''; ?>>August</option>
          <option value="November" <?php echo ($_POST['accountType'] ?? '') === 'November' ? 'selected' : ''; ?>>November</option>
        </select><br><br>
        
        <button type="submit" style="width: 100%; padding: 10px;">Sign Up</button>
      </form>
    <?php endif; ?>
  </div>

  <div class="sweet">
    Already Have an account? <a href="login.php">Log in</a>
  </div>

  <footer>
    <ul class="rights">
      <p><b>AC sweets, Homemade with love for You!</b>
      <br>&copy; 2025 AC Sweets. All rights reserved</p>
    </ul>
  </footer>
</body>
</html>