<?php
namespace app\controllers\statistique;

use Flight;

class BaseController {
    protected function checkAuth() {
        // if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
        //     Flight::json(['error' => 'Unauthorized'], 401);
        //     return false;
        // }
        return true;
    }
}
?>