<?php

function InsertClients($data) {
    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $DBname = "éclat & vitalité";

    // Connexion à la base de données
    $conn = connectToDatabase($servername, $username, $password, $DBname);

    // Préparation de la requête SQL avec des placeholders pour les valeurs à insérer
    $requete = "INSERT INTO users (email, password, user_type, telephone, address, ville, nom, prenom) VALUES (:email, :password, :user_type, :telephone, :address, :ville, :nom, :prenom)";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);

        // Chiffrer le mot de passe avec MD5
        $hashed_password = md5($data['password']);

        // Vérifier si 'user_type' est défini, sinon attribuer la valeur par défaut 'client'
        if (!isset($data['user_type'])) {
            $data['user_type'] = 'client';
        }

        // Liaison des valeurs des paramètres
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashed_password); // Utiliser le mot de passe chiffré
        $stmt->bindParam(':user_type', $data['user_type']);
        $stmt->bindParam(':telephone', $data['telephone']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':ville', $data['ville']);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);

        // Exécution de la requête SQL
        $stmt->execute();

        // Fermeture de la connexion à la base de données
        $conn = null;

        // Retourne true pour indiquer que l'insertion a été réussie
        return true;
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, affichez un message d'erreur
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Retourne false pour indiquer que l'insertion a échoué
        return false;
    }
}


function connectUser($data) {
    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $DBname = "éclat & vitalité";

    // Connexion à la base de données
    $conn = connectToDatabase($servername, $username, $password, $DBname);

    // Préparation de la requête SQL avec des placeholders pour les valeurs à insérer
    $requete = "SELECT * FROM users WHERE email = :email";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);

        // Liaison des valeurs des paramètres
        $stmt->bindParam(':email', $data['email']);

        // Exécution de la requête SQL
        $stmt->execute();

        // Récupération des données de l'utilisateur
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification si l'utilisateur existe et si le mot de passe correspond
        if ($user && password_verify($data['password'], $user['password'])) {
            // Fermeture de la connexion à la base de données
            $conn = null;
            // Retourne les données de l'utilisateur
            return $user;
        } else {
            // Si aucun utilisateur n'est trouvé ou le mot de passe ne correspond pas, retourne false
            // Fermeture de la connexion à la base de données
            $conn = null;
            return false;
        }
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, affichez un message d'erreur
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Retourne false pour indiquer que la connexion a échoué
        return false;
    }
}


?>
