<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - Profil</title>
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
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <a class="navbar-brand fw-bold text-danger" href="profil.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg> John Doe
        </a>
    </div>
</nav>

<!-- CONTENT -->
<div class="container my-5">
    <div class="card border border-danger border-3 shadow-sm">
        <div class="card-body p-5">

            <h2 class="fw-bold mb-4">Vos informations personnelles</h2>

            <div class="row g-5">

                <!-- COLONNE GAUCHE -->
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

                <!-- COLONNE CENTRE -->
                <div class="col-md-5">
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-semibold mb-0">Police pour Dyslexique :</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input custom-switch" type="checkbox" role="switch" checked>
                            </div>
                        </div>
                        <h3>Handicaps :</h3>
                        <!-- TAG INPUT ROW -->
                        <div class="d-flex gap-2 align-items-start mb-1">
                            <div class="tag-input-box flex-grow-1" id="tagBox" onclick="document.getElementById('tagSearch').focus()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#aaa" class="bi bi-search flex-shrink-0" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                                <input type="text" id="tagSearch" placeholder="Rechercher un trouble...">
                            </div>
                            <button class="btn-help" title="Sélectionnez un ou plusieurs troubles dans la liste" onclick="alert('Cliquez sur un trouble dans la liste pour l\'ajouter. Cliquez à nouveau pour le retirer.')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
                                </svg>
                            </button>
                        </div>

                        <!-- DROPDOWN LIST -->
                        <div class="tag-dropdown" id="tagDropdown">
                            <div class="tag-empty" id="tagEmpty">Aucun résultat</div>
                        </div>
                    </div>
                </div>

                <!-- COLONNE DROITE - AVATAR -->
                <div class="col-md-4 text-center">
                    <label class="form-label fw-semibold d-block mb-3">Avatar :</label>
                    <div class="mb-3">
                        <div class="bg-light border border-2 d-flex align-items-center justify-content-center mx-auto" style="width:200px;height:200px;">
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
                        <input class="form-check-input custom-switch" type="checkbox" role="switch" checked>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-start gap-3">
                    <label class="form-label mb-0 fw-semibold">Tritanopie :</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input custom-switch" type="checkbox" role="switch" checked>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-start gap-3">
                    <label class="form-label mb-0 fw-semibold">Protanopie :</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input custom-switch" type="checkbox" role="switch" checked>
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
                <small class="opacity-75">© 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés</small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const options = [
        "TDAH",
        "Autisme",
        "Trouble du Spectre Autistique",
        "Maladie chronique (diabète, endométriose...)",
        "Dyslexie",
        "Dyscalculie",
        "Dyspraxie",
        "Troubles anxieux",
        "Dépression",
        "Haut Potentiel Intellectuel (HPI)",

    ];

    const selected = new Set();
    const tagSearch   = document.getElementById('tagSearch');
    const tagBox      = document.getElementById('tagBox');
    const tagDropdown = document.getElementById('tagDropdown');
    const tagEmpty    = document.getElementById('tagEmpty');

    // Build list
    options.forEach(opt => {
        const div = document.createElement('div');
        div.className = 'tag-option';
        div.dataset.value = opt;
        div.innerHTML = `<span>${opt}</span><div class="tag-check"></div>`;
        div.addEventListener('click', () => toggle(opt, div));
        tagDropdown.insertBefore(div, tagEmpty);
    });

    function toggle(value, el) {
        if (selected.has(value)) {
            selected.delete(value);
            el.classList.remove('selected');
            tagBox.querySelector(`.tag[data-value="${CSS.escape(value)}"]`)?.remove();
        } else {
            selected.add(value);
            el.classList.add('selected');
            addTag(value);
        }
        tagSearch.focus();
    }

    function addTag(value) {
        const tag = document.createElement('span');
        tag.className = 'tag';
        tag.dataset.value = value;
        tag.innerHTML = `${value}<button class="tag-remove" title="Retirer">×</button>`;
        tag.querySelector('.tag-remove').addEventListener('click', e => {
            e.stopPropagation();
            selected.delete(value);
            tag.remove();
            tagDropdown.querySelector(`.tag-option[data-value="${CSS.escape(value)}"]`)?.classList.remove('selected');
        });
        tagBox.insertBefore(tag, tagSearch);
    }

    tagSearch.addEventListener('input', () => {
        const q = tagSearch.value.toLowerCase().trim();
        let visible = 0;
        tagDropdown.querySelectorAll('.tag-option').forEach(item => {
            const match = item.dataset.value.toLowerCase().includes(q);
            item.classList.toggle('hidden', !match);
            if (match) visible++;
        });
        tagEmpty.style.display = visible === 0 ? 'block' : 'none';
    });

    tagSearch.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && tagSearch.value === '' && selected.size > 0) {
            const last = [...selected].pop();
            selected.delete(last);
            tagBox.querySelector(`.tag[data-value="${CSS.escape(last)}"]`)?.remove();
            tagDropdown.querySelector(`.tag-option[data-value="${CSS.escape(last)}"]`)?.classList.remove('selected');
        }
    });
</script>

</body>
</html>