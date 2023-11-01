<?php
require_once 'Connect.php';

// Get the Medix ID and password from the form
$medixId = $_POST['medixid'];
$password = $_POST['password'];

// Check if the "Remember Me" checkbox is checked
$rememberMe = isset($_POST['remember-me']) ? $_POST['remember-me'] : 0;

// Fetch the user from the database
$sql = "SELECT * FROM `medix-users` WHERE email = :medixId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':medixId', $medixId);
$stmt->execute();
$user = $stmt->fetch();

if ($user) {
    // Verify the password
    $hashedPassword = $user['password'];
    $salt = $user['salt'];
    $mx_id = $user['mx_id'];

    // Combine the secret pepper, password, and salt
    $pepperedPassword = $pepper . $password . $salt;

    // Verify the password using password_verify()
    if (password_verify($pepperedPassword, $hashedPassword)) {
        // The Medix ID and password are valid, set the session variable
        start_session();
        $_SESSION['id'] = $mx_id;

        if ($rememberMe) {
          // Generate a unique "Remember Me" token
          $token = bin2hex(random_bytes(32)); // Generate a secure token

          // Store the token in the user's browser as a cookie
          setcookie('remember_token', $token, time() + 30 * 24 * 60 * 60, '/', '', true, true);

          // Store the token in the database along with the user's ID and expiration time
          $expiration = date('Y-m-d H:i:s', time() + 30 * 24 * 60 * 60);
          $sql = "INSERT INTO `medix-user-sessions` (mx_id, token, expiry) VALUES (:user_id, :token, :expiration)";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':user_id', $mx_id);
          $stmt->bindParam(':token', $token);
          $stmt->bindParam(':expiration', $expiration);
          $stmt->execute();
        }
        header('Location: ../Home.php');
    } else {
        header('Location: ../index.php');
    }
} else {
    header('Location: ../index.php');
}
?>
