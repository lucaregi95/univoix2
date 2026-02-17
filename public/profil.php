<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - Profil</title>
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

<!-- CONTENT -->
<div class="container my-5">
    <div class="card border border-danger border-3 shadow-sm">
        <div class="card-body p-5">

            <!-- TITRE -->
            <h2 class="fw-bold mb-4">Vos informations personnelles</h2>

            <div class="row g-5">

                <!-- COLONNE GAUCHE - INFOS PERSONNELLES -->
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom :</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Prénom :</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">E-mail :</label>
                        <input type="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Age :</label>
                        <input type="number" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pseudo :</label>
                        <input type="text" class="form-control">
                    </div>
                </div>

                <!-- COLONNE CENTRE - POLICE DYSLEXIQUE -->
                <div class="col-md-5">
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-semibold mb-0">Police pour Dyslexique :</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input bg-danger border-danger" type="checkbox" role="switch" checked style="width: 3rem; height: 1.5rem;">
                            </div>
                        </div>

                        <!-- Barre de recherche avec icône -->
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </span>
                            <input type="text" class="form-control" placeholder="">
                            <button class="btn btn-outline-secondary" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Liste déroulante -->
                        <div class="border rounded" style="height: 150px; overflow-y: auto;">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item">TDAH</div>
                                <div class="list-group-item bg-danger text-white">Autisme</div>
                                <div class="list-group-item">Trouble du Spectre Autistique</div>
                                <div class="list-group-item">Maladie chronique (diabète, endométriose...)</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COLONNE DROITE - AVATAR -->
                <div class="col-md-4 text-center">
                    <label class="form-label fw-semibold d-block mb-3">Avatar :</label>
                    <div class="mb-3">
                        <div class="bg-light border border-2 d-flex align-items-center justify-content-center mx-auto" style="width: 200px; height: 200px;">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-person text-muted mb-2" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                </svg>
                                <div class="text-muted">Avatar</div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-dark">Importer une image</button>
                </div>

            </div>

            <!-- SWITCHES EN BAS -->
            <div class="row mt-4">
                <div class="col-md-4 d-flex align-items-center justify-content-start gap-3">
                    <label class="form-label mb-0 fw-semibold">Deutéranopie :</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input bg-danger border-danger" type="checkbox" role="switch" checked style="width: 3rem; height: 1.5rem;">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-start gap-3">
                    <label class="form-label mb-0 fw-semibold">Tritanopie :</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input bg-danger border-danger" type="checkbox" role="switch" checked style="width: 3rem; height: 1.5rem;">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-start gap-3">
                    <label class="form-label mb-0 fw-semibold">Protanopie :</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input bg-danger border-danger" type="checkbox" role="switch" checked style="width: 3rem; height: 1.5rem;">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- BOUTON SAUVEGARDER -->
    <div class="text-center my-4">
        <button class="btn btn-danger btn-lg-border border-dark px-5 py-2">Sauvegarder les changements</button>
    </div>
</div>

<!-- FOOTER -->
<footer class="bg-danger text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <small class="opacity-75">
                    © 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés
                </small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>