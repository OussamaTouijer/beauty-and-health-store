<?php
// 1- Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2- Vérification si les champs sont définis et non vides
    if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["userType"]) && !empty($_POST["telephone"]) && !empty($_POST["address"]) && !empty($_POST["ville"]) && isset($_GET["id"])) {
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
                $sql_update = "UPDATE users SET nom = :nom, prenom = :prenom, email = :email, user_type = :userType, telephone = :telephone, address = :address, ville = :ville WHERE id = :id";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bindParam(':nom', $nom);
                $stmt_update->bindParam(':prenom', $prenom);
                $stmt_update->bindParam(':email', $email);
                $stmt_update->bindParam(':userType', $userType);
                $stmt_update->bindParam(':telephone', $telephone);
                $stmt_update->bindParam(':address', $address);
                $stmt_update->bindParam(':ville', $ville);
                $stmt_update->bindParam(':id', $id);

                if ($stmt_update->execute()) {
                    // Redirection vers la page index
                    header('location:listeCustomers.php?update=ok'); // Correction: 'listeProduits.php' a été corrigé en 'listeCategories.php'
                    exit; // Arrête l'exécution du script
                } else {
                    echo "Erreur lors de la mise à jour de le Client: " . $stmt_update->errorInfo()[2];
                }

                $stmt_update->closeCursor(); // Correction: Déplacement de cette ligne à l'intérieur du bloc try

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
