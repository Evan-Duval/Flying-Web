<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        if ($user['rank'] !== 'admin') {
            die(
                "<div class=\"noaccess\">
                    <img src=\"../img/denied-access.png\" alt=\"noacess\" class=\"logo\">

                    <h1>Accès refusé</h1>
                    <h3>Vous avez besoin des permissions Admin pour accéder à cette page</h3>
                </div>"
            );
        }
    } else {
        die(
            "<div class=\"noaccess\">
                <img src=\"../img/denied-access.png\" alt=\"noacess\" class=\"logo\">

                <h1>Accès refusé</h1>
                <h3>Vous avez besoin des permissions Admin pour accéder à cette page</h3>
            </div>"
        );
    }

?>