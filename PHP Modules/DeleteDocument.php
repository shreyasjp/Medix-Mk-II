<?php
require_once 'Connect.php';
start_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the Medix ID and password from the POST data
    $path = $_POST['filePath'];
    $doc_id = $_POST['docID'];

    // Prepare and execute the database deletion
    $sql = "DELETE FROM `medix-docs` WHERE doc_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $doc_id);

    $response = array();

    if ($stmt->execute()) {
        // If the database deletion was successful, attempt to delete the file
        if (unlink($path)) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }
    } else {
        $response['success'] = false;
    }
} else {
    $response['success'] = false;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
