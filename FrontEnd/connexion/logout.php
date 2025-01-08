<?php
session_start();

session_unset(); // Supprime toutes les variables de session
session_destroy(); // Détruit la session
setcookie(session_name(), '', time() - 3600, '/'); // Supprime le cookie de session

header("Location: ../connexion/connexion.php"); // Redirige l'utilisateur
exit;
?>