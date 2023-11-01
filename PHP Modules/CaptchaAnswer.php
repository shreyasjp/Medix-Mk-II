<?php
session_start();

// Check if the captcha answer is provided
if (isset($_POST['captcha_answer'])) {
  $userAnswer = $_POST['captcha_answer'];
  $expectedResult = $_SESSION['captcha_expected_result'];

  // Compare the user's answer with the expected result
  $success = ($userAnswer == $expectedResult);

  // Return the validation result as a JSON response
  header('Content-Type: application/json');
  echo json_encode(array('success' => $success));
} else {
  // Invalid request, captcha answer not provided
  header('HTTP/1.1 400 Bad Request');
  exit();
}
?>