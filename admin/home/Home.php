<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['user_type'] !== "admin"){
    header('Location: ../../login.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
}

include '../../include/functionHome.php';
$nbrAcheteurs=countUsers();
$nbrProduits=countProduits();
$nbrVentes=countCommands();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éclat & Vitalité (Admin)</title>
    <link rel="stylesheet" href="stylesHome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<!-- header -->
<header>
    <div class="container d-flex justify-content-between align-items-center">
        <div class="" style="margin-right: 1px;">
            <div class="logo-wrapper">
                <h6 style="font-size: 22px; color: #333;">Éclat & Vitalité (Admin)</h6>
            </div>
        </div>
        <div class="container">
            <nav class="p-1">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active custom" href="Home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../profile/profile.php">Profil</a>
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
<!-- Barre de navigation -->
<header class="ous">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Bouton d'ouverture du tiroir -->
        <span style="font-size:30px;cursor:pointer" onclick="openDrawer()">&#9776;</span>
        <!-- Tiroir (drawer) -->
        <div class="drawer" id="drawer">
            <a href="javascript:void(0)" class="close-btn" onclick="closeDrawer()">&times;</a>
            <nav>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active custom" href="Home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../profile/profile.php">Profil</a>
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
            <h6 style="font-size: 22px; color: #333;">Éclat & Vitalité (Admin)</h6>
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
<div style="width: 1px; height: 78px; background-color: #ffffff;"></div>
<!-- main contenu -->
<div class="main-content">
    <main>
        <div class="container">
            <?php
            // Vérifiez l'existence des données de session avant de les afficher
            if(isset($_SESSION['email'])) {
            echo "<div>";
            echo "<h2 class='title'>Regardez les chiffres</h2>";
            echo "</div>";
            ?>
        </div>
        <div class="container">
            <style>
                @media only screen and (max-width: 1024px) {
                    .siw {
                        overflow-x: auto;
                    }
                }
            </style>
            <?php
            echo '<div class="siw">';
            ?>
            <div class="zina">
                <section class="cards" id="services">

                    <!-- Contenu des cartes -->
                    <div class="content">

                        <!-- Première carte -->
                        <div class="carde">
                            <div class="icon">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                            </div>
                            <div class="info">
                                <h3>Produits</h3>
                                <p>Le nombre Total des Produits</p>
                                <button class="nub" ><a href="../produits/listeProduits.php"><?php echo $nbrProduits;?></a></button>
                            </div>
                        </div>

                        <!-- Deuxième carte -->
                        <div class="carde">
                            <div class="icon">
                                <i class="fa fa-users" aria-hidden="true"></i>
                            </div>
                            <div class="info">
                                <h3>Acheteurs</h3>
                                <p>Le nombre total des Acheteurs</p>
                                <button class="nub" ><a href="../users/listeCustomers.php"><?php echo $nbrAcheteurs;?></a></button>
                            </div>
                        </div>

                        <!-- Troisième carte -->
                        <div class="carde">
                            <div class="icon">
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                            </div>
                            <div class="info">
                                <h3>Ventes</h3>
                                <p>Le nombre total des Ventes</p>
                                <button class="nub" ><a href="../vente/listeVentes.php"><?php echo $nbrVentes;?></a></button>
                            </div>
                        </div>

                    </div>

                </section>

            </div>
            <?php
            echo '</div>';
            }
            ?>
        </div>
        <div style="width: 1px; height: 17px; background-color: #ffffff;"></div>
    </main>
</div>

<!-- Footer -->
<?php include '../../include/footer.php'?>
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
