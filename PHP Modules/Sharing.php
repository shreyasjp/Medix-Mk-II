<?php
require_once 'Connect.php'; // Include your database connection code here
start_session();
$response = array();
$mx_id = $_SESSION['id'];
$doc_mx_id = $_POST["medixid"];
if (isset($_POST["message"])) { 
    $message = $_POST["message"];
} else {
    $documentDescription = "NA";
}

$sql = "SELECT * FROM `medix-sharing` WHERE mx_id = :id AND doc_mx_id = :doc_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $mx_id);
    $stmt->bindParam(':doc_id', $doc_mx_id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $success=false;
        $reason=1;
    } else {

        // Insert data into your database
        $sql = "INSERT INTO `medix-sharing` (mx_id, doc_mx_id, message) VALUES (:mx_id, :doc_id, :message)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':mx_id', $mx_id);
        $stmt->bindParam(':doc_id', $doc_mx_id);
        $stmt->bindParam(':message', $message);
        
        if ($stmt->execute()) {
            $success=true;
        } else {
            $success=false;
            $reason=0;
        }
    }
        $response = array('success' => $success);
        if(!$success){
            $response['reason'] = $reason;
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        ?>
