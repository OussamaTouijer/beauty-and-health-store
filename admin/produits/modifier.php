<?php
// 1- Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["libelle"]) && !empty($_POST["prix"]) && !empty($_POST["id_categorie"]) && !empty($_POST["quantite"]) && !empty($_POST["description"]) && !empty($_FILES["image"]["name"]) && !empty($_POST["couleur"])) {
        $libelle = htmlspecialchars($_POST["libelle"]);
        $prix = htmlspecialchars($_POST["prix"]);
        $id_categorie = htmlspecialchars($_POST["id_categorie"]);
        $quantite = htmlspecialchars($_POST["quantite"]);
        $description = htmlspecialchars($_POST["description"]);
        $couleur = htmlspecialchars($_POST["couleur"]);
        $id = htmlspecialchars($_GET["id"]);


        // Télécharger l'image
        $target_dir = "D:/wamp64/www/beauty-and-health-store/images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["image"]["name"]); // Nom du fichier pour stocker dans la base de données
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }

        // 3- Inclusion du fichier de fonctions pour la connexion à la base de données
        require_once '../../include/functionsProductCate.php';
        $conn = connectToDatabase();

        // Vérification de la connexion
        if ($conn) {
            try {
                // Mise à jour de la catégorie
                $sql_update = "UPDATE products SET description = :description, libelle = :libelle, prix = :prix, id_categorie = :id_categorie, image = :image, discount = :quantite, color = :couleur WHERE id = :id"; // Correction: Ajout d'espaces et correction de la position des paramètres
                $stmt_update = $conn->prepare($sql_update);

                // Correction: Liaison des paramètres
                $stmt_update->bindParam(':description', $description);
                $stmt_update->bindParam(':libelle', $libelle);
                $stmt_update->bindParam(':prix', $prix);
                $stmt_update->bindParam(':id_categorie', $id_categorie);
                $stmt_update->bindParam(':image', $image);
                $stmt_update->bindParam(':quantite', $quantite);
                $stmt_update->bindParam(':couleur', $couleur);
                $stmt_update->bindParam(':id', $id);

                if ($stmt_update->execute()) {
                    // Redirection vers la page index
                   header('location:listeProduits.php?update=ok'); // Correction: 'listeProduits.php' a été corrigé en 'listeProduits.php';
                    exit; // Arrête l'exécution du script
                } else {
                    echo "Erreur lors de la mise à jour du produit: " . $stmt_update->errorInfo()[2];
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
