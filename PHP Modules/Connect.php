<?php

$servername = "localhost";
$username = "root";
$password = "root";
$database = "medix-db";
$pepper = "ATHALAPITHALATHAVALACHICHUKKUMARIKKANACHOOLAPPIMARIAMVANNVILAKOOTHIPHUPHUPHUHUPHUPHUPHU";

// Set the SSL mode to require and verify CA certificate.
//$ssl_mode = "verify-full";
//$ssl_ca_cert_file = "Certificates/server-ca.pem";
//$ssl_key_file = "Certificates/client-key.pem";
//$ssl_cert_file = "Certificates/client-cert.pem";

try {
    $conn = new PDO("mysql:dbname=$database;host=$servername;", $username, $password);
} catch (PDOException $e) {
    // Redirect to the maintenance page.
    header("Location: ../Maintenance-page/Maintenancepage.html");
    exit;
}

function start_session(){
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
}

?>