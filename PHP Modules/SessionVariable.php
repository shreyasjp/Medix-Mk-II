<?php
// Start or resume the session
session_start();

// Get the session variable key
$key = $_GET['VariableName'];

// Check if the session variable exists
if (isset($_SESSION[$key])) {
    $sessionVariable = $_SESSION[$key];
    echo json_encode($sessionVariable); // Output the session variable as JSON
} else {
    echo json_encode(['error' => 'Session variable not found']);
}
?>
