<?php
// 1- Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2- Vérification si les champs sont définis et non vides
    if (!empty($_POST["libelle"]) && !empty($_POST["description"]) && !empty($_GET["id"])) {
        // Récupération des valeurs des champs
        $libelle = htmlspecialchars($_POST["libelle"]);
        $description = htmlspecialchars($_POST["description"]);
        $id = htmlspecialchars($_GET["id"]);

        // 3- Inclusion du fichier de fonctions pour la connexion à la base de données
        require_once '../../include/functionsProductCate.php';
        $conn = connectToDatabase();

        // Vérification de la connexion
        if ($conn) {
            try {
                // Mise à jour de la catégorie
                $sql_update = "UPDATE categories SET description = :description, libelle = :libelle WHERE id = :id"; // Correction: Utilisation de la virgule au lieu de 'and' pour séparer les colonnes
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bindParam(':description', $description);
                $stmt_update->bindParam(':libelle', $libelle);
                $stmt_update->bindParam(':id', $id);

                if ($stmt_update->execute()) {
                    // Redirection vers la page index
                    header('location:listeCategorise.php?update=ok'); // Correction: 'listeProduits.php' a été corrigé en 'listeCategories.php'
                    exit; // Arrête l'exécution du script
                } else {
                    echo "Erreur lors de la mise à jour de la catégorie: " . $stmt_update->errorInfo()[2];
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
