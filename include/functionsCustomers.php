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

function getAllCustomers() {

    // Connexion à la base de données
    $conn = connectToDatabase();

    // Création de la requête SQL pour récupérer toutes les catégories
    $requete = "SELECT * FROM users";

    try {
        // Exécution de la requête SQL
        $resultat = $conn->query($requete);
        // Récupération des résultats de la requête
        $users = $resultat->fetchAll();
        // Fermeture de la connexion à la base de données
        $conn = null;
        return $users;
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, affichez un message d'erreur
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Terminez le script en cas d'erreur lors de l'exécution de la requête
        exit();
    }
}



function searchCustomers($id) {
    // Connexion à la base de données
    $conn = connectToDatabase();

    // Préparation de la requête SQL avec un paramètre de placeholder
    $requete = "SELECT * FROM users WHERE id = :id";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);
        // Liaison de la valeur du paramètre à la variable $id
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        // Exécution de la requête SQL
        $stmt->execute();
        // Récupération des résultats de la requête
        $users = $stmt->fetchAll();
        // Fermeture de la connexion à la base de données
        $conn = null;
        return $users;
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, affichez un message d'erreur
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Terminez le script en cas d'erreur lors de l'exécution de la requête
        exit();
    }
}


?>