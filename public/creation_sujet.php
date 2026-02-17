<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - Création d'un sujet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="font-family:'Candara'" class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <img alt="UniVoix Logo" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;">
        <a class="nav-link" href="#">Spécialistes</a>
        <a class="nav-link" href="#">Forum</a>
        <a class="nav-link" href="#">Aides</a>
        <a class="nav-link" href="presentation.php">Handicapes</a>
        <a class="navbar-brand fw-bold" href="profil.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
            John Doe
        </a>
    </div>
</nav>

<!-- CONTENT -->
<div class="container my-5">
    <div class="card border border-danger border-3 shadow-sm">
        <div class="card-body p-5">

            <!-- TITRE -->
            <h2 class="fw-bold mb-4 text-center">Créer un nouveau sujet</h2>

            <div class="row g-4">

                <!-- COLONNE GAUCHE -->
                <div class="col-md-6">

                    <!-- Titre du sujet -->
                    <div class="d-flex align-items-center mb-4 gap-3">
                        <label class="form-label fw-semibold mb-0 text-nowrap">Titre du sujet :</label>
                        <input type="text" class="form-control">
                    </div>

                    <!-- Description du post -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contenu du poste :</label>
                        <textarea class="form-control" rows="6"></textarea>
                    </div>

                </div>

                <!-- COLONNE DROITE - CATEGORIES -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold d-block text-center mb-3">Catégories du post</label>

                    <!-- Barre de recherche -->
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </span>
                        <input type="text" class="form-control" placeholder="">
                    </div>

                    <!-- Liste des catégories -->
                    <div class="border rounded" style="height: 180px; overflow-y: auto;">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">Handicaps</div>
                            <div class="list-group-item bg-danger text-white">Isolement</div>
                            <div class="list-group-item">Ecole</div>
                            <div class="list-group-item">Aide</div>
                            <div class="list-group-item">Jeux</div>
                            <div class="list-group-item">Docs</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- BOUTON CRÉER -->
    <div class="text-center my-4">
        <button class="btn btn-danger btn-lg border border-dark px-5 py-2">Créer le post </button>
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