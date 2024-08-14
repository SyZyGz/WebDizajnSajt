<?php
session_start();
include 'db.php';

// Provera da li je korisnik prijavljen
$prijavljen = isset($_SESSION['korisnicko_ime']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Webdizajn Studio</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Navigacioni bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Webdizajn Studio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if ($prijavljen): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Zdravo, <?php echo $_SESSION['korisnicko_ime']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Odjavi se</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Prijavi se</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Glavni sadržaj -->
    <div class="container mt-5">
        <h1 class="text-center">Dobrodošli u Webdizajn Studio</h1>
        <p class="text-center">Ovo je vaša početna stranica.</p>

        <!-- Prikaz ponuda -->
        <div class="row">
            <?php
            $sql = "SELECT * FROM ponude ORDER BY datum_kreiranja DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4">';
                    echo '<div class="card mb-4">';
                    echo '<img src="' . $row['slika'] . '" class="card-img-top" alt="' . $row['naziv'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['naziv'] . '</h5>';
                    echo '<p class="card-text">' . $row['opis'] . '</p>';
                    echo '<p class="card-text"><strong>Cena: </strong>' . $row['cena'] . ' RSD</p>';
                    echo '<button class="btn btn-primary" onclick="kupiProizvod(' . $row['id'] . ')">Kupi</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center">Trenutno nema ponuda.</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center text-lg-start mt-5" style="padding-top: 100px;">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Webdizajn Studio</h5>
                    <p>
                        Mi smo tim profesionalaca posvećenih kreiranju najlepših i funkcionalnih web sajtova.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Linkovi</h5>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="#!" class="text-white">Početna</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">O nama</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Usluge</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Kontakt</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Kontakt</h5>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a href="#!" class="text-white">Email: info@webdizajn.com</a>
                        </li>
                        <li>
                            <a href="#!" class="text-white">Telefon: +381 11 123 456</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3 bg-dark">
            &copy; 2023 Webdizajn Studio. Sva prava zadržana.
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function kupiProizvod(proizvodId) {
            if (confirm("Da li ste sigurni da želite da kupite ovaj proizvod?")) {
                window.location.href = "kupi.php?id=" + proizvodId;
            }
        }
    </script>
</body>
</html>