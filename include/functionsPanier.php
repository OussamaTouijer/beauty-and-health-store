<?php

function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $DBname = "eclat_vitalite";
    try {
        // Connexion à la base de données en utilisant PDO
        $conn = new PDO("mysql:host=$servername;dbname=$DBname", $username, $password);
        // Configuration de PDO pour générer des exceptions en cas d'erreur
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        // En cas d'échec de la connexion, affichez un message d'erreur
        echo "Échec de la connexion : " . $e->getMessage();
        // Terminez le script en cas d'échec de la connexion
        exit();
    }
}

//les fonction pour la table Categories

function getAllPaniers() {
    try {
        // Connexion à la base de données
        $conn = connectToDatabase();

        // Création de la requête SQL pour récupérer tous les paniers avec les informations des utilisateurs associés
        $requete = "SELECT p.*, u.nom,u.prenom,u.address,u.email FROM panier p INNER JOIN users u ON u.id = p.idClient";

        // Exécution de la requête SQL
        $resultat = $conn->query($requete);

        // Récupération des résultats de la requête
        $paniers = $resultat->fetchAll(PDO::FETCH_ASSOC);

        // Fermeture de la connexion à la base de données
        $conn = null;

        return $paniers;
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, affichage d'un message d'erreur
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Terminez le script en cas d'erreur lors de l'exécution de la requête
        exit();
    }
}

function searchPaniers($keywords) {
    try {
        // Connexion à la base de données
        $conn = connectToDatabase();

        // Préparation de la requête SQL avec un paramètre de placeholder
        $requete = "SELECT p.*, u.nom,u.prenom,u.address,u.email FROM panier p INNER JOIN users u ON u.id = p.idClient WHERE p.id = :keywords";

        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);
        // Liaison de la valeur du paramètre à la variable $keywords
        $stmt->bindValue(':keywords', $keywords, PDO::PARAM_INT);
        // Exécution de la requête SQL
        $stmt->execute();
        // Récupération des résultats de la requête
        $paniers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Fermeture de la connexion à la base de données
        $conn = null;
        return $paniers;
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, affichage d'un message d'erreur
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Terminez le script en cas d'erreur lors de l'exécution de la requête
        exit();
    }
}

function getAllCommands() {
    try {
        // Connexion à la base de données
        $conn = connectToDatabase();

        // Création de la requête SQL pour récupérer tous les paniers avec les informations des utilisateurs associés
        $requete = "SELECT c.*, u.libelle,u.image,u.marque FROM panier,commands c INNER JOIN products u ON u.id = c.produit where panier.id=c.id_panier ";

        // Exécution de la requête SQL
        $resultat = $conn->query($requete);

        // Récupération des résultats de la requête
        $paniers = $resultat->fetchAll(PDO::FETCH_ASSOC);


        // Fermeture de la connexion à la base de données
        $conn = null;

        return $paniers;
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, affichage d'un message d'erreur
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Terminez le script en cas d'erreur lors de l'exécution de la requête
        exit();
    }
}

if (isset($_POST)) {
    changerEtatPanier($_POST);
}

function changerEtatPanier($data)
{
    try {
        // Connexion à la base de données
        $conn = connectToDatabase();

        // Prépare la requête SQL avec des paramètres liés
        $requete = "UPDATE panier SET etat_commande = :etat_commande WHERE id = :idP";
        $stmt = $conn->prepare($requete);

        // Liaison des paramètres
        $stmt->bindParam(':etat_commande', $data['etat_commande']);
        $stmt->bindParam(':idP', $data['idP']);

        // Exécution de la requête SQL
        $stmt->execute();

        // Fermeture de la connexion à la base de données
        $conn = null;

        // Optionally, you can return a success message or do other operations here
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, affichage d'un message d'erreur
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Terminez le script en cas d'erreur lors de l'exécution de la requête
        exit();
    }
}


?>
