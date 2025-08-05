<?php
session_start();
require_once 'db_connect.php'; // assumes $conn is defined

$errorMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $passwordInput = $_POST["password"];

    if ($conn) {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($passwordInput, $user["password"])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: profile.php");
                exit;
            } else {
                $errorMessage = "Incorrect password. Please try again.";
            }
        } else {
            $errorMessage = "No account found with that email.";
        }

        $stmt->close();
    } else {
        $errorMessage = "Database connection error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - AC Sweets</title>
  <link rel="stylesheet" href="homestyles.css">
</head>
<body>
  <header>
    <h1>AC School!</h1>
    <nav>
      <ul class="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="reachus.php">Contact Us</a></li>
        <li><a href="signup.php">Sign Up</a></li>
      </ul>
    </nav>
  </header>

  <section class="form">
    <h2>Login to AC School</h2>
    <form method="post" action="">
      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" required style="width: 550px;"><br>

      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password" required style="width: 550px;"><br><br>

      <button type="submit">Login</button>
    </form>

    <?php if ($errorMessage): ?>
      <div style="color: red;"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
  </section>

  <footer>
    <ul class="rights">
      <p><b>AC sweets, Homemade with love for You!</b><br>&copy; 2025 AC Sweets. All rights reserved</p>
    </ul>
  </footer>
</body>
</html>
