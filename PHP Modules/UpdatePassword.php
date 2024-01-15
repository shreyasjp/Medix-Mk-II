<?php
require_once 'Connect.php';
start_session();

// Assuming that you have a valid session or token-based authentication in place.

// Sanitize and validate the form inputs.
$id = $_SESSION['id'];
$password = $_POST['password'];

// Check if the new password is the same as the old password
$sqlCheckPassword = "SELECT password, salt FROM `medix-users` WHERE mx_id = :medixId";
$stmtCheckPassword = $conn->prepare($sqlCheckPassword);
$stmtCheckPassword->bindParam(':medixId', $id);
$stmtCheckPassword->execute();
$existingPassword = $stmtCheckPassword->fetch(PDO::FETCH_ASSOC); // Use FETCH_ASSOC to get an associative array

if ($existingPassword) {
    if (password_verify($pepper . $password . $existingPassword['salt'], $existingPassword['password'])) {
        // New password is the same as the old password
        echo json_encode(["sameAsBefore" => true]);
        exit;
    }
} else {
    // Handle the case where the user doesn't exist or there's an issue with the database
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Error fetching existing password"]);
    exit;
}

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
    echo json_encode(["sameAsBefore" => false, "success" => true]);
} else {
    echo json_encode(["sameAsBefore" => false, "success" => false]);
}

header('Content-Type: application/json');
?>
