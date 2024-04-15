<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email'])){
    header('Location: ../login.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éclat & Vitalité (Admin)</title>
    <link rel="stylesheet" href="stylesProfile.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>


<!-- header-->
<header style="position: fixed; top: 0; width: 100%; background-color: #f8f9fa; padding: 1px 2px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); z-index: 100;">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="" style="margin-right: 1px; ">
            <div class="logo-wrapper">
                <h6 style=" font-size: 22px; color: #333;">Éclat & Vitalité (Admin)</h6>
            </div></div>

        <div class="container">

            <nav class="p-1">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link custom" href="#">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active custom" href="profile.php">
                            Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../categorise/listeCategorise.php">
                            Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  custom" href="../produits/listeProduits.php">
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="#">
                            Customers
                        </a>
                    </li>
                </ul>
            </nav>

        </div>

        <div class="user-wrapper">
            <a href="../profile.php">
                <img src="../userImages/user.jpg" alt="user" class="user-image">
            </a>
            <span class="username"><?php echo htmlspecialchars($_SESSION['prenom'].' ' .$_SESSION['nom']); ?></span>
            <?php
            // Vérifiez l'existence des données de session avant de les afficher
            if(isset($_SESSION['email'])) {
                echo '<a class="logout-btn" href="../deconnexion.php">Déconnexion</a>';
            }
            ?>
        </div>

    </div>
</header>


<div style=" width: 1px;
             height: 68px;
             background-color: #ffffff;">
</div>

<!-- main contenu-->
<div class="main-content">

    <main>
        <div class="container">

            <?php
            // Vérifiez l'existence des données de session avant de les afficher
            if(isset($_SESSION['email'])) {

            echo "<div class='title-and-button'>";
            echo "<h2 class='title' >Bienvenue"." Administrateur </h2>";
            echo "<p>Type d'utilisateur: " . htmlspecialchars($_SESSION['user_type']) . "</p>";

            echo "</div>";
            } else {
                echo "<p>Session data not found.</p>";
            }

            ?>
        </div>


        <div class="container">

                <?php

                echo "<p>Email: " . htmlspecialchars($_SESSION['email']) . "</p>";
                echo "<p>Prénom: " . htmlspecialchars($_SESSION['prenom']) . "</p>";
                echo "<p>Nom: " . htmlspecialchars($_SESSION['nom']) . "</p>";
                echo "<p>ID: " . htmlspecialchars($_SESSION['id']) . "</p>";
                echo "<p>Adresse: " . htmlspecialchars($_SESSION['address']) . "</p>";
                echo "<p>Ville: " . htmlspecialchars($_SESSION['ville']) . "</p>";

                ?>

                <div style=" width: 1px;
                       height: 14px;
                       background-color: #ffffff;">
                </div>



        </div>

    </main>

</div>


</body>
</html>
