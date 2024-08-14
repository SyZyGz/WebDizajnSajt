<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = $_POST['ime'];
    $sifra = $_POST['sifra'];

    // Priprema i izvršavanje SQL upita
    $stmt = $conn->prepare("SELECT * FROM admini WHERE ime = ?");
    $stmt->bind_param("s", $ime);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($sifra, $row['sifra'])) {
            // Uspešna prijava, preusmeravanje na admin.php
            header("Location: admin.php");
            exit();
        } else {
            echo "Pogrešna šifra.";
        }
    } else {
        echo "Ime ne postoji.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Prijava</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mt-5 text-center">Admin Prijava</h2>
                <form method="post" action="admin_login.php">
                    <div class="form-group">
                        <label for="ime">Ime:</label>
                        <input type="text" class="form-control" id="ime" name="ime" required>
                    </div>
                    <div class="form-group">
                        <label for="sifra">Šifra:</label>
                        <input type="password" class="form-control" id="sifra" name="sifra" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Prijavi se</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>