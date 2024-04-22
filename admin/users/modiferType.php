<?php
// 1- Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2- Vérification si les champs sont définis et non vides
    if (!empty($_POST["userType"])) { // Correction: Ajout de isset($_GET["id"]) pour vérifier si l'ID est défini
        // Récupération des valeurs des champs
        $userType = htmlspecialchars($_POST["userType"]);
        $id = htmlspecialchars($_GET["id"]);

        // 3- Inclusion du fichier de fonctions pour la connexion à la base de données
        require_once '../../include/functionsCustomers.php';
        $conn = connectToDatabase();

        // Vérification de la connexion
        if ($conn) {
            try {
                // Mise à jour de la catégorie
                $sql_update = "UPDATE users SET user_type = :userType WHERE id = :id"; // Correction: Suppression de 'libelle = :libelle' car cela ne semble pas être utilisé
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bindParam(':userType', $userType);
                $stmt_update->bindParam(':id', $id);

                if ($stmt_update->execute()) {
                    // Redirection vers la page index
                    header('location:listeCustomers.php?update=ok');
                    exit; // Arrête l'exécution du script après la redirection
                } else {
                    echo "Erreur lors de la mise à jour de la catégorie: " . $stmt_update->errorInfo()[2];
                }

                // Fermeture du curseur
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
        echo "Tous les champs sont obligatoires."; // Correction: Ajout d'un message si l'ID n'est pas défini
    }
}
?>
