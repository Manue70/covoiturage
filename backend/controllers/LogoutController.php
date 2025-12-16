<?php
declare(strict_types=1);

/**
 * Controller de déconnexion.
 *
 * Détruit la session utilisateur et redirige vers l’accueil.
 */

session_start();
session_destroy();

header('Location: /home');
exit;

