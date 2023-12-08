<?php
require_once 'Connect.php';
start_session();
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
    if($id == $_SESSION['id']){
        $response['sameUserError'] = true;
    }
    else{
        $response['sameUserError'] = false;
    }
}
header('Content-Type: application/json');
echo json_encode($response);
?>