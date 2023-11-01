<?php
require_once 'Connect.php';
start_session();

$id = $_SESSION['id'];
$sql = "DELETE FROM `medix-users` WHERE mx_id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

$sql = "DELETE FROM `medix-user-sessions` WHERE mx_id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

session_destroy();
$response['success'] = true;

header('Content-Type: application/json');
echo json_encode($response);

?>