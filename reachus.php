<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AC Sweets - Reach Us</title>
  <link rel="stylesheet" href="homestyles.css">
</head>
<body>

<div class="sweet">
  <h1>AC Sweets!</h1>
  <nav>
    <ul class="navbar">
      <li><a href="index.php">Home</a></li> 
      <li class="dropdown">
        <a href="#">Sweets ▼</a>
        <ul class="dropdown-menu">
          <li><a href="#">Chocolate cakes</a></li>
          <li><a href="#">Fruit cakes</a></li>
          <li><a href="#">Vegetarian/Special</a></li>
          <li><a href="#">Forest/Velvet</a></li>
        </ul>
      </li>
      <li><a href="submitOrder.php">Submit an order</a></li>
      <li><a href="reachus.php">Contact Us</a></li>
      <?php if(isset($_SESSION['user_id'])): ?>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign Up</a></li>
      <?php endif; ?>
    </ul>
  </nav>
  <h2>Home Baked Just for You</h2>
</div>

<div class="form">
  <form id="contactForm" action="#" method="post">
    <label for="name">Full Name:</label><br>
    <input type="text" id="name" name="name" required><br>
    <span id="nameError" class="error-message"></span><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    <span id="emailError" class="error-message"></span><br>

    <label for="phone">Phone Number:</label><br>
    <input type="text" id="phone" name="phone" required><br>
    <span id="phoneError" class="error-message"></span><br>

    <label for="message">Message:</label><br>
    <textarea id="message" name="message" rows="5" required></textarea><br>
    <span id="messageError" class="error-message"></span><br>

    <input type="submit" value="Send Message">
  </form>
  <div id="errorMessage" style="color: red; display: none;">Please fix the errors in the form.</div>
  <div id="successMessage" style="color: green; display: none;">Form submitted successfully!</div>
</div>

<div class="sweet">
  <h3>Our Contact Details</h3>
  <p>Email: info@acsweets.com</p>
  <p>Phone: +2547 74721815</p>
  <p>Address: 123 Gigiri, Nairobi, Kenya</p>
</div>

<footer>
  <nav>
    <ul class="navbar">
      <li><a href="submitOrder.php">Submit an order</a></li>
      <li><a href="sweets.php">Sweets</a></li>
    </ul>
  </nav>
  <p><b>AC Sweets, Homemade with love for You!</b><br>&copy; 2025 AC Sweets. All rights reserved.</p>
</footer>

<script src="reach.js"></script>
</body>
</html>
