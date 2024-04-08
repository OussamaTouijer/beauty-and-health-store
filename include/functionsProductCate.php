<?php

function connectToDatabase($servername, $username, $password, $DBname) {
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

function getAllCategories() {
    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $DBname = "éclat & vitalité";

    // Connexion à la base de données
    $conn = connectToDatabase($servername, $username, $password, $DBname);

    // Création de la requête SQL pour récupérer toutes les catégories
    $requete = "SELECT * FROM categories";

    try {
        // Exécution de la requête SQL
        $resultat = $conn->query($requete);
        // Récupération des résultats de la requête
        $categories = $resultat->fetchAll();
        // Fermeture de la connexion à la base de données
        $conn = null;
        return $categories;
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, affichez un message d'erreur
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Terminez le script en cas d'erreur lors de l'exécution de la requête
        exit();
    }
}

function getAllProducts() {
    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $DBname = "éclat & vitalité";

    // Connexion à la base de données
    $conn = connectToDatabase($servername, $username, $password, $DBname);

    // Création de la requête SQL pour récupérer tous les produits
    $requete = "SELECT * FROM products";

    try {
        // Exécution de la requête SQL
        $resultat = $conn->query($requete);
        // Récupération des résultats de la requête
        $products = $resultat->fetchAll();
        // Fermeture de la connexion à la base de données
        $conn = null;
        return $products;
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, affichez un message d'erreur
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Terminez le script en cas d'erreur lors de l'exécution de la requête
        exit();
    }
}

function searchProducts($keywords) {
    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $DBname = "éclat & vitalité";

    // Connexion à la base de données
    $conn = connectToDatabase($servername, $username, $password, $DBname);

    // Préparation de la requête SQL avec un paramètre de placeholder
    $requete = "SELECT * FROM products WHERE libelle LIKE :keywords";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);
        // Liaison de la valeur du paramètre à la variable $keywords
        $stmt->bindValue(':keywords', '%' . $keywords . '%', PDO::PARAM_STR);
        // Exécution de la requête SQL
        $stmt->execute();
        // Récupération des résultats de la requête
        $products = $stmt->fetchAll();
        // Fermeture de la connexion à la base de données
        $conn = null;
        return $products;
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, affichez un message d'erreur
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Terminez le script en cas d'erreur lors de l'exécution de la requête
        exit();
    }
}

function getProductById($id) {
    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $DBname = "éclat & vitalité";

    // Connexion à la base de données
    $conn = connectToDatabase($servername, $username, $password, $DBname);

    // Préparation de la requête SQL avec un paramètre de placeholder
    $requete = "SELECT * FROM products WHERE id = :id";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);
        // Liaison de la valeur du paramètre à la variable $id
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        // Exécution de la requête SQL
        $stmt->execute();
        // Récupération du résultat de la requête (un seul produit puisqu'on filtre par ID)
        $product = $stmt->fetch();
        // Fermeture de la connexion à la base de données
        $conn = null;
        return $product; // Retourne le produit trouvé (ou null si aucun produit trouvé)
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
