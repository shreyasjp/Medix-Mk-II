<?php
require_once 'Connect.php';
start_session();

$response = array();
$patient_name = false;
$patient_gender = false;
$patient_age = false;

$email = $_POST['email'];

$sql = "SELECT * FROM `medix-users` WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch();
    $exists = true;
    $patient_name = $user['name'];
    $pid = $user['mx_id'];

    $sql = "SELECT * FROM `medix-user-profile` WHERE mx_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $pid);
    $stmt->execute();

    $user = $stmt->fetch();
    $patient_gender = $user['gender'];
    $patient_age = $user['age'];

    if($user['mx_id'] == $_SESSION['id']){
        $sameUserError = true;
    }
    else{
        $sameUserError = false;
    }

} else {
    $exists = false;
}

$response['exists'] = $exists;
$response['name'] = $patient_name;
$response['gender'] = $patient_gender;
$response['age'] = $patient_age;
$response['id'] = $pid;
if($exists){
    $response['sameUserError'] = $sameUserError;
}
header('Content-Type: application/json');
echo json_encode($response);
?>