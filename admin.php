<?php
include 'db.php';

// Provera da li je admin prijavljen
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Admin Panel"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Morate uneti validne kredencijale da biste pristupili ovoj stranici.';
    exit;
} else {
    $ime = $_SERVER['PHP_AUTH_USER'];
    $sifra = $_SERVER['PHP_AUTH_PW'];

    $stmt = $conn->prepare("SELECT * FROM admini WHERE ime = ?");
    $stmt->bind_param("s", $ime);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (!password_verify($sifra, $row['sifra'])) {
            header('HTTP/1.0 401 Unauthorized');
            echo 'Pogrešna šifra.';
            exit;
        }
    } else {
        header('HTTP/1.0 401 Unauthorized');
        echo 'Ime ne postoji.';
        exit;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigacioni bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Zdravo, <?php echo htmlspecialchars($ime); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Odjavi se</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Glavni sadržaj -->
    <div class="container mt-5">
        <h1 class="text-center">Dobrodošli u Admin Panel</h1>
        <p class="text-center">Ovde možete postavljati ponude.</p>
        <!-- Forma za postavljanje ponuda -->
        <form method="post" action="postavi_ponudu.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="naziv">Naziv:</label>
                <input type="text" class="form-control" id="naziv" name="naziv" required>
            </div>
            <div class="form-group">
                <label for="opis">Opis:</label>
                <textarea class="form-control" id="opis" name="opis" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="cena">Cena:</label>
                <input type="number" step="0.01" class="form-control" id="cena" name="cena" required>
            </div>
            <div class="form-group">
                <label for="slika">Slika:</label>
                <input type="file" class="form-control-file" id="slika" name="slika" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Postavi ponudu</button>
        </form>

        <!-- Tabela kupovine -->
        <h2 class="mt-5">Tabela kupovine</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Korisničko ime</th>
                    <th>Proizvod ID</th>
                    <th>Naziv</th>
                    <th>Cena</th>
                    <th>Datum kupovine</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';
                $stmt = $conn->prepare("SELECT korisnicko_ime, proizvod_id, naziv, cena, datum_kupovine FROM kupovine");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['korisnicko_ime']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['proizvod_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['naziv']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['cena']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['datum_kupovine']) . "</td>";
                    echo "</tr>";
                }
                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>