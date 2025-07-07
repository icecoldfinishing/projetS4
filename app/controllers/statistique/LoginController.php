<?php
namespace app\controllers\statistique;

use Flight;

class LoginController {
    public function index() {
        $file = Flight::get('flight.views.path') . DIRECTORY_SEPARATOR . 'login.php';
        if (file_exists($file)) {
            Flight::render('login.php');
        } else {
            Flight::halt(404, 'Fichier login.php introuvable dans app/views/');
        }
    }

    public function login() {
        $data = Flight::request()->data;
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        // Simulation d'authentification (remplace par une vérification en base si nécessaire)
        if ($username === 'admin' && $password === 'admin123') {
            // session_start();
            $_SESSION['user'] = $username;
            $_SESSION['role'] = 'admin';
            Flight::render('reports.php');
        } else {
            Flight::json(['error' => 'Identifiants incorrects'], 401);
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        Flight::redirect('/');
    }
}
?>