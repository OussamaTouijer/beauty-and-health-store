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

function countUsers() {
    // Connexion à la base de données
    $conn = connectToDatabase();

    // Requête SQL pour compter le nombre d'utilisateurs
    $requete = "SELECT COUNT(*) AS user_count FROM users WHERE user_type LIKE'client'";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);

        // Exécution de la requête SQL
        $stmt->execute();

        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fermeture de la connexion à la base de données
        $conn = null;

        // Retourne le nombre d'utilisateurs
        return $result['user_count'];
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, journaliser l'erreur
        error_log("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Retourne -1 pour indiquer une erreur
        return -1;
    }
}

function countProduits() {
    // Connexion à la base de données
    $conn = connectToDatabase();

    // Requête SQL pour compter le nombre d'utilisateurs
    $requete = "SELECT COUNT(*) AS produit_count FROM products";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);

        // Exécution de la requête SQL
        $stmt->execute();

        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fermeture de la connexion à la base de données
        $conn = null;

        // Retourne le nombre d'utilisateurs
        return $result['produit_count'];
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, journaliser l'erreur
        error_log("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Retourne -1 pour indiquer une erreur
        return -1;
    }
}


function countCommands() {
    // Connexion à la base de données
    $conn = connectToDatabase();

    // Requête SQL pour compter le nombre d'utilisateurs
    $requete = "SELECT COUNT(*) AS command_count FROM commands";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);

        // Exécution de la requête SQL
        $stmt->execute();

        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fermeture de la connexion à la base de données
        $conn = null;

        // Retourne le nombre d'utilisateurs
        return $result['command_count'];
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, journaliser l'erreur
        error_log("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Retourne -1 pour indiquer une erreur
        return -1;
    }
}

?>