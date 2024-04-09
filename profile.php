<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email'])){
    header('location: login.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
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
<div class="container">
    <?php
    // Vérifiez l'existence des données de session avant de les afficher
    if(isset($_SESSION['email'])) {
        echo "<p>Email: " . htmlspecialchars($_SESSION['email']) . "</p>";
        echo "<p>Prénom: " . htmlspecialchars($_SESSION['prenom']) . "</p>";
        echo "<p>Nom: " . htmlspecialchars($_SESSION['nom']) . "</p>";
        echo "<p>Type d'utilisateur: " . htmlspecialchars($_SESSION['user_type']) . "</p>";
        echo "<p>ID: " . htmlspecialchars($_SESSION['id']) . "</p>";
        echo "<p>Adresse: " . htmlspecialchars($_SESSION['address']) . "</p>";
        echo "<p>Ville: " . htmlspecialchars($_SESSION['ville']) . "</p>";
    } else {
        echo "<p>Session data not found.</p>";
    }
    ?>
</div>

<?php include 'include/footer.php'?>
</body>
</html>
