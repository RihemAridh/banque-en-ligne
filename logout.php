<?php
session_start();

// Déconnexion de l'utilisateur (administrateur ou client)
session_unset();
session_destroy();

// Redirection vers la page d'accueil après la déconnexion
header("Location: index.html");
exit;
?>
