<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email']) || $_SESSION['user_type'] != "client") {
    header("Location: ../../login.php");
    exit(); // Assurez-vous de sortir après avoir redirigé
}

$idClient=$_SESSION['id'];

include '../../include/functionsProductCate.php';

// Connexion à la base de données
$conn = connectToDatabase();

// Vérification si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Vérification si les champs sont définis et non vides
        if (!empty($_POST["produit"]) && !empty($_POST["qt"])) {
            $id_produit = $_POST['produit'];
            $qt = $_POST['qt'];
            $productById = getProductById($id_produit);
            $marque=$productById['marque'];
            $image=$productById['image'];
            $libelle=$productById['libelle'];
            // Calcul du total
            $total = $qt * $productById['prix'];


            //creation de panier 0 est un total par defaut
            if (!isset($_SESSION["panier"])) {
                $_SESSION['panier'] = array($idClient, 0, array());
            }

            //si panier exist alor updat de total
            $_SESSION['panier'][1] += $total;
            $_SESSION['panier'][2][] = array($qt, $total, $id_produit,$marque,$image,$productById['libelle']);

            $_SESSION['Nbt'] = is_array($_SESSION["panier"][2]) ? count($_SESSION["panier"][2]) : 0;

            header('location:../panier/panier.php');




        } else {
            echo "Erreur: méthode de requête incorrecte.";
        }}

?>
