<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email']) || $_SESSION['user_type'] !== "client") {
    header("Location: ../../login.php");
    exit(); // Assurez-vous de sortir après avoir redirigé
}



// Vérifier si l'identifiant est présent dans l'URL
$id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : null;

// Vérifier si l'identifiant est valide (entier positif ou zéro)
if ($id !== null && $id !== false && $id >= 0) {
    // Récupérer la quantité à supprimer du panier
    $total_Supprimer = isset($_SESSION['panier'][2][$id][1]) ? $_SESSION['panier'][2][$id][1] : 0;

    // Réduire le total du panier par le montant à supprimer
    $_SESSION['panier'][1] -= $total_Supprimer;

    // Supprimer l'article du panier en utilisant son ID
    unset($_SESSION['panier'][2][$id]);

    // Mettre à jour le nombre total d'articles dans le panier
    $_SESSION['Nbt'] = is_array($_SESSION["panier"][2]) ? count($_SESSION["panier"][2]) : 0;

    // Rediriger l'utilisateur vers la page du panier
    header("Location: ../panier/panier.php");
    exit(); // Assurer que le script se termine après la redirection
} else {
    // Gérer le cas où l'identifiant n'est pas valide
    echo "Identifiant d'article invalide.";
    // Vous pouvez rediriger l'utilisateur vers une page d'erreur ou faire autre chose en cas d'identifiant invalide.
}







//$idClient=$_SESSION['id'];
//
//include '../../include/functionsProductCate.php';
//
//// Connexion à la base de données
//$conn = connectToDatabase();
//
//// Vérification si la méthode de requête est POST
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    try {
//        // Vérification si les champs sont définis et non vides
//        if (!empty($_POST["produit"]) && !empty($_POST["qt"])) {
//            $id_produit = $_POST['produit'];
//            $qt = $_POST['qt'];
//            $productById = getProductById($id_produit);
//            $marque=$productById['marque'];
//            $image=$productById['image'];
//            $libelle=$productById['libelle'];
//            // Calcul du total
//            $total = $qt * $productById['prix'];
//
//            //creation de panier 0 est un total par defaut
//            if (!isset($_SESSION["panier"])) {
//                $_SESSION['panier'] = array($idClient, 0, array());
//            }
//            //si panier exist alor updat de total
//            $_SESSION['panier'][1] += $total;
//            $_SESSION['panier'][2][] = array($qt, $total, $id_produit,$marque,$image,$productById['libelle']);
//
//            $_SESSION['Nbt']=count($_SESSION["panier"][2]);
//
//            header('location:../panier/panier.php');
//
//
//            // Préparation de la requête SQL avec des paramètres nommés Pour panier
//            $sql_insert = "INSERT INTO panier (idClient , total) VALUES (:idClient , :total)";
//            $stmt_insert = $conn->prepare($sql_insert);
//            $stmt_insert->bindParam(':idClient', $idClient);
//            $stmt_insert->bindParam(':total', $total);
//
//
//
//            // Exécution de la requête
//            if ($stmt_insert->execute()) {
//                $id_panier=$conn->lastInsertId();
//                // Préparation de la requête SQL avec des paramètres nommés
//                $sql_insert = "INSERT INTO commands (produit, total, id_panier, quantite) VALUES (:produit, :total, :id_panier, :quantite)";
//                $stmt_insert = $conn->prepare($sql_insert);
//                $stmt_insert->bindParam(':produit', $id_produit);
//                $stmt_insert->bindParam(':total', $total);
//                $stmt_insert->bindParam(':quantite', $qt);
//                $stmt_insert->bindParam(':id_panier', $id_panier);
//                $stmt_insert->execute();
//                // Redirection vers la page index
//                //header('location:listeCategorise.php?ajout=ok');
//                exit; // Arrête l'exécution du script après la redirection
//            } else {
//                echo "Erreur lors de l'ajout de la commande: " . $stmt_insert->errorInfo()[2];
//            }
//        } else {
//            echo "Tous les champs sont obligatoires.";
//        }
//    } catch (PDOException $e) {
//        echo "Erreur: " . $e->getMessage();
//    } finally {
//        // Fermeture du statement et de la connexion à la base de données
//        if (isset($stmt_insert)) {
//            $stmt_insert->closeCursor();
//        }
//        if (isset($conn)) {
//            $conn = null;
//        }
//    }
//} else {
//    echo "Erreur: méthode de requête incorrecte.";
//}

?>
