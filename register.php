<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = password_hash($_POST['lozinka'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    $sql = "INSERT INTO korisnici (korisnicko_ime, lozinka, email) VALUES ('$korisnicko_ime', '$lozinka', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Uspešno ste se registrovali!";
    } else {
        echo "Greška: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registracija</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mt-5 text-center">Registracija</h2>
                <form method="post" action="register.php">
                    <div class="form-group">
                        <label for="korisnicko_ime">Korisničko ime:</label>
                        <input type="text" class="form-control" id="korisnicko_ime" name="korisnicko_ime" required>
                    </div>
                    <div class="form-group">
                        <label for="lozinka">Lozinka:</label>
                        <input type="password" class="form-control" id="lozinka" name="lozinka" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Registruj se</button>
                </form>
                <div class="text-center mt-3">
                    <a href="login.php" class="btn btn-link">Već imate nalog? Prijavite se</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>