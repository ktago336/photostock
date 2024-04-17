<?php
$env = json_decode(file_get_contents(__DIR__.'/../.env.json'));

$servername = "localhost";
$username = $env->DB_USERNAME;
$password = $env->DB_PASSWORD;
$dbname = $env->DB_NAME;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE posts (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(30) NOT NULL,
photo VARCHAR(100) NOT NULL,
upload_date VARCHAR(100) NOT NULL,
nickname VARCHAR(30) NOT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)";

if ($conn->query($sql) === TRUE) {
echo "Table posts created successfully\n";
} else {
echo "Error creating table: " . $conn->error;
}


$sql = "CREATE TABLE comments (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
text VARCHAR(255) NOT NULL,
photo_id INT,
nickname VARCHAR(30) NOT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)";

if ($conn->query($sql) === TRUE) {
echo "Table comments created successfully\n";
} else {
echo "Error creating table: " . $conn->error;
}

$conn->close();
?>