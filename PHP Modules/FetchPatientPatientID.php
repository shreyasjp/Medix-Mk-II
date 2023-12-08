<?php
require_once 'Connect.php';
start_session();

$response = array();
$patient_name = false;
$patient_gender = false;
$patient_age = false;

$pid = intval(substr($_POST['id'], 3));

$sql = "SELECT * FROM `medix-users` WHERE mx_id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $pid);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch();
    $exists = true;
    $patient_name = $user['name'];

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