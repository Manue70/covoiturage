<?php
declare(strict_types=1);

include __DIR__ . '/header_admin.php';
?>
<!-- Inclure Bootstrap CSS si ce n'est pas déjà fait dans header_admin.php -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container container-main">
    <h1>Liste des agences</h1>

    <!-- Formulaire Modifier -->
    <?php if ($agenceToEdit): ?>
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                Modifier l'agence #<?= $agenceToEdit['id'] ?>
            </div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="id" value="<?= $agenceToEdit['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control"
                               value="<?= htmlspecialchars($agenceToEdit['nom'] ?? '') ?>" required>
                    </div>

                    <button type="submit" name="update_agence" class="btn btn-success">
                        Enregistrer
                    </button>
                    <a href="/admin/agences" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <table class="table table-bordered mt-3">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Adresse</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        <?php if (!empty($agences)): ?>
            <?php foreach ($agences as $a): ?>
                <tr>
                    <td><?= (int)$a['id'] ?></td>
                    <td><?= htmlspecialchars($a['nom'] ?? '') ?></td>
                    <td><?= htmlspecialchars($a['adresse'] ?? '-') ?></td>
                    <td class="text-nowrap">
                        <button class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#viewModalAgence<?= $a['id'] ?>">
                            Voir
                        </button>

                        <a href="/admin/agences?edit_id=<?= $a['id'] ?>"
                           class="btn btn-warning btn-sm">
                            Modifier
                        </a>

                        <a href="/admin/agences?delete_id=<?= $a['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Supprimer cette agence ?');">
                            Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Aucune agence trouvée</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modales Voir -->
<?php foreach ($agences as $a): ?>
<div class="modal fade" id="viewModalAgence<?= $a['id'] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= htmlspecialchars($a['nom'] ?? '') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Adresse :</strong> <?= htmlspecialchars($a['adresse'] ?? '-') ?></p>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php include __DIR__ . '/footer.php'; ?>

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
