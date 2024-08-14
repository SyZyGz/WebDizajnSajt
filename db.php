<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdizajn_studio";

// Kreiranje konekcije
$conn = new mysqli($servername, $username, $password, $dbname);

// Provera konekcije
if ($conn->connect_error) {
    die("Konekcija nije uspela: " . $conn->connect_error);
}
?>