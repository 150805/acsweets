<?php
$servername = "localhost";
$username = "root";  // Default MySQL username for XAMPP
$password = "";      // Default MySQL password for XAMPP
$dbname = "ac_school";  // Replace with your database name

/*try {
    // Create a PDO instance for database connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection failure
    echo "Connection failed: " . $e->getMessage();
    exit;
}*/

$pdo = mysqli_connect($servername, $username, $password, $dbname);
?>
