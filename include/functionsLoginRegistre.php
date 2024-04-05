<?php


function InsertClients($data) {
    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $DBname = "beautyhub_db";

    // Connexion à la base de données
    $conn = connectToDatabase($servername, $username, $password, $DBname);

    // Préparation de la requête SQL avec des placeholders pour les valeurs à insérer
    $requete = "INSERT INTO user (email, password, user_type, telephone, address, ville, nom, prenom) VALUES (:email, :password, :user_type, :telephone, :address, :ville, :nom, :prenom)";

    try {
        // Préparation de la requête SQL
        $stmt = $conn->prepare($requete);
        
     // Vérifier si 'user_type' est défini, sinon attribuer la valeur par défaut 'client'
    if (!isset($data['user_type'])) {
        $data['user_type'] = 'client';
    }

        // Liaison des valeurs des paramètres
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
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
?>
