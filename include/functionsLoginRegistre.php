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

//les fonction pour la table user insere dans la table(inscription)


function InsertClients($data) {
    // Connexion à la base de données
    $conn = connectToDatabase();

    // Préparation de la requête SQL avec des placeholders pour les valeurs à insérer
    $requete = "INSERT INTO users (email, password, user_type, telephone, address, ville, nom, prenom) VALUES (:email, :password, :user_type, :telephone, :address, :ville, :nom, :prenom)";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);

        // Utiliser password_hash() pour hacher le mot de passe
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        // Vérifier si 'user_type' est défini, sinon attribuer la valeur par défaut 'client'
        if (!isset($data['user_type'])) {
            $data['user_type'] = 'client';
        }

        // Liaison des valeurs des paramètres
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashed_password); // Utiliser le mot de passe haché
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
        // En cas d'erreur lors de l'exécution de la requête, journaliser l'erreur
        error_log("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Retourne false pour indiquer que l'insertion a échoué
        return false;
    }
}

//les fonction pour la table user(verifier login)


function connectUser($data) {
    // Connexion à la base de données
    $conn = connectToDatabase();

    // Préparation de la requête SQL avec des placeholders pour les valeurs à insérer
    $requete = "SELECT * FROM users WHERE email = :email";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);

        // Liaison des valeurs des paramètres
        $stmt->bindParam(':email', $data['email']);

        // Exécution de la requête SQL
        $stmt->execute();

        // Vérification du nombre de lignes retournées
        $count = $stmt->rowCount();

        // Si au moins une ligne est retournée, l'utilisateur existe dans la base de données
        if ($count > 0) {
            // Récupération des données de l'utilisateur
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe en utilisant password_verify()
            if (password_verify($data['password'], $user['password'])) {
                // Fermeture de la connexion à la base de données
                $conn = null;
                // Retourne les données de l'utilisateur
                return $user;
            } else {
                // Mot de passe incorrect, retourne null
                $conn = null;
                return null;
            }
        } else {
            // Si aucun utilisateur n'est trouvé, retourne null
            $conn = null;
            return null;
        }
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, journaliser l'erreur
        error_log("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Retourne null pour indiquer qu'une erreur s'est produite
        return null;
    }
}

//les fonction pour la table user recupere user

function userById($id) {
    // Connexion à la base de données
    $conn = connectToDatabase();

    // Préparation de la requête SQL avec des placeholders pour les valeurs à insérer
    $requete = "SELECT * FROM users WHERE id = :id";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);

        // Liaison des valeurs des paramètres
        $stmt->bindParam(':id', $id);

        // Exécution de la requête SQL
        $stmt->execute();

        // Vérification du nombre de lignes retournées
        $count = $stmt->rowCount();

        // Si au moins une ligne est retournée, l'utilisateur existe dans la base de données
        if ($count > 0) {
            // Récupération des données de l'utilisateur
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Fermeture de la connexion à la base de données
            $conn = null;
            // Retourne l'utilisateur trouvé
            return $user;
        } else {
            // Si aucun utilisateur n'est trouvé, retourne null
            $conn = null;
            return null;
        }
    } catch(PDOException $e) {
        // En cas d'erreur lors de l'exécution de la requête, journaliser l'erreur
        error_log("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        // Fermeture de la connexion à la base de données
        $conn = null;
        // Retourne null pour indiquer qu'une erreur s'est produite
        return null;
    }
}


?>
