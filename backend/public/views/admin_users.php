<?php
declare(strict_types=1);
include __DIR__ . '/header_admin.php';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container container-main">
    <h1>Liste des utilisateurs</h1>

    <!-- Formulaire Modifier (comme pour trajets) -->
    <?php if (!empty($userToEdit)): ?>
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                Modifier l'utilisateur #<?= (int)$userToEdit['id'] ?>
            </div>
            <div class="card-body">
                <form method="POST" action="/controllers/AdminUsersController.php">
                    <input type="hidden" name="user_id" value="<?= (int)$userToEdit['id'] ?>">
                    <input type="hidden" name="update_user" value="1">

                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($userToEdit['nom']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($userToEdit['prenom']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($userToEdit['telephone']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($userToEdit['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rôle</label>
                        <select name="role" class="form-select" required>
                            <option value="user" <?= $userToEdit['role'] === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $userToEdit['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Enregistrer</button>
                    <a href="/admin/users" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- Table des utilisateurs -->
    <table class="table table-bordered mt-3">
        <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= (int)$u['id'] ?></td>
                    <td><?= htmlspecialchars($u['nom']) ?></td>
                    <td><?= htmlspecialchars($u['prenom']) ?></td>
                    <td><?= htmlspecialchars($u['telephone']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['role']) ?></td>
                    <td class="text-nowrap">
                        <!-- Voir -->
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal<?= $u['id'] ?>">Voir</button>
                        <!-- Modifier -->
                        <a href="/admin/users?edit_id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <!-- Supprimer -->
                        <a href="/controllers/AdminUsersController.php?delete_id=<?= $u['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                    </td>
                </tr>

                <!-- Modale Voir -->
                <div class="modal fade" id="viewModal<?= $u['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= htmlspecialchars($u['prenom'].' '.$u['nom']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nom :</strong> <?= htmlspecialchars($u['nom']) ?></p>
                                <p><strong>Prénom :</strong> <?= htmlspecialchars($u['prenom']) ?></p>
                                <p><strong>Téléphone :</strong> <?= htmlspecialchars($u['telephone']) ?></p>
                                <p><strong>Email :</strong> <?= htmlspecialchars($u['email']) ?></p>
                                <p><strong>Rôle :</strong> <?= htmlspecialchars($u['role']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODALE MODIFIER -->
                <div class="modal fade" id="editModal<?= $u['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" action="/controllers/AdminUsersController.php" class="modal-content">
                            <input type="hidden" name="user_id" value="<?= (int)$u['id'] ?>">
                            <input type="hidden" name="update_user" value="1">

                            <div class="modal-header">
                                <h5 class="modal-title">Modifier l'utilisateur #<?= (int)$u['id'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($u['nom']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Prénom</label>
                                    <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($u['prenom']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Téléphone</label>
                                    <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($u['telephone']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($u['email']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Rôle</label>
                                    <select name="role" class="form-select" required>
                                        <option value="user" <?= $u['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                        <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">Aucun utilisateur trouvé</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include __DIR__ . '/footer.php'; ?>
