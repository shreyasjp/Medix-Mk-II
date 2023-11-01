<?php
require_once 'Connect.php';
$response = array();
$doc_id = false;
$email = $_POST['email'];

$sql = "SELECT * FROM `medix-users` WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch();

    $sql = "SELECT * FROM `medix-medical-personnel` WHERE mx_id = :id AND verification_status = 'Approved' AND role = 'Medical Doctor'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $user['mx_id']);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
            $exists = true;
            $doc_id = $user['mx_id'];
    } else {
        $exists = false;
    }
} else {
    $exists = false;
}
$response['exists'] = $exists;
$response['doc_id'] = $doc_id;
header('Content-Type: application/json');
echo json_encode($response);
?>