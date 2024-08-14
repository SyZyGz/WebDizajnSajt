<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = $_POST['lozinka'];

    $sql = "SELECT * FROM korisnici WHERE korisnicko_ime='$korisnicko_ime'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($lozinka, $row['lozinka'])) {
            // Uspešna prijava, postavljanje sesije i preusmeravanje na index.php
            $_SESSION['korisnicko_ime'] = $korisnicko_ime;
            header("Location: index.php");
            exit();
        } else {
            echo "Pogrešna lozinka.";
        }
    } else {
        echo "Korisničko ime ne postoji.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Prijava</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mt-5 text-center">Prijava</h2>
                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="korisnicko_ime">Korisničko ime:</label>
                        <input type="text" class="form-control" id="korisnicko_ime" name="korisnicko_ime" required>
                    </div>
                    <div class="form-group">
                        <label for="lozinka">Lozinka:</label>
                        <input type="password" class="form-control" id="lozinka" name="lozinka" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Prijavi se</button>
                </form>
                <div class="text-center mt-3">
                    <a href="register.php" class="btn btn-link">Nemate nalog? Registrujte se</a>
                </div>
                <div class="text-center mt-3">
                    <a href="admin_login.php" class="btn btn-link">Admin prijava</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>