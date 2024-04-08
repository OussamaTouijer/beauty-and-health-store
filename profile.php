<?php
session_start();

if (!isset($_SESSION['nom'])){
    header('location :login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <title>Éclat & Vitalité</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php include 'include/header.php'?>
<?php


// Vérifie si l'utilisateur est connecté en vérifiant si certaines variables de session existent
//if(isset($_SESSION['email'], $_SESSION['prenom'], $_SESSION['nom'], $_SESSION['user_type'], $_SESSION['id'], $_SESSION['address'], $_SESSION['ville'])) {
    // Affiche les informations de l'utilisateur
    echo "<p>Email: " . $_SESSION['email'] . "</p>";
    echo "<p>Prénom: " . $_SESSION['prenom'] . "</p>";
    echo "<p>Nom: " . $_SESSION['nom'] . "</p>";
    echo "<p>Type d'utilisateur: " . $_SESSION['user_type'] . "</p>";
    echo "<p>ID: " . $_SESSION['id'] . "</p>";
    echo "<p>Adresse: " . $_SESSION['address'] . "</p>";
    echo "<p>Ville: " . $_SESSION['ville'] . "</p>";
//} else {
    // Si les variables de session ne sont pas définies, cela signifie que l'utilisateur n'est pas connecté
//    echo "<p>Vous n'êtes pas connecté.</p>";
//}
?>


<?php include 'include/footer.php'?>
</body>
</html>
