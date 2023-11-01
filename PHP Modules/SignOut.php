<?php
require_once 'Connect.php';

if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
}
else{
    start_session();
    session_destroy();
    header('Location: ../index.php');
    exit();
}
setcookie("remember_token", "", time() - 3600, "/"); // delete cookie
start_session();
session_destroy();
$sql = "DELETE FROM `medix-user-sessions` WHERE token = :token";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':token', $token);
$stmt->execute();
header('Location: ../index.php');
exit();

?>