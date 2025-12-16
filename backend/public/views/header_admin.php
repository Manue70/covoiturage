<?php
declare(strict_types=1);

/**
 * Header pour l'administrateur
 
 * @var array $_SESSION['user']
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$adminName = htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']);
?>
<link rel="stylesheet" href="/assets/css/style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/style.css">


<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid px-4">
        <!-- Logo -->
        <a class="navbar-brand" href="/home">Touche pas au klaxon</a>

        <!-- Bouton mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAdmin">
            <!-- Zone gauche : boutons admin -->
            <ul class="navbar-nav me-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="btn btn-info" href="/admin/users">Utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-warning" href="/admin/agences">Agences</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-success" href="/admin/trajets">Trajets</a>
                </li>
            </ul>

            <!-- Zone droite -->
            <div class="d-flex align-items-center gap-2 ms-auto">
                <span class="text-light">Bonjour <?= $adminName ?></span>
                <a class="btn btn-danger" href="/logout">Déconnexion</a>
            </div>
        </div>
    </div>
</nav>
