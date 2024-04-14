<?php
// 1- Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2- Vérification si les champs sont définis et non vides
    if (!empty($_POST["libelle"]) && !empty($_POST["description"])) {
        // Récupération des valeurs des champs
        $libelle = htmlspecialchars($_POST["libelle"]);
        $description = htmlspecialchars($_POST["description"]);

        // 3- Inclusion du fichier de fonctions pour la connexion à la base de données
        require_once '../../include/functionsProductCate.php';
        $conn = connectToDatabase();

        // Vérification de la connexion
        if ($conn) {
            try {
                // 4- Vérification si le libellé existe déjà
                $sql_check = "SELECT COUNT(*) AS count FROM categories WHERE libelle = :libelle";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->bindParam(':libelle', $libelle);
                $stmt_check->execute();
                $row = $stmt_check->fetch(PDO::FETCH_ASSOC);

                if ($row['count'] > 0) {
                    // Redirection vers la page index
                    header('location:listeProduits.php?ajout=Nok');
                    exit; // Arrête l'exécution du script
                } else {
                    // 5- Traitement des données récupérées
                    // Préparation de la requête SQL avec des paramètres nommés
                    $sql_insert = "INSERT INTO categories (libelle, description) VALUES (:libelle, :description)";
                    $stmt_insert = $conn->prepare($sql_insert);
                    $stmt_insert->bindParam(':libelle', $libelle);
                    $stmt_insert->bindParam(':description', $description);

                    // Exécution de la requête
                    if ($stmt_insert->execute()) {
                        // Redirection vers la page index
                        header('location:listeProduits.php?ajout=ok');
                        exit; // Arrête l'exécution du script
                    } else {
                        echo "Erreur lors de l'ajout de la catégorie: " . $stmt_insert->errorInfo()[2];
                    }
                }

                // Fermeture du statement
                $stmt_check->closeCursor();
                $stmt_insert->closeCursor();

                // Fermeture de la connexion à la base de données
                $conn = null;
            } catch (PDOException $e) {
                echo "Erreur: " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>
