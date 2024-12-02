<?php
session_start();
require_once( 'connect.php');
require_once ('user.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Créer une instance de la classe User
    $user = new User($cnx, "", "", $username, "", $password, "");

    // Tenter de se connecter
    $userInfo = $user->login();

    if ($userInfo) {
        // Stocker les informations utilisateur dans la session
        $_SESSION['client_id'] = $userInfo['id'];
        $_SESSION['username'] = $userInfo['email'];
        $_SESSION['role'] = $userInfo['role'];

        // Rediriger vers le tableau de bord approprié
        if ($userInfo['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: client.php");
        }
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
