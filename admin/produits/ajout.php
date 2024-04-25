<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["libelle"]) && !empty($_POST["prix"]) && !empty($_POST["id_categorie"]) && !empty($_POST["quantite"]) && !empty($_POST["description"]) && !empty($_FILES["image"]["name"]) && !empty($_POST["color"])&& !empty($_POST["marque"])) {
        $libelle = htmlspecialchars($_POST["libelle"]);
        $prix = htmlspecialchars($_POST["prix"]);
        $id_categorie = htmlspecialchars($_POST["id_categorie"]);
        $quantite = htmlspecialchars($_POST["quantite"]);
        $description = htmlspecialchars($_POST["description"]);
        $couleur = htmlspecialchars($_POST["color"]);
        $marque = htmlspecialchars($_POST["marque"]);

        // Télécharger l'image
        $target_dir = "D:/wamp64/www/beauty-and-health-store/images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = basename($_FILES["image"]["name"]); // Nom du fichier pour stocker dans la base de données
        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }

        require_once '../../include/functionsProductCate.php';
        $conn = connectToDatabase();

        if ($conn) {
            try {
                $sql_insert = "INSERT INTO products (libelle, prix, id_categorie, discount, description, image, color, marque) VALUES (:libelle, :prix, :id_categorie, :quantite, :description, :image, :couleur, :marque)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bindParam(':libelle', $libelle);
                $stmt_insert->bindParam(':prix', $prix);
                $stmt_insert->bindParam(':id_categorie', $id_categorie);
                $stmt_insert->bindParam(':quantite', $quantite);
                $stmt_insert->bindParam(':description', $description);
                $stmt_insert->bindParam(':image', $image);
                $stmt_insert->bindParam(':couleur', $couleur);
                $stmt_insert->bindParam(':marque', $marque);

                if ($stmt_insert->execute()) {
                    header('location:listeProduits.php?ajout=ok');
                    exit;
                } else {
                    echo "Erreur lors de l'ajout du produit: " . $stmt_insert->errorInfo()[2];
                }

                $stmt_insert->closeCursor();
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
