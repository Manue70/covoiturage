<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userName = htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']);
?>
<link rel="stylesheet" href="/assets/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid px-4">
        <!-- Logo -->
        <a class="navbar-brand" href="/home">Touche pas au klaxon</a>

        <!-- Bouton mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarUser">
            <!-- Zone gauche (vide pour l'instant si nécessaire) -->
            <ul class="navbar-nav me-auto"></ul>

            <!-- Zone droite -->
            <div class="d-flex align-items-center gap-2 ms-auto">
                <!-- Bouton Créer un trajet -->
                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#tripModal">
                    Créer un trajet
                </button>

                <!-- Nom de l'utilisateur -->
                <span class="text-light">Bonjour <?= $userName ?></span>

                <!-- Déconnexion -->
                <a class="btn btn-danger" href="/logout">Déconnexion</a>
            </div>
        </div>
    </div>
</nav>
