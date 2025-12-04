<?php
include 'templates/header.php';

// Requête pour récupérer tous les trajets avec agences et utilisateurs
$query = "SELECT t.*, a1.nom AS depart, a2.nom AS arrivee, u.prenom, u.nom, u.telephone, u.email
          FROM trajets t
          JOIN agences a1 ON t.depart_id = a1.id
          JOIN agences a2 ON t.arrivee_id = a2.id
          JOIN users u ON t.user_id = u.id
          ORDER BY t.date_depart ASC";

$result = $conn->query($query);
$trajets = $result->fetch_all(MYSQLI_ASSOC);
?>

<h1 class="mb-4">Trajets disponibles</h1>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Date départ</th>
            <th>Date arrivée</th>
            <th>Places disponibles</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($trajets as $t): ?>
            <tr>
                <td><?= htmlspecialchars($t['depart']) ?></td>
                <td><?= htmlspecialchars($t['arrivee']) ?></td>
                <td><?= $t['date_depart'] ?></td>
                <td><?= $t['date_arrivee'] ?></td>
                <td><?= $t['places_disponibles'] ?></td>
                <td>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#trajetModal<?= $t['id'] ?>">Infos</button>
                </td>
            </tr>

            <!-- MODALE -->
            <div class="modal fade" id="trajetModal<?= $t['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Informations du trajet</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Contact :</strong> <?= htmlspecialchars($t['prenom'].' '.$t['nom']) ?></p>
                            <p><strong>Téléphone :</strong> <?= htmlspecialchars($t['telephone']) ?></p>
                            <p><strong>Email :</strong> <?= htmlspecialchars($t['email']) ?></p>
                            <p><strong>Total de places :</strong> <?= $t['places_total'] ?></p>
                            <p><strong>Places disponibles :</strong> <?= $t['places_disponibles'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'templates/footer.php'; ?>
