<?php
session_start();

// Redirection si déjà connecté
if(isset($_SESSION['user'])){
    header("Location: /home");
    exit;
}

// Affichage d'un éventuel message d'erreur
$error_message = $_GET['error'] ?? '';
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h1>Connexion</h1>

    <!-- Bouton pour ouvrir la modale -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
        Se connecter
    </button>

    <!-- Modale login -->
    <div class="modal fade" id="loginModal" tabindex="-1">
      <div class="modal-dialog">
        <form method="POST" action="../backend/controllers/LoginController.php" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Connexion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if($error_message): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Se connecter</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            </div>
        </form>
      </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
