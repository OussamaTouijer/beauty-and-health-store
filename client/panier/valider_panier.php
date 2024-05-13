<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email']) || $_SESSION['user_type'] !== "client") {
    header("Location: ../../login.php");
    exit(); // Assurez-vous de sortir après avoir redirigé
}

include '../../include/functionsProductCate.php';

// Connexion à la base de données
$conn = connectToDatabase();

if (isset($_SESSION['panier'])) {
    try {
        // Vérification si les champs sont définis et non vides
        if (isset($_SESSION['id']) && isset($_SESSION['panier'][1]) && isset($_GET['paiement'])) {
            $idClient=$_SESSION['id'];
            $total = $_SESSION['panier'][1];
            $paiement=$_GET['paiement'];



            // Préparation de la requête SQL avec des paramètres nommés Pour panier
            $sql_insert = "INSERT INTO panier (idClient , total, mode_paiement) VALUES (:idClient , :total, :mode_paiement)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bindParam(':idClient', $idClient);
            $stmt_insert->bindParam(':total', $total);
            $stmt_insert->bindParam(':mode_paiement', $paiement);



            // Exécution de la requête
            if ($stmt_insert->execute()) {
                $commandes=[];
                $id_panier=$conn->lastInsertId();//recuper id de panier est la dirnier lign insert
                $commandes = $_SESSION["panier"][2];
                foreach ($commandes as $index=>$commande){
                $sql_insert = "INSERT INTO commands (produit, total, id_panier, quantite) VALUES (:produit, :total, :id_panier, :quantite)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bindParam(':produit', $commande[2]);
                $stmt_insert->bindParam(':total', $commande[1]);
                $stmt_insert->bindParam(':quantite', $commande[0]);
                $stmt_insert->bindParam(':id_panier', $id_panier);
                $stmt_insert->execute();
                }
                // Redirection vers la page index
                $_SESSION["panier"]=null;
                $_SESSION['Nbt'] = is_array($_SESSION["panier"][2]) ? count($_SESSION["panier"][2]) : 0;
                header('location:../panier/panier.php');
                exit; // Arrête l'exécution du script après la redirection
            } else {
                echo "Erreur lors de l'ajout de la commande: " . $stmt_insert->errorInfo()[2];
            }
        } else {
            echo "Tous les champs sont obligatoires.";
        }
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    } finally {
        // Fermeture du statement et de la connexion à la base de données
        if (isset($stmt_insert)) {
            $stmt_insert->closeCursor();
        }
        if (isset($conn)) {
            $conn = null;
        }
    }
} else {
    echo "Erreur: méthode de requête incorrecte.";
}
?>