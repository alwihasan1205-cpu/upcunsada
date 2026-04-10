<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS fotoboot";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully\n";
} else {
  echo "Error creating database: " . $conn->error . "\n";
}

$conn->select_db("fotoboot");

$sql = "CREATE TABLE IF NOT EXISTS tb_photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
  echo "Table tb_photos created successfully\n";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS tb_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
  echo "Table tb_users created successfully\n";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "INSERT INTO tb_users (username, password) VALUES ('admin', md5('admin123')) ON DUPLICATE KEY UPDATE username=username";
if ($conn->query($sql) === TRUE) {
  echo "Admin user created successfully\n";
} else {
  echo "Error creating admin user: " . $conn->error;
}

$conn->close();
?>
