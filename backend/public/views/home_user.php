<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$fullName = htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']);
?>

<?php include __DIR__ . '/header_user.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h1>Liste des trajets disponibles</h1>

    <!-- Inclusion de la modale pour créer / modifier -->
    <?php include __DIR__ . '/trip_modal.php'; ?>

    <table class="table table-bordered mt-3">
        <thead class="table-light">
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
            <?php if (!empty($trajets)): ?>
                <?php foreach ($trajets as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['depart_nom']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($t['date_depart']))) ?></td>
                        <td><?= htmlspecialchars($t['arrivee_nom']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($t['date_arrivee']))) ?></td>
                        <td><?= htmlspecialchars((string)$t['places_disponibles']) ?>/<?= htmlspecialchars((string)$t['places_total']) ?></td>
                        <td>
                            <!-- Bouton Voir -->
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal<?= $t['id'] ?>">Voir</button>

                            <!-- Bouton Modifier (si c'est le trajet de l'utilisateur) -->
                            <?php if ($_SESSION['user']['id'] === $t['user_id']): ?>
                                <button class="btn btn-warning btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#tripModal"
                                    data-trip-id="<?= $t['id'] ?>"
                                    data-depart="<?= $t['depart_id'] ?>"
                                    data-arrivee="<?= $t['arrivee_id'] ?>"
                                    data-date-depart="<?= $t['date_depart'] ?>"
                                    data-date-arrivee="<?= $t['date_arrivee'] ?>"
                                    data-places="<?= $t['places_total'] ?>"
                                >
                                    Modifier
                                </button>

                                <a href="/home?delete_id=<?= $t['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce trajet ?');">Supprimer</a>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <!-- Modale Voir -->
                    <div class="modal fade" id="infoModal<?= $t['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Informations du trajet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Proposé par :</strong> <?= htmlspecialchars($t['prenom'].' '.$t['nom']) ?></p>
                                    <p><strong>Téléphone :</strong> <?= htmlspecialchars($t['telephone']) ?></p>
                                    <p><strong>Email :</strong> <?= htmlspecialchars($t['email']) ?></p>
                                    <p><strong>Places totales :</strong> <?= htmlspecialchars((string)$t['places_total']) ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Aucun trajet disponible.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
