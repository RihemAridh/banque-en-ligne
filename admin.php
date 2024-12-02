<?php
session_start();
require_once ('connect.php');
require_once ('admin_operations.php');

$admin = new Admin($cnx);
$clients = $admin->getClients();
$creditRequests = $admin->getPendingCreditRequests();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin - Banque en ligne</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; }
        .container { margin-top: 20px; }
        .card { margin-bottom: 20px; }
        .card-header { background-color: #007bff; color: white; font-weight: bold; }
        .list-group-item { font-size: 1.2em; }
        .action-btns a { margin: 5px 0; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Banque en ligne</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                        <a class="nav-link" href="#">Mon Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">Tableau de bord Admin</h1>
        
        <div class="card">
            <div class="card-header">Demandes de crédit en attente</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($creditRequests as $credit): ?>
                        <li class="list-group-item">
                            Client ID: <?= htmlspecialchars($credit['client_id']) ?> - Montant: <?= htmlspecialchars($credit['montant']) ?>dt
                            <form method="post" action="process_credit.php" class="d-inline-block">
                                <input type="hidden" name="client_id" value="<?= htmlspecialchars($credit['client_id']) ?>">
                                <input type="hidden" name="montant" value="<?= htmlspecialchars($credit['montant']) ?>">
                                <button type="submit" name="accorder" class="btn btn-success btn-sm">Accorder</button>
                                <button type="submit" name="refuser" class="btn btn-danger btn-sm">Refuser</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">Actions</div>
            <div class="card-body action-btns">
                <a href="admin_ajout_client.php" class="btn btn-primary d-block">Ajouter un nouveau client</a>
                <a href="admin_voir_clients.php" class="btn btn-secondary d-block">Voir tous les clients</a>
                <a href="admin_voir_transactions.php" class="btn btn-success d-block">Voir toutes les transactions</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
