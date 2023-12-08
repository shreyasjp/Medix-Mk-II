<?php
require_once 'Connect.php';
start_session();
$response = array();
$doc_id = false;
$email = $_POST['email'];

$sql = "SELECT * FROM `medix-users` WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch();

    $sql = "SELECT * FROM `medix-medical-personnel` WHERE mx_id = :id AND verification_status = 1 AND role = 'Medical Doctor'";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $user['mx_id']);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
            $exists = true;
            $doc_id = $user['mx_id'];
            if($user['mx_id'] == $_SESSION['id']){
                $sameUserError = true;
            }
            else{
                $sameUserError = false;
            }
        } else {
        $exists = false;
    }
} else {
    $exists = false;
}
$response['exists'] = $exists;
$response['doc_id'] = $doc_id;
if($exists){
    $response['sameUserError'] = $sameUserError;
}
header('Content-Type: application/json');
echo json_encode($response);
?>