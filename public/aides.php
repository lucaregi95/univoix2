<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - Aides</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Candara', sans-serif;
            background-color: #f8f9fa;
        }

        /* ── NAVBAR (identique aux autres pages) ── */
        .navbar {
            border-bottom: 3px solid #dc3545 !important;
        }

        /* ── HERO (style page Handicaps) ── */
        .page-hero {
            text-align: center;
            padding: 3.5rem 1rem 2.5rem;
            background: #fff;
            border-bottom: 2px solid #dc3545;
            margin-bottom: 2.5rem;
        }

        .page-hero p {
            color: #888;
            max-width: 680px;
            margin: 0.6rem auto 0;
            font-size: 0.95rem;
            font-style: italic;
        }

        /* ── AIDE CARDS ── */
        .aide-card {
            background: #dc3545;
            color: #fff;
            border-radius: 12px;
            padding: 2.2rem 2.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 18px rgba(220,53,69,.25);
            transition: transform .2s, box-shadow .2s;
        }
        .aide-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(220,53,69,.35);
        }
        .aide-card h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
            letter-spacing: .01em;
        }
        .aide-card p {
            font-size: 0.93rem;
            line-height: 1.65;
            opacity: .92;
            margin-bottom: 1.4rem;
        }
        .aide-card .btn-aide {
            background: #fff;
            color: #dc3545;
            border: none;
            border-radius: 6px;
            padding: 0.45rem 1.4rem;
            font-family: 'Candara', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background .18s, color .18s;
            text-decoration: none;
            display: inline-block;
        }
        .aide-card .btn-aide:hover {
            background: #1a1a1a;
            color: #fff;
        }

        /* ── FOOTER (identique) ── */
        footer {
            background: #dc3545;
            color: #fff;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="UniVoix" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="#">Forum</a>
        <a class="nav-link active fw-semibold text-danger" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <a class="navbar-brand fw-bold" href="profil.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg> John Doe
        </a>
    </div>
</nav>

<!-- HERO -->
<div class="page-hero">
    <h1>LES AIDES</h1>
    <p>Sur cette page, vous trouverez la liste des aides (financières, aides Handicap, Logement…) disponibles pour les étudiants.</p>
</div>

<!-- CONTENU -->
<div class="container pb-5" style="max-width: 820px;">

    <!-- CROUS -->
    <div class="aide-card">
        <h2>CROUS</h2>
        <p>
            Le CROUS accompagne les étudiants et les étudiantes dans leur vie quotidienne pendant leurs études supérieures. Leur mission est d'améliorer les conditions de vie et d'études : bourses, logement, restauration, accès aux services de la vie campus. Pour étudiants. Leur service s'adresse à tous les étudiants et les étudiantes de l'académie.
        </p>
        <a href="#" class="btn-aide">Accéder au site du CROUS</a>
    </div>

    <!-- Aide au logement -->
    <div class="aide-card">
        <h2>Aide au Logement (APL)</h2>
        <p>
            Les aides personnalisées au logement (APL) sont des allocations versées par la CAF ou la MSA pour réduire le montant de votre loyer. Elles sont accessibles aux étudiants locataires sous conditions de ressources, que vous soyez en résidence universitaire ou en logement privé.
        </p>
        <a href="#" class="btn-aide">Accéder au site de la CAF</a>
    </div>

    <!-- Aide Handicap -->
    <div class="aide-card">
        <h2>Aide Handicap – MDPH</h2>
        <p>
            La MDPH (Maison Départementale des Personnes Handicapées) propose un accompagnement personnalisé et des aménagements pour les étudiants en situation de handicap : tiers-temps, aides humaines, matérielles ou financières. Renseignez-vous auprès de votre établissement pour activer vos droits.
        </p>
        <a href="#" class="btn-aide">Accéder au site de la MDPH</a>
    </div>

    <!-- Bourse sur critères sociaux -->
    <div class="aide-card">
        <h2>Bourses sur Critères Sociaux</h2>
        <p>
            Les bourses sur critères sociaux sont attribuées par le CROUS selon vos ressources familiales et votre situation. Elles permettent de couvrir tout ou partie des frais de scolarité et de vie. La demande se fait chaque année via le Dossier Social Étudiant (DSE) sur messervices.etudiant.gouv.fr.
        </p>
        <a href="#" class="btn-aide">Faire ma demande de bourse</a>
    </div>

    <!-- Aide d'urgence -->
    <div class="aide-card">
        <h2>Aide d'Urgence</h2>
        <p>
            En cas de difficultés financières ponctuelles (perte d'emploi, accident, rupture familiale), le CROUS peut débloquer une aide d'urgence en quelques jours. Cette aide non remboursable est accessible à tout étudiant inscrit dans un établissement d'enseignement supérieur.
        </p>
        <a href="#" class="btn-aide">Contacter le service social du CROUS</a>
    </div>

</div>

<!-- FOOTER -->
<footer class="py-4 mt-3">
    <div class="container text-center">
        <small class="opacity-75">© 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>