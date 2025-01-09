<?php
if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset(); // Supprime toutes les variables de session
    session_destroy(); // Détruit la session
}
?>
