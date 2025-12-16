<?php
declare(strict_types=1);

// router.php 
if (!defined('ROOT')) {
    define('ROOT', __DIR__ . '/public'); // point d'entrée 
}


require_once __DIR__ . '/config/db.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Démarrage de session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Routeur
switch ($uri) {

    // --- Home ---
    case '/':
    case '/home':
        // Si admin → redirection vers admin dashboard par défaut
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            header('Location: /admin/trajets');
            exit;
        }
        // Si user connecté
        elseif (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user') {
            require __DIR__ . '/controllers/HomeUserController.php';
        } else {
            // Guest
            require __DIR__ . '/controllers/HomeController.php';
        }
        break;

    // --- Login / Logout ---
    case '/login':
        require __DIR__ . '/controllers/LoginController.php';
        break;

    case '/logout':
        require __DIR__ . '/controllers/LogoutController.php';
        break;

    // --- Trip creation ---
    case '/trip/create':
        require __DIR__ . '/controllers/TripController.php';
        break;

    // --- Admin routes ---
    case '/admin/users':
        require __DIR__ . '/controllers/AdminUsersController.php';
        break;

    case '/admin/agences':
        require __DIR__ . '/controllers/AdminAgencesController.php';
        break;

    case '/admin/trajets':
        require __DIR__ . '/controllers/AdminTrajetsController.php';
        break;

    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}


