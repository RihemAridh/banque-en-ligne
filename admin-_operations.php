<?php

class Admin {
    private $cnx;

    public function __construct($cnx) {
        $this->cnx = $cnx;
    }

    // Méthode pour récupérer la liste des clients
    public function getClients() {
        // Exclure l'administrateur de la liste des clients
        $stmt = $this->cnx->prepare("SELECT * FROM clients WHERE role != 'admin'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Méthode pour récupérer les comptes d'un client
    public function getClientAccounts($clientId) {
        $stmt = $this->cnx->prepare("SELECT * FROM comptes WHERE client_id = :client_id");
        $data=array(':client_id' => $clientId);
        $stmt->execute($data);
        return $stmt->fetchAll();
    }

    // Méthode pour accorder un crédit à un client
    public function accorderCredit($clientId, $montant) {
        // Ajout du montant du crédit au solde du client
        $stmt = $this->cnx->prepare("UPDATE comptes SET solde = solde + :montant WHERE client_id = :client_id");
        $data=array(':montant' => $montant, ':client_id' => $clientId);
        $stmt->execute($data);

        // Mise à jour du statut du crédit
        $stmt = $this->cnx->prepare("UPDATE credits SET statut = 'accordé' WHERE 
        client_id = :client_id AND montant = :montant AND statut = 'en attente'");
        $d=array(':client_id' => $clientId, ':montant' => $montant);
        $stmt->execute($d);
    }

    // Méthode pour refuser un crédit à un client
    public function refuserCredit($clientId) {
        $stmt = $this->cnx->prepare("UPDATE credits SET statut = 'refusé'
         WHERE client_id = :client_id AND statut = 'en attente'");
         $data=array(':client_id' => $clientId); 
        $stmt->execute($data);
    }

    // Méthode pour récupérer les demandes de crédit en attente
    public function getPendingCreditRequests() {
        $stmt = $this->cnx->prepare("SELECT * FROM credits WHERE statut = 'en attente'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Méthode pour ajouter un nouveau client
    public function addClient($nom, $prenom, $email, $password) {
        $stmt = $this->cnx->prepare("INSERT INTO clients (nom, prenom, email, mot_de_passe, role)
         VALUES (:nom, :prenom, :email, :mot_de_passe, 'client')");
         $data=array(':nom' => $nom, ':prenom' => $prenom, ':email' => $email, ':mot_de_passe' => password_hash($password,PASSWORD_BCRYPT ));
        $stmt->execute($data);
    }

    // Méthode pour récupérer toutes les transactions
    public function getAllTransactions() {
        $stmt = $this->cnx->prepare("SELECT * FROM transactions");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>
