<?php
session_start();
include 'db.php';

if (!isset($_SESSION['korisnicko_ime'])) {
    header("Location: login.php");
    exit();
}

$korisnicko_ime = $_SESSION['korisnicko_ime'];
$email = $_SESSION['email']; // Pretpostavljamo da je email sačuvan u sesiji
$proizvod_id = $_GET['id'];

// Preuzimanje informacija o proizvodu
$sql = "SELECT * FROM ponude WHERE id='$proizvod_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $naziv = $row['naziv'];
    $cena = $row['cena'];

    // Upisivanje kupovine u bazu
    $sql = "INSERT INTO kupovine (korisnicko_ime, email, proizvod_id, naziv, cena) VALUES ('$korisnicko_ime', '$email', '$proizvod_id', '$naziv', '$cena')";
    if ($conn->query($sql) === TRUE) {
        echo "Uspešno ste kupili proizvod!";
    } else {
        echo "Greška: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Proizvod ne postoji.";
}

$conn->close();
header("Location: index.php");
exit();
?>