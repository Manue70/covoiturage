<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/db.php';
?>

<!-- Bouton Créer un trajet -->
<button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tripModal">
    Créer un trajet
</button>

<!-- Modale Créer / Modifier -->
<div class="modal fade" id="tripModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form method="POST" class="modal-content">
      <input type="hidden" name="create_trip" value="1">
      <input type="hidden" name="trip_id" value="">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title">Créer un nouveau trajet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">Agence de départ</label>
          <select name="depart_id" class="form-select" required>
            <option value="">Sélectionnez</option>
            <?php
            $agences = $pdo->query("SELECT * FROM agences ORDER BY nom ASC")->fetchAll();
            foreach ($agences as $a) {
                echo "<option value=\"{$a['id']}\">".htmlspecialchars($a['nom'])."</option>";
            }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Agence d'arrivée</label>
          <select name="arrivee_id" class="form-select" required>
            <option value="">Sélectionnez</option>
            <?php
            foreach ($agences as $a) {
                echo "<option value=\"{$a['id']}\">".htmlspecialchars($a['nom'])."</option>";
            }
            ?>
          </select>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Date départ</label>
            <input type="datetime-local" name="date_depart" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Date arrivée</label>
            <input type="datetime-local" name="date_arrivee" class="form-control" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Nombre de places</label>
          <input type="number" name="places_total" class="form-control" min="1" required>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Créer</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
      </div>
    </form>
  </div>
</div>

<!-- Script JS pour remplir la modale en mode édition -->
<script>
const tripModal = document.getElementById('tripModal');
tripModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const modal = event.target;
    const form = modal.querySelector('form');

    // Si le bouton n'a pas d'attribut data-trip-id => mode création
    if (!button.dataset.tripId) {
        modal.querySelector('.modal-title').textContent = 'Créer un nouveau trajet';
        form.querySelector('button[type="submit"]').textContent = 'Créer';
        form.querySelector('input[name="create_trip"]').name = 'create_trip';
        form.querySelector('input[name="trip_id"]').value = '';
        form.reset();
        return;
    }

    // Mode édition
    const tripId = button.dataset.tripId;
    const departId = button.dataset.depart;
    const arriveeId = button.dataset.arrivee;
    const dateDepart = button.dataset.dateDepart;
    const dateArrivee = button.dataset.dateArrivee;
    const places = button.dataset.places;

    modal.querySelector('.modal-title').textContent = 'Modifier le trajet';
    form.querySelector('button[type="submit"]').textContent = 'Enregistrer';
    form.querySelector('input[name="create_trip"]').name = 'update_trip';
    form.querySelector('input[name="update_trip"]').value = '1';
    form.querySelector('input[name="trip_id"]').value = tripId;
    form.querySelector('select[name="depart_id"]').value = departId;
    form.querySelector('select[name="arrivee_id"]').value = arriveeId;
    form.querySelector('input[name="date_depart"]').value = dateDepart.substring(0,16);
    form.querySelector('input[name="date_arrivee"]').value = dateArrivee.substring(0,16);
    form.querySelector('input[name="places_total"]').value = places;
});
</script>

