<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naziv = $_POST['naziv'];
    $opis = $_POST['opis'];
    $cena = $_POST['cena'];
    $slika = $_FILES['slika']['name'];
    $target_dir = "slike/";
    $target_file = $target_dir . basename($slika);

    // Pomeranje slike u folder
    if (move_uploaded_file($_FILES['slika']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO ponude (naziv, opis, cena, slika) VALUES ('$naziv', '$opis', '$cena', '$target_file')";

        if ($conn->query($sql) === TRUE) {
            echo "Ponuda je uspešno postavljena!";
        } else {
            echo "Greška: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Greška pri postavljanju slike.";
    }
}

$conn->close();
header("Location: admin.php");
exit();
?>