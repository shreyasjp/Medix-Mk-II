<?php
require_once 'Connect.php';
$email = $_POST['email'];

$sql = "SELECT * FROM `medix-users` WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $exists = true;
    $row = $stmt->fetch();
    $id = $row['mx_id'];
} else {
    $exists = false;
}
$response = array('exists' => $exists);
if ($exists) {
    $response['id'] = $id;
}
header('Content-Type: application/json');
echo json_encode($response);
?>