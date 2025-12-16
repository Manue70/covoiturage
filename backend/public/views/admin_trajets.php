<?php
declare(strict_types=1);
include __DIR__ . '/header_admin.php';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container container-main">
    <h1>Liste des trajets</h1>

    <!-- Formulaire Modifier (comme pour agences) -->
    <?php if (!empty($trajetToEdit)): ?>
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            Modifier le trajet #<?= (int)$trajetToEdit['id'] ?>
        </div>
        <div class="card-body">
            <form method="POST" action="/controllers/AdminTrajetsController.php">
                <input type="hidden" name="trajet_id" value="<?= (int)$trajetToEdit['id'] ?>">
                <input type="hidden" name="update_trajet" value="1">

                <div class="mb-3">
                    <label class="form-label">Départ (ID agence)</label>
                    <input type="number" name="depart_id" class="form-control" value="<?= $trajetToEdit['depart_id'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Arrivée (ID agence)</label>
                    <input type="number" name="arrivee_id" class="form-control" value="<?= $trajetToEdit['arrivee_id'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date départ</label>
                    <input type="datetime-local" name="date_depart" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($trajetToEdit['date_depart'])) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date arrivée</label>
                    <input type="datetime-local" name="date_arrivee" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($trajetToEdit['date_arrivee'])) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Places totales</label>
                    <input type="number" name="places_total" class="form-control" value="<?= $trajetToEdit['places_total'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Places disponibles</label>
                    <input type="number" name="places_disponibles" class="form-control" value="<?= $trajetToEdit['places_disponibles'] ?>" required>
                </div>

                <button type="submit" class="btn btn-success">Enregistrer</button>
                <a href="/admin/trajets" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Table des trajets -->
    <table class="table table-bordered mt-3">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Date départ</th>
            <th>Date arrivée</th>
            <th>Places totales</th>
            <th>Places disponibles</th>
            <th>Utilisateur</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($trajets as $t): ?>
            <tr>
                <td><?= (int)$t['id'] ?></td>
                <td><?= htmlspecialchars($t['depart_nom']) ?></td>
                <td><?= htmlspecialchars($t['arrivee_nom']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($t['date_depart'])) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($t['date_arrivee'])) ?></td>
                <td><?= (int)$t['places_total'] ?></td>
                <td><?= (int)$t['places_disponibles'] ?></td>
                <td><?= htmlspecialchars($t['prenom'].' '.$t['user_nom']) ?></td>
                <td class="text-nowrap">
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal<?= $t['id'] ?>">Voir</button>
                    <a href="/admin/trajets?edit_id=<?= $t['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="/controllers/AdminTrajetsController.php?delete_id=<?= $t['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce trajet ?');">Supprimer</a>
                </td>
            </tr>

            <!-- Modale Voir -->
            <div class="modal fade" id="viewModal<?= $t['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Trajet #<?= (int)$t['id'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Départ :</strong> <?= htmlspecialchars($t['depart_nom']) ?></p>
                            <p><strong>Arrivée :</strong> <?= htmlspecialchars($t['arrivee_nom']) ?></p>
                            <p><strong>Date départ :</strong> <?= date('d/m/Y H:i', strtotime($t['date_depart'])) ?></p>
                            <p><strong>Date arrivée :</strong> <?= date('d/m/Y H:i', strtotime($t['date_arrivee'])) ?></p>
                            <p><strong>Places totales :</strong> <?= (int)$t['places_total'] ?></p>
                            <p><strong>Places disponibles :</strong> <?= (int)$t['places_disponibles'] ?></p>
                            <p><strong>Utilisateur :</strong> <?= htmlspecialchars($t['prenom'].' '.$t['user_nom']) ?></p>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include __DIR__ . '/footer.php'; ?>
