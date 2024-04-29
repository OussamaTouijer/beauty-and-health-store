<?php
include '../../include/functionsProductCate.php';

// Récupération des catégories et des produits
$categories = getAllCategories();

$idCt = null;
$product = null;

if(isset($_GET['id'])){
    $product = getProductById($_GET['id']);
    foreach($categories as $c){
        if($c['id'] == $product['id_categorie']) {
            $idCt = $c;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="produitCss.css">
    <title>Éclat & Vitalité</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
</head>
<body>

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
                        <a class="nav-link  custom" href="../home/home.php">Home</a>
                    </li>

                    <?php if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client"): ?>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../profile/profile.php?id=<?php $id=$_SESSION['id']; echo $id;?>">Profil</a>                        </li>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link  custom" href="../../login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../../registre.php">S'inscrire</a>
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
            $nombre_articles_panier =0 ;/* code pour récupérer le nombre d'articles dans le panier */
            ?>

            <div class="user-wrapper">
                <a href="../panier/panier.php">
                    <i class="fas fa-shopping-cart">Panier</i>
                </a>
                <!-- Affiche le nombre d'articles dans le panier -->
                <span>(<?php echo $nombre_articles_panier; ?>)</span>

                <a class="logout-btn" href="../../deconnexion.php">Déconnexion</a>
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
                        <a class="nav-link  custom" href="../home/home.php">Home</a>
                    </li>

                    <?php if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client"): ?>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../profile/profile.php?id=<?php $id=$_SESSION['id']; echo $id;?>">Profil</a>                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link  custom" href="../../login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../../registre.php">S'inscrire</a>
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
            $nombre_articles_panier =0 ;/* code pour récupérer le nombre d'articles dans le panier */
            ?>

            <div class="user-wrapper">
                <a href="../panier/panier.php">
                    <i class="fas fa-shopping-cart">Panier</i>
                </a>
                <!-- Affiche le nombre d'articles dans le panier -->
                <span>(<?php echo $nombre_articles_panier; ?>)</span>

                <a class="logout-btn" href="../../deconnexion.php">Déconnexion</a>
            </div>
            <?php
        }
        ?>
    </div>
</header>



<div class="container mt-3" style="     width: 1px;
    height: 20px;
    background-color: #ffffff;">

</div>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="card col-md-6 p-5">
            <?php if($product): ?>
                <img src="../../images/<?php echo $product['image']; ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product['libelle']; ?></h5>
                    <p class="card-text"><?php echo $product['description']; ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?php echo $idCt['libelle']; ?></li>
                    <li class="list-group-item"><?php echo $product['prix'].' DH'; ?></li>
                </ul>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Produit non trouvé.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../../include/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
