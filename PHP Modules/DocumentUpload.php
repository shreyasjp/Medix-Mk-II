<?php
require_once 'Connect.php'; // Include your database connection code here
start_session();
$documentName = $_POST["document-name"];
$documentType = $_POST["document-type"];
$fileType = $_POST["file-type"];
if (isset($_POST["document-description"])) { 
    $documentDescription = $_POST["document-description"];
} else {
    $documentDescription = "NA";
}
$uploaded_by = $_SESSION['id'];
$is_verified = 0;

if (isset($_POST["owner"])) { 
    $owner = $_POST['owner'];
    $is_verified = 1;
} else {
    $owner = $_SESSION['id']; // Set the owner to the session id if not provided
}

if (isset($_FILES["file"])) {
    $file = $_FILES["file"];
    
    // Generate a unique filename
    $uniqueFilename = uniqid() . "_" . $file["name"];
    
    // Move the uploaded file to a desired directory
    $uploadDir = "../Uploads/"; // Change this to your desired upload directory
    $targetFile = $uploadDir . $uniqueFilename;
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        // File uploaded successfully
        
        // Get the file extension
        $fileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);
        
        // Insert data into your database
        $sql = "INSERT INTO `medix-docs` (document_name, document_type, `file-type`, description, file_path, file_extension, owner, uploaded_by, is_verified) VALUES (:document_name, :document_type, :file_type, :description, :file_path, :file_extension, :owner, :uploaded_by, :is_verified)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':document_name', $documentName);
        $stmt->bindParam(':document_type', $documentType);
        $stmt->bindParam(':file_type', $fileType);
        $stmt->bindParam(':description', $documentDescription);
        $stmt->bindParam(':file_path', $targetFile);
        $stmt->bindParam(':file_extension', $fileExtension);
        $stmt->bindParam(':owner', $uploaded_by);
        $stmt->bindParam(':uploaded_by', $uploaded_by);
        $stmt->bindParam(':is_verified', $is_verified);
        
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
