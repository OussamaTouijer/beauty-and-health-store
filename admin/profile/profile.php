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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<!-- header-->
<header >
    <div class="container d-flex justify-content-between align-items-center">
        <div class="" style="margin-right: 1px; ">
            <div class="logo-wrapper">
                <h6 style=" font-size: 22px; color: #333;">Éclat & Vitalité (Admin)</h6>
            </div>
        </div>
        <div class="container">
            <nav class="p-1">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link custom" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active custom" href="profile.php">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../categorise/listeCategorise.php">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  custom" href="../produits/listeProduits.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../users/listeCustomers.php">Clientes</a>
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


<!-- --------------------------------------------------------------------- -->

<!-- Barre de navigation -->
<header class="ous" >
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Bouton d'ouverture du tiroir -->
        <span style="font-size:30px;cursor:pointer" onclick="openDrawer()">&#9776;</span>

        <!-- Tiroir (drawer) -->
        <div class="drawer" id="drawer">
            <a href="javascript:void(0)" class="close-btn" onclick="closeDrawer()">&times;</a>
            <nav>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link custom" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active custom" href="profile.php">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../categorise/listeCategorise.php">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  custom" href="../produits/listeProduits.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../users/listeCustomers.php">Clientes</a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Autres éléments de la barre de navigation -->
        <div class="logo-wrapper">
            <h6 style=" font-size: 22px; color: #333;">Éclat & Vitalité (Admin)</h6>
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


<div style=" width: 1px; height: 120px; background-color: #ffffff;"></div>
<!-- main contenu-->
<div class="main-content">
    <main>
        <div class="container">
            <?php
            if(isset($_SESSION['email'])) {
                echo "<div class='title-and-button'>";
                echo "<h2 class='title'>Bienvenue  Administrateur</h2>";
                echo "<p class='user-type'><i class='fas' style='color: #1e1e1e' > Type d'utilisateur : </i> " . htmlspecialchars($_SESSION['user_type']) . "</p>";
                echo "</div>";
            } else {
                echo "<p class='session-error'>Données de session introuvables.</p>";
            }
            ?>
        </div>
        <div class="container user-details">
            <?php
            if(isset($_SESSION['email'])) {
                print
                    "<p><i class='fas fa-id-card' > ID : </i> " .' ' . htmlspecialchars($_SESSION['id']) . "</p>" .
                    "<p><i class='fas fa-user'> Prenom & Nom : </i>  " .' ' . htmlspecialchars($_SESSION['prenom']) .' '.htmlspecialchars($_SESSION['nom']) . "</p>" .
                    "<p><i class='fas fa-envelope'> Email : </i>  " .' ' . htmlspecialchars($_SESSION['email']) . "</p>" .
                    "<p><i class='fas fa-map-marker-alt'> Adresse : </i>".' ' . htmlspecialchars($_SESSION['address']) . "</p>" .
                    "<p><i class='fas fa-city'> Ville : </i>" .' ' . htmlspecialchars($_SESSION['ville']) . "</p>";
            }
            ?>

        </div>
    </main>
</div>
</body>
<script>
    function openDrawer() {
        document.getElementById("drawer").style.width = "250px";
    }

    function closeDrawer() {
        document.getElementById("drawer").style.width = "0";
    }
</script>

</html>
