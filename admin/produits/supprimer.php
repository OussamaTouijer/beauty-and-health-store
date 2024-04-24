<?php
// 1- Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // 2- Vérification si les champs sont définis et non vides
    if (!empty($_GET["id"])) {
        // Récupération des valeurs des champs
        $id = htmlspecialchars($_GET["id"]);

        // 3- Inclusion du fichier de fonctions pour la connexion à la base de données
        require_once '../../include/functionsProductCate.php';
        $conn = connectToDatabase();

        // Vérification de la connexion
        if ($conn) {
            try {
                // 4- Traitement des données récupérées
                // Préparation de la requête SQL avec des paramètres nommés
                $sql_delete = "DELETE FROM products WHERE id = :id";
                $stmt_delete = $conn->prepare($sql_delete);
                $stmt_delete->bindParam(':id', $id);

                // Exécution de la requête
                if ($stmt_delete->execute()) {
                    // Redirection vers la page index
                    header('Location: listeProduits.php?delete=ok');
                    exit; // Arrête l'exécution du script
                } else {
                    echo "Erreur lors de la suppression de la catégorie: " . $stmt_delete->errorInfo()[2];
                    header('Location: listeProduits.php?delete=Nok');
                    exit; // Arrête l'exécution du script
                }

                // Fermeture du statement
                $stmt_delete->closeCursor();

                // Fermeture de la connexion à la base de données
                $conn = null;
            } catch (PDOException $e) {
                echo "Erreur: " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    } else {
        echo "L'identifiant de la catégorie est requis.";
    }
}
?>
