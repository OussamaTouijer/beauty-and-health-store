<?php
session_start(); // Démarrage de la session

// 1- Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2- Vérification si les champs sont définis et non vides
    if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["telephone"]) && !empty($_POST["address"]) && !empty($_POST["ville"]) && isset($_GET["id"])) {
        // Récupération des valeurs des champs
        $nom = htmlspecialchars($_POST["nom"]);
        $prenom = htmlspecialchars($_POST["prenom"]);
        $email = htmlspecialchars($_POST["email"]);
        $userType = htmlspecialchars($_POST["userType"]);
        $telephone = htmlspecialchars($_POST["telephone"]);
        $address = htmlspecialchars($_POST["address"]);
        $ville = htmlspecialchars($_POST["ville"]);
        $id = htmlspecialchars($_GET["id"]);

        // 3- Inclusion du fichier de fonctions pour la connexion à la base de données
        require_once '../../include/functionsProductCate.php';
        $conn = connectToDatabase();

        // Vérification de la connexion
        if ($conn) {
            try {
                $sql_update = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, address = :address, ville = :ville WHERE id = :id";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bindParam(':nom', $nom);
                $stmt_update->bindParam(':prenom', $prenom);
                $stmt_update->bindParam(':email', $email);
                $stmt_update->bindParam(':telephone', $telephone);
                $stmt_update->bindParam(':address', $address);
                $stmt_update->bindParam(':ville', $ville);
                $stmt_update->bindParam(':id', $id);

                if ($stmt_update->execute()) {
                    // Récupération des données de l'utilisateur mis à jour
                    $sql_select = "SELECT * FROM users WHERE id = :id";
                    $stmt_select = $conn->prepare($sql_select);
                    $stmt_select->bindParam(':id', $id);
                    $stmt_select->execute();
                    $user = $stmt_select->fetch(PDO::FETCH_ASSOC);

                    // Attribution des valeurs aux variables de session
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['prenom'] = $user['prenom'];
                    $_SESSION['nom'] = $user['nom'];
                    $_SESSION['user_type'] = $user['user_type'];
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['address'] = $user['address'];
                    $_SESSION['ville'] = $user['ville'];

                    // Redirection vers la page profile
                    header("location: profile.php?update=ok&id=$id");
                    exit; // Arrête l'exécution du script
                } else {
                    echo "Erreur lors de la mise à jour du Client: " . $stmt_update->errorInfo()[2];
                }

                $stmt_update->closeCursor(); // Déplacement à l'intérieur du bloc try

            } catch (PDOException $e) {
                echo "Erreur: " . $e->getMessage();
            } finally {
                // Fermeture de la connexion à la base de données
                $conn = null;
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>
