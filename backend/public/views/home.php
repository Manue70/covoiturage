<?php
declare(strict_types=1);
?>

<?php include __DIR__ . '/header_guest.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h1>Trajets disponibles</h1>

    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th>Départ</th>
                <th>Date départ</th>
                <th>Arrivée</th>
                <th>Date arrivée</th>
                <th>Places disponibles</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($trips)): ?>
                <?php foreach ($trips as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['depart_nom']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($t['date_depart']))) ?></td>
                        <td><?= htmlspecialchars($t['arrivee_nom']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($t['date_arrivee']))) ?></td>
                        <td><?= htmlspecialchars((string)$t['places_disponibles']) ?>/<?= htmlspecialchars((string)$t['places_total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Aucun trajet disponible.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/footer.php'; ?>
