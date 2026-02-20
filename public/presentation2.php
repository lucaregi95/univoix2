<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les handicaps invisibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="font-family:'Candara'" class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">

        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="#">Forum</a>
        <a class="nav-link" href="#">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <a class="navbar-brand fw-bold" href="profil.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20" >
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>     John Doe</a>

    </div>
</nav>

<!-- HEADER -->
<header class="bg-white py-5 border-bottom border-danger border-3">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3 text-danger">Les handicaps invisibles</h1>
        <p class="lead text-muted col-lg-8 mx-auto">
            Des troubles souvent méconnus, mais bien réels, qui impactent profondément le quotidien.
        </p>
    </div>
</header>

<!-- CONTENT -->
<div class="container my-5">
    <div class="row g-4">

        <!-- TDAH -->
        <div class="col-12">
            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100 transition hover-shadow">
                <div class="card-body p-4 p-lg-5">
                    <div class="row align-items-center g-4">
                        <div class="col-md-3 col-lg-2">
                            <div class="ratio ratio-1x1 bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <span class="display-3"></span>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-10">
                            <h3 class="fw-bold text-danger mb-3">TDAH</h3>
                            <p class="text-muted mb-3 fs-6">
                                Le trouble du déficit de l'attention avec ou sans hyperactivité affecte la concentration,
                                l'organisation et la gestion des émotions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AUTISME -->
        <div class="col-12">
            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-lg-5">
                    <div class="row align-items-center g-4">
                        <div class="col-md-9 col-lg-10 order-md-1">
                            <h3 class="fw-bold text-danger mb-3">Autisme</h3>
                            <p class="text-muted mb-3 fs-6">
                                Les troubles du spectre de l'autisme regroupent des profils variés,
                                souvent invisibles, impactant la communication et les interactions sociales.
                            </p>
                        </div>
                        <div class="col-md-3 col-lg-2 order-md-2">
                            <div class="ratio ratio-1x1 bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <span class="display-3"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TROUBLES CHRONIQUES -->
        <div class="col-12">
            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-lg-5">
                    <div class="row align-items-center g-4">
                        <div class="col-md-3 col-lg-2">
                            <div class="ratio ratio-1x1 bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <span class="display-3"></span>
                            </div>
                        </div>
                        <div class="col-md-9 col-lg-10">
                            <h3 class="fw-bold text-danger mb-3">Troubles chroniques</h3>
                            <p class="text-muted mb-3 fs-6">
                                Douleurs, fatigue ou maladies longues durées peuvent être invisibles,
                                mais elles nécessitent compréhension et aménagements adaptés.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class=" mt-4">
        <a href="presentation.php" class="btn btn-danger btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
            </svg> Précédent

        </a>
    </div>
</div>

<!-- FOOTER -->
<footer class="bg-danger text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-2 fw-semibold">Univoix - Ensemble pour l'inclusion</p>
                <small class="opacity-75">
                    © 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés </small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>