<?php
session_start();
require_once 'db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Email and password are required';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            if ($user['is_admin']) {
                header("Location: admindashboard.php");
            } else {
                header("Location: profile.php");
            }
            exit();
        } else {
            $error = 'Invalid email or password';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AC School - Login</title>
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
          <li><a href="signup.php">Sign Up</a></li>
        </ul>
      </nav>
      <h2>Login to Your Account</h2>
    </div>
  </header>

  <div class="form">
    <?php if ($error): ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form id="loginForm" action="login.php" method="post">
      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
      
      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br><br>
      
      <button type="submit" style="width: 100%; padding: 10px;">Login</button>
    </form>
  </div>

  <div class="sweet">
    Don't have an account? <a href="signup.php">Sign Up</a>
  </div>

  <footer>
    <ul class="rights">
      <p><b>AC sweets, Homemade with love for You!</b>
      <br>&copy; 2025 AC Sweets. All rights reserved</p>
    </ul>
  </footer>
</body>
</html>