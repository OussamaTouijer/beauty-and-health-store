<?php
session_start();

//// Vérification de l'authentification
//if (!isset($_SESSION['email']) || $_SESSION['user_type'] != "client") {
//    header("Location: login.php");
//    exit(); // Assurez-vous de sortir après avoir redirigé
//}

include 'include/functionHome.php';
$nbrVentes=0;
if (isset($_SESSION['id'])){
$id = $_SESSION['id'];
$nbrVentes = countPanier($id);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éclat & Vitalité</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body style="background-color: #f4f4f4">

<!-- header-->

<header>
    <div class="container d-flex justify-content-between align-items-center">

        <div style="margin-right: 15px;">
            <!-- Autres éléments de la barre de navigation -->
            <div class="logo-wrapper">
                <a href="index.php" style="text-align: center; text-decoration: none; color: #333; font-size: 22px;"><h4>Éclat & Vitalité</h4></a>
            </div>

        </div>

        <div class="container">

            <nav class="p-1">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link  custom" href="client/home/home.php">Home</a>
                    </li>

                    <?php if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client"): ?>
                        <li class="nav-item">
                            <a class="nav-link custom" href="client/profile/profile.php">Profil</a>                        </li>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link  custom" href="login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom" href="registre.php">S'inscrire</a>
                        </li>
                    <?php endif; ?>


                </ul>
            </nav>

        </div>
        <!-- <div class="container">
             <form class="d-flex" role="search" action="index.php" method="POST">
                 <input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Rechercher" name="search"/>
                 <button class="btn btn-outline-success" type="submit">Rechercher</button>
             </form>
         </div> -->
        <?php
        if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client") {
            // Suppose que vous avez un moyen de récupérer le nombre d'articles dans le panier (par exemple depuis une base de données)
            $nombre_articles_panier = isset($_SESSION['Nbt']) ? intval($_SESSION['Nbt']) : 0;            ?>


            <div class="user-wrapper">
                <a href="client/panier/panier.php">
                    <i class="fas fa-shopping-cart">Panier</i>
                </a>
                <!-- Affiche le nombre d'articles dans le panier -->
                <span style="color: red">(<?php echo $nombre_articles_panier; ?>)</span>

                <a class="logout-btn" href="deconnexion.php">Déconnexion</a>
            </div>
            <?php
        }
        ?>


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
            <nav class="p-1">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link  custom" href="client/home/home.php">Home</a>
                    </li>

                    <?php if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client"): ?>
                        <li class="nav-item">
                            <a class="nav-link custom" href="client/profile/profile.php">Profil</a>                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link  custom" href="login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom" href="registre.php">S'inscrire</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>

        <!-- Autres éléments de la barre de navigation -->
        <div class="logo-wrapper">
            <a href="index.php" style="text-align: center; text-decoration: none; color: #333; font-size: 22px;"><h4>Éclat & Vitalité</h4></a>
        </div>


        <?php
        if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client") {
            // Suppose que vous avez un moyen de récupérer le nombre d'articles dans le panier (par exemple depuis une base de données)
            $nombre_articles_panier = isset($_SESSION['Nbt']) ? intval($_SESSION['Nbt']) : 0;            ?>


            <div class="user-wrapper">
                <a href="client/panier/panier.php">
                    <i class="fas fa-shopping-cart">Panier</i>
                </a>
                <!-- Affiche le nombre d'articles dans le panier -->
                <span style="color: red">(<?php echo $nombre_articles_panier; ?>)</span>

                <a class="logout-btn" href="deconnexion.php">Déconnexion</a>
            </div>
            <?php
        }
        ?>
    </div>
</header>

<div class="container mt-3" style="width: 1px; height: 95px; background-color: #f4f4f4;"></div>

<main style="background-color: #f4f4f4">
    <div class="container d-flex justify-content-center align-items-center" style="background-color: #f4f4f4">
        <div class="container" style="background-color: #eeeeee;border-radius:25px; ">
            <?php
            // Vérifiez l'existence des données de session avant de les afficher
            if (isset($_SESSION['email'])) {
                echo "<div>";
//                echo "<h2 class='title'>Bienvenue</h2>" ;
                echo "<h2 class='title' style='color: red'>". $_SESSION['nom'] . " " . $_SESSION['prenom'] . "</h2>" ;
                echo "</div>";
                echo "<div class='container'>
            <style>
                @media only screen and (max-width: 1024px) {
                    .siw {
                        overflow-x: auto;
                    }
                }
            </style>";
                echo '<div class="siw">';
                ?>
                <div class="zina">
                    <section class="cards" id="services">
                        <!-- Contenu des cartes -->
                        <div class="content">
                            <!-- 1 carte -->
                            <div class="carde">
                                <div class="icon">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                </div>
                                <div class="info">
                                    <h3>Achats</h3>
                                    <p>Le nombre total de vos acheté</p>
                                    <button class="nub"><a href="client/panier/listCommands.php"><?php echo $nbrVentes; ?></a></button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <?php
                echo '</div>';
                echo '</div>';
            }else{
                echo "<div class=\"container d-flex justify-content-center\" >";
                echo "<div class='py-1 mt-4' style='background-color: #eeeeee; border-radius: 25px;'>";
                echo "<h2 class='title'>Éclat &amp; Vitalité</h2>";
                echo "<p style='text-align: center; font-size: 24px; color: #333333;'>Éclat &amp; Vitalité propose une gamme de produits de beauté et de santé soigneusement sélectionnés pour révéler votre beauté naturelle et renforcer votre bien-être. La composition typographique est restée essentiellement inchangée.</p>";
                echo "<div style='text-align: center;'><a href='client/home/home.php'><button class='btn btn-primary'>Home</button></a></div>";
                echo "</div>";
                echo "</div>";


            }
            ?>
        </div>

        <div style="width: 1px; height: 17px; background-color: #ffffff;"></div>
    </div>
</main>

<?php include 'include/footer.php'; ?>

<script>
    function openDrawer() {
        document.getElementById("drawer").style.width = "250px";
    }

    function closeDrawer() {
        document.getElementById("drawer").style.width = "0";
    }
</script>
</body>

</html>
