<?php
require_once 'Connect.php';
start_session();
session_destroy();

// Sanitize and validate the form inputs.
$username = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$email = $_POST['medixid'];
$password = $_POST['password'];

// Generate a 64-bit salt for password hashing.
$salt = bin2hex(random_bytes(32));

// Create the hashed password using Argon2 algorithm with the pepper, password, and salt combined.
$options = [
    'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
    'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
    'threads' => PASSWORD_ARGON2_DEFAULT_THREADS,
    'sodium' => true, // Enable Argon2i variant with Argon2id compatibility using libsodium
];
$hashedPassword = password_hash($pepper . $password . $salt, PASSWORD_ARGON2ID, $options);

// Insert the data into the database.
$sql = "INSERT INTO `medix-users` (name, email, password, salt) VALUES (:name, :email, :password, :salt)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':name', $username);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $hashedPassword);
$stmt->bindParam(':salt', $salt);
$stmt->execute();

// Fetch the user from the database
$sql = "SELECT mx_id FROM `medix-users` WHERE email = :medixId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':medixId', $email);
$stmt->execute();
$user = $stmt->fetch();
$mx_id = $user['mx_id'];

// Set the session variable.
start_session();
$_SESSION['id'] = $mx_id;

header('Location: ../NewUser.php');
exit();
?>