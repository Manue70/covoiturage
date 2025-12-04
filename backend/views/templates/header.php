<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Touche pas au klaxon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/public/css/style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/public/index.php">Touche pas au klaxon</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav">
                <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="btn btn-light me-2" href="/public/login.php">Connexion</a>
                    </li>
                <?php elseif ($_SESSION['user']['role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="/public/dashboard.php">Tableau de bord</a></li>
                    <li class="nav-item"><a class="btn btn-light" href="/public/logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-light me-2" href="/public/create_trajet.php">Proposer un trajet</a></li>
                    <li class="nav-item"><span class="navbar-text me-2">
                        <?= htmlspecialchars($_SESSION['user']['prenom'].' '.$_SESSION['user']['nom']) ?>
                    </span></li>
                    <li class="nav-item"><a class="btn btn-light" href="/public/logout.php">Déconnexion</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="main-content container mt-5 pt-3">
