<?php
session_start();
include 'db_connect.php';  // Ensure the correct path to db_connect.php

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
        // Check if email already exists in the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = 'Email already exists';
        } else {
            // Hash the password before saving it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user into the users table
            $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, age, password, account_type) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $phone, $age, $hashedPassword, $accountType])) {
                $success = "Welcome $name, you are now registered!";
                // Clear the form data
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
    <head>
    <link rel="stylesheet" href="homestyles.css">
</head>
  <title>AC School!</title>
</head>
<body>
  <header>
    <div class="sweet">
    <h1>AC School!</h1>
    <nav>
       <ul class="navbar">
        <li><a href="home.html">Home</a></li> 
        <li><a href="reachus.html">Contact Us</a></li>
      </ul>
    </nav>
        <h2>Become an AC Baker</h2>
        </div>
    <div class="form">
      <form id="contactForm" action="#" method="post">
        <label for="name">Full Name:</label><br>
        <input type="text" id="name" name="name" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        <span id="nameError" class="error" style="color: red; display: none;"></span><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        <span id="emailError" class="error" style="color: red; display: none;"></span><br>

        <label for="phone">Phone Number:</label><br>
        <input type="tel" id="phone" name="phone" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        <span id="phoneError" class="error" style="color: red; display: none;"></span><br>

        <label for="age">Age:</label><br>
        <input type="number" id="age" name="age" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        <span id="ageError" class="error" style="color: red; display: none;"></span><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        <span id="passwordError" class="error" style="color: red; display: none;"></span><br>

        <label for="confirmPassword">Confirm Password:</label><br>
        <input type="password" id="confirmPassword" name="confirmPassword" required style="width: 100%; padding: 8px; box-sizing: border-box;"><br>
        <span id="confirmPasswordError" class="error" style="color: red; display: none;"></span><br>

        <label>Apply for:</label><br>
        <select id="accountType" style="width: 100%; padding: 8px; box-sizing: border-box;">
          <option>--Select Account--</option>
          <option>April</option>
          <option>August</option>
          <option>November</option>
        </select><br>
        <span id="accountTypeError" class="error" style="color: red; display: none;"></span><br><br>

        <button type="submit" style="width: 100%; padding: 10px;">Sign Up</button>
      </form>
      <div id="errorMessage" style="color: red; display: none;">Please fix the errors in the form.</div>
      <div id="successMessage" style="color: green; display: none;">Form submitted successfully!</div>
    </div>
  </div>
  <div class="sweet">
    Already Have an account?<br><br>
     <footer>
    </div>
    <ul class="rights">
    <nav>
      <ul>
        <li><a href="logg.html">Log in</a></li>
        <li><a href="reachus.html">Contact Us</a></li>
      </ul>
    </nav>
    <p> <b>AC sweets, Homemade with love for You!</b>
    <br>&copy; 2025 AC Sweets. All rights reserved </p>
  </footer>
   <script src="signup.js"></script>
</body>
</html>