<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        if ($user['rank'] !== 'admin') {
            die("<h1>Accès refusé</h1>");
        }
    } else {
        die("<h1>Accès refusé</h1>");
    }

?>