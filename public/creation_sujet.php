<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - Création d'un sujet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-check-input.custom-switch {
            width: 3rem;
            height: 1.5rem;
            background-color: #d3d3d3 !important;
            border-color: #d3d3d3 !important;
        }
        .form-check-input.custom-switch:checked {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }

        /* ── Tag multi-select ── */
        .tag-input-box {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 5px 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            align-items: center;
            cursor: text;
            background: #fff;
            min-height: 38px;
            transition: border-color .2s, box-shadow .2s;
        }
        .tag-input-box:focus-within {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220,53,69,.15);
        }
        .tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #dc3545;
            color: #fff;
            border-radius: 5px;
            padding: 2px 8px;
            font-size: 0.78rem;
            font-weight: 500;
            animation: tagIn .15s ease;
            white-space: nowrap;
        }
        @keyframes tagIn {
            from { opacity:0; transform:scale(.85); }
            to   { opacity:1; transform:scale(1); }
        }
        .tag-remove {
            cursor: pointer;
            font-size: 1rem;
            line-height: 1;
            border: none;
            background: none;
            color: #fff;
            padding: 0;
            opacity: .8;
        }
        .tag-remove:hover { opacity: 1; }

        .tag-input-box input {
            border: none;
            outline: none;
            font-size: 0.875rem;
            flex: 1;
            min-width: 60px;
            background: transparent;
            color: #333;
        }

        .tag-dropdown {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            margin-top: 4px;
            overflow: hidden;
            max-height: 160px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
        }
        .tag-dropdown::-webkit-scrollbar { width: 5px; }
        .tag-dropdown::-webkit-scrollbar-thumb { background: #ccc; border-radius: 99px; }

        .tag-option {
            padding: 8px 12px;
            font-size: 0.875rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #444;
            transition: background .12s;
            user-select: none;
        }
        .tag-option:hover { background: #fff5f5; }
        .tag-option.selected { background: #fdf0f0; color: #dc3545; font-weight: 500; }
        .tag-option.hidden { display: none; }

        .tag-check {
            width: 17px;
            height: 17px;
            border-radius: 4px;
            border: 1.5px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all .15s;
        }
        .tag-option.selected .tag-check {
            background: #dc3545;
            border-color: #dc3545;
        }
        .tag-option.selected .tag-check::after {
            content: '';
            width: 4px;
            height: 8px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(45deg) translateY(-1px);
            display: block;
        }
        .tag-empty {
            padding: 10px 12px;
            font-size: .85rem;
            color: #aaa;
            text-align: center;
            display: none;
        }

        /* help button kept from original */
        .btn-help {
            border: 1px solid #dee2e6;
            background: #fff;
            border-radius: 6px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #888;
            flex-shrink: 0;
            cursor: pointer;
            transition: all .2s;
        }
        .btn-help:hover { border-color: #dc3545; color: #dc3545; }
    </style>

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
            </svg> John Doe</a>

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