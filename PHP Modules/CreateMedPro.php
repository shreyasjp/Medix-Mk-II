<?php
require_once 'Connect.php';
start_session();

$mx_id = $_SESSION['id'];
$role = $_POST['role'];
$org = $_POST['organization'];
$city = isset($_POST['city'])?$_POST['city']:0;
$phone = isset($_POST['phone'])?$_POST['phone']:0;

if (isset($_FILES["file"])) {
    $file = $_FILES["file"];

    // Generate a unique filename
    $uniqueFilename = uniqid() . "_" . $file["name"];

    // Move the uploaded file to a desired directory
    $uploadDir = "../MedProID/"; // Change this to your desired upload directory
    $targetFile = $uploadDir . $uniqueFilename;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        // File uploaded successfully
        $document_status = 1;

        // Insert data into your database (customize this query as per your table structure)
        $sql = "INSERT INTO `medix-medical-personnel` (mx_id, role, city, organization, phone, `document-location`, document_status, verification_status) VALUES (:mx_id, :role, :city, :organization, :phone, :document_location, :document_status, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':mx_id', $mx_id);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':organization', $org);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':document_location', $targetFile);
        $stmt->bindParam(':document_status', $document_status);

        if ($stmt->execute()) {
            http_response_code(200); // Success
            echo "File uploaded and data saved successfully!";
        } else {
            http_response_code(500); // Internal Server Error
            echo "There seems to be an error. Please try again later.";
        }
    } else {
        http_response_code(500); // Internal Server Error
        echo "There seems to be an error. Please try again later.";
    }
} else {
    http_response_code(400); // Bad Request
    echo "There seems to be an issue with the file.";
}
?>