<?php
session_start();
require_once 'Connect.php';

// Initialize the response array
$response = array();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the Medix ID and password from the POST data
    $medixId = $_POST['medixid'];
    $password = $_POST['password'];

    // Fetch the user from the database
    $sql = "SELECT * FROM `medix-users` WHERE email = :medixId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':medixId', $medixId);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {

        $hashedPassword = $user['password'];
        $salt = $user['salt'];
        $mx_id = $user['mx_id'];

        $pepperedPassword = $pepper . $password . $salt;

        if (password_verify($pepperedPassword, $hashedPassword)) {
            $response['success'] = true;
            $response['message'] = "Login successful";
        } else {
            $_SESSION['failCount']++;
            $response['success'] = false;
            $response['message'] = "Incorrect password";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "User not found";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method";
}
$response['failCount'] = $_SESSION['failCount'];

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);