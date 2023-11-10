<?php
require_once 'Connect.php';
start_session();

$mx_id = $_POST['id'];
$role = $_POST['role'];
$city = $_POST['city'];
$org = $_POST['organization'];

if (isset($_FILES["Image"])) {
    $file = $_FILES["Image"];

    // Generate a unique filename
    $uniqueFilename = uniqid() . "_" . $file["name"];

    // Move the uploaded file to a desired directory
    $uploadDir = "../MedProID/"; // Change this to your desired upload directory
    $targetFile = $uploadDir . $uniqueFilename;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        // File uploaded successfully
        $document_status = 1;

        // Insert data into your database (customize this query as per your table structure)
        $sql = "INSERT INTO `medix-medical-personnel` (mx_id, role, city, organization, comments, `document-location`, document_status) VALUES (:mx_id, :role, :city, :organization, :document_location, :document_status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':mx_id', $mx_id);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':organization', $org);
        $stmt->bindParam(':document_location', $targetFile);
        $stmt->bindParam(':document_status', $document_status);

        if ($stmt->execute()) {
            echo "File uploaded and data saved successfully!";
        } else {
            echo "There seems to be an error. Please try again later.";
        }
    } else {
        echo "There seems to be an error. Please try again later.";
    }
} else {
    echo "There seems to be an issue with the file.";
}
?>
