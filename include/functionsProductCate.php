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

function getAllCategories() {

    // Connexion à la base de données
    $conn = connectToDatabase();

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

function searchCategories($keywords) {

    // Connexion à la base de données
    $conn = connectToDatabase();

    // Préparation de la requête SQL avec un paramètre de placeholder
    $requete = "SELECT * FROM categories WHERE libelle LIKE :keywords";

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

function getCategoriById($id) {

    // Connexion à la base de données
    $conn = connectToDatabase();

    // Préparation de la requête SQL avec un paramètre de placeholder
    $requete = "SELECT * FROM categories WHERE id = :id";

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
        return $product['libelle']; // Retourne le produit trouvé (ou null si aucun produit trouvé)
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

    // Connexion à la base de données
    $conn = connectToDatabase();

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

    // Connexion à la base de données
    $conn = connectToDatabase();

    // Préparation de la requête SQL avec un paramètre de placeholder
    $requete = "SELECT * FROM products WHERE marque LIKE :keywords";

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

    // Connexion à la base de données
    $conn = connectToDatabase();

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

function sortByPopularity($products) {
    // Créer un tableau temporaire pour stocker les clés et les valeurs de popularité
    $popularity = array();

    // Parcourir tous les produits et calculer la popularité de chaque produit
    foreach ($products as $key => $product) {
        // Pour cet exemple, supposons que chaque produit a un nombre de ventes aléatoire entre 0 et 100
        $sales = rand(0, 100); // Générez un nombre aléatoire de ventes
        $popularity[$key] = $sales;
    }

    // Trier les produits en fonction de leur popularité (nombre de ventes)
    // Utiliser la fonction arsort pour trier le tableau dans l'ordre décroissant tout en conservant les associations clé-valeur
    arsort($popularity);

    // Créer un tableau de produits triés en fonction de la popularité
    $sortedProducts = array();
    foreach ($popularity as $key => $value) {
        $sortedProducts[$key] = $products[$key];
    }

    return $sortedProducts;
}



?>
