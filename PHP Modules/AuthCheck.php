<?php
require_once 'Connect.php';

if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    
    $sql = "SELECT * FROM `medix-user-sessions` WHERE token = :token";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $sessionData = $stmt->fetch();

    if ($sessionData) {
        $expirationTime = strtotime($sessionData['expiry']);
        $currentTime = time();
        if ($expirationTime > $currentTime) {
            session_start();
            $_SESSION['id'] = $sessionData['mx_id'];
            $location = 'Home.php';
        } else {
            // Token has expired; handle this situation (e.g., remove the token from the database, log the user out)
            setcookie("remember_token", "", time() - 3600, "/"); // delete cookie
            session_start();
            session_destroy();
            $sql = "DELETE FROM `medix-user-sessions` WHERE token = :token";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $location = 'LandingPage.html';
        }
    }
    else{
        $location = 'LandingPage.html';
    }
}
else{
    $location = 'LandingPage.html';
}


?>