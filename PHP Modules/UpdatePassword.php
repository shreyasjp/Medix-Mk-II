<?php
require_once 'Connect.php';

// Assuming that you have a valid session or token-based authentication in place.

// Sanitize and validate the form inputs.
$id = $_SESSION['id'];
$password = $_POST['password'];

// Generate a new salt for password hashing.
$salt = bin2hex(random_bytes(32));

// Create the hashed password using Argon2 algorithm with the pepper, password, and salt combined.
$options = [
    'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
    'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
    'threads' => PASSWORD_ARGON2_DEFAULT_THREADS,
    'sodium' => true, // Enable Argon2i variant with Argon2id compatibility using libsodium
];
$hashedPassword = password_hash($pepper . $password . $salt, PASSWORD_ARGON2ID, $options);

// Update the user's password in the database.
$sql = "UPDATE `medix-users` SET password = :password, salt = :salt WHERE mx_id = :medixId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':password', $hashedPassword);
$stmt->bindParam(':salt', $salt);
$stmt->bindParam(':medixId', $id);

if ($stmt->execute()) {
    http_response_code(200); // Success
} else {
    http_response_code(500); // Internal Server Error
}

header('Content-Type: application/json');
echo json_encode($response);
?>
