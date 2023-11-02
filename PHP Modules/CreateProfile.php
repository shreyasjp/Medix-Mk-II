<?php
require_once 'Connect.php';
start_session();
$mx_id = $_SESSION['id'];

// Sanitize and validate the form inputs.
$age = $_POST['age'];
$height = $_POST['height'];
$weight = $_POST['weight'];
$blood_group = $_POST['blood-group'];
$gender = $_POST['gender'];
$true = 1;

if (isset($_FILES["Image"])) {
    $file = $_FILES["Image"];
    
    // Generate a unique filename
    $uniqueFilename = uniqid() . "_" . $file["name"];
    
    // Move the uploaded file to a desired directory
    $uploadDir = "../ProfileImages/"; // Change this to your desired upload directory
    $targetFile = $uploadDir . $uniqueFilename;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {

        $file_path = $targetFile;

        $sql = "INSERT INTO `medix-user-profile` (mx_id, age, height, weight, blood_group, gender, profile_pic_location, completion_status) VALUES (:mx_id, :age, :height, :weight, :blood_group, :gender, :profile_pic, :completion_status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':mx_id', $mx_id);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':height', $height);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':blood_group', $blood_group);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':profile_pic', $file_path);
        $stmt->bindParam(':completion_status', $true);
        if ($stmt->execute()){
            header('Location: ../home.php');
            exit;
        } else{
            header('Location: ../index.php');
            exit;
        }
    }
    else{
        header('Location: ../index.php');
        exit;
    }
}
else{
    // Insert the data into the database.
    $sql = "INSERT INTO `medix-user-profile` (mx_id, age, height, weight, blood_group, gender, completion_status) VALUES (:mx_id, :age, :height, :weight, :blood_group, :gender, :completion_status)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':mx_id', $mx_id);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':height', $height);
    $stmt->bindParam(':weight', $weight);
    $stmt->bindParam(':blood_group', $blood_group);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':completion_status', $true);
    if ($stmt->execute()){
        header('Location: ../home.php');
        exit;
    }
    else{
        header('Location: ../index.php');
        exit;
    }
}

?>