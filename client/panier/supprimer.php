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
    if($_SESSION['panier'][1]!==0)
    $_SESSION['panier'][1] -= $total_Supprimer;
    else $_SESSION['panier'][1]=0;

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







?>
