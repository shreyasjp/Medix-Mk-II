<?php
require_once 'Connect.php'; // Include your database connection code here
start_session(); // Start the session

$response = array();
$mx_id = $_SESSION['id'];
$shared_to_id = $_POST["medixid"];
$doc_id = $_POST["document"];

$sql = "SELECT * FROM `medix-docs-sharing` WHERE doc_id = :doc_id AND shared_with = :shared_to_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':doc_id', $doc_id);
$stmt->bindParam(':shared_to_id', $shared_to_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $success = false;
    $reason = 1;
} else {
    // Insert data into your database
    $sql = "INSERT INTO `medix-docs-sharing` (doc_id, owner, shared_with, view_access, edit_access, download_access) VALUES (:doc_id, :mx_id, :shared_to_id, 1, 0, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':doc_id', $doc_id);
    $stmt->bindParam(':mx_id', $mx_id);
    $stmt->bindParam(':shared_to_id', $shared_to_id);
    
    if ($stmt->execute()) {
        $success = true;
    } else {
        $success = false;
        $reason = 0;
    }
}

$response = array('success' => $success);

if (!$success) {
    $response['reason'] = $reason;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
