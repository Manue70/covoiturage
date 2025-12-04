<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Touche pas au klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css">
</head>
<body>

<!-- HEADER -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Touche pas au klaxon</a>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="btn btn-light" href="login.php">Connexion</a>
                    </li>
                <?php elseif ($_SESSION['user']['role'] == 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Tableau de bord</a></li>
                    <li class="nav-item"><a class="btn btn-light" href="logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-light me-2" href="create_trajet.php">Proposer un trajet</a></li>
                    <li class="nav-item"><span class="navbar-text me-2">
                        <?= $_SESSION['user']['prenom'].' '.$_SESSION['user']['nom'] ?>
                    </span></li>
                    <li class="nav-item"><a class="btn btn-light" href="logout.php">Déconnexion</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENU PRINCIPAL -->
<div class="container">
    <h1 class="mb-4">Trajets disponibles</h1>
    
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Départ</th>
                <th>Date départ</th>
                <th>Arrivée</th>
                <th>Date arrivée</th>
                <th>Places disponibles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Exemple de trajets fictifs
            $trajets = [
                ['depart'=>'Paris','date_depart'=>'2025-12-05 08:00','arrivee'=>'Lyon','date_arrivee'=>'2025-12-05 12:00','places'=>3,'user'=>['prenom'=>'Alexandre','nom'=>'Martin','tel'=>'0612345678','email'=>'alexandre.martin@email.fr']],
                ['depart'=>'Marseille','date_depart'=>'2025-12-06 09:00','arrivee'=>'Nice','date_arrivee'=>'2025-12-06 11:00','places'=>2,'user'=>['prenom'=>'Sophie','nom'=>'Dubois','tel'=>'0698765432','email'=>'sophie.dubois@email.fr']],
            ];

            foreach ($trajets as $trajet):
            ?>
            <tr>
                <td><?= $trajet['depart'] ?></td>
                <td><?= $trajet['date_depart'] ?></td>
                <td><?= $trajet['arrivee'] ?></td>
                <td><?= $trajet['date_arrivee'] ?></td>
                <td><?= $trajet['places'] ?></td>
                <td>
                    <?php if(isset($_SESSION['user'])): ?>
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#trajetModal<?= $trajet['depart'] ?>">Infos</button>
                        <?php if($_SESSION['user']['prenom']==$trajet['user']['prenom']): ?>
                            <a href="edit_trajet.php" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="delete_trajet.php" class="btn btn-sm btn-danger">Supprimer</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>

            <!-- MODALE -->
            <div class="modal fade" id="trajetModal<?= $trajet['depart'] ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Informations du trajet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <p><strong>Contact :</strong> <?= $trajet['user']['prenom'].' '.$trajet['user']['nom'] ?></p>
                    <p><strong>Téléphone :</strong> <?= $trajet['user']['tel'] ?></p>
                    <p><strong>Email :</strong> <?= $trajet['user']['email'] ?></p>
                    <p><strong>Total de places :</strong> <?= $trajet['places'] ?></p>
                  </div>
                </div>
              </div>
            </div>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- FOOTER -->
<footer class="bg-primary text-white text-center py-3 mt-4">
    Touche pas au klaxon © 2025
</footer>

</body>
</html>
