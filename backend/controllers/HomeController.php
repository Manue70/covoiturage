<?php
require_once '../models/Trajet.php';
date_default_timezone_set('Europe/Paris');


class HomeController {
    public function index() {
        $trajetModel = new Trajet();
        $trajets = $trajetModel->getAllAvailable(); // récupère tous les trajets disponibles et dates futures
        include '../views/home.php';
    }
}


?>
