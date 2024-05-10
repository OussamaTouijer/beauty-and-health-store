<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email']) || $_SESSION['user_type'] != "client") {
    header("Location: ../../login.php");
    exit(); // Assurez-vous de sortir après avoir redirigé
}

// Inclure vos fonctions de manipulation de la base de données ici
include '../../include/functionsProductCate.php';

// Récupération des catégories et des produits
$categories = getAllCategories();

$idCt = null;
$producte = null;

if(isset($_GET['id'])){
    $producte = getProductById($_GET['id']);
    foreach($categories as $c){
        if($c['id'] == $producte['id_categorie']) {
            $idCt = $c;
            break;
        }
    }
}

if (isset($_SESSION["panier"])) {
    if (count($_SESSION["panier"][2])>0) {
        $commandes=$_SESSION["panier"][2];
    }
}



?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="panierCss.css">
    <title>Éclat & Vitalité</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
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
            $nombre_articles_panier = isset($_SESSION['Nbt']) ? intval($_SESSION['Nbt']) : 0;            ?>


            <div class="user-wrapper">
                <a href="../panier/panier.php">
                    <i class="fas fa-shopping-cart">Panier</i>
                </a>
                <!-- Affiche le nombre d'articles dans le panier -->
                <span style="color: red">(<?php echo $nombre_articles_panier; ?>)</span>

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
            $nombre_articles_panier = isset($_SESSION['Nbt']) ? intval($_SESSION['Nbt']) : 0;            ?>


            <div class="user-wrapper">
                <a href="../panier/panier.php">
                    <i class="fas fa-shopping-cart">Panier</i>
                </a>
                <!-- Affiche le nombre d'articles dans le panier -->
                <span style="color: red">(<?php echo $nombre_articles_panier; ?>)</span>

                <a class="logout-btn" href="../../deconnexion.php">Déconnexion</a>
            </div>
            <?php
        }
        ?>
    </div>
</header>



<div class="container mt-3" style="     width: 1px;
    height: 96px;
    background-color: #f4f4f4;">

</div>


<mainb style="background-color: #f4f4f4">
    <div class="container d-flex justify-content-center align-items-center" style="background-color: #f4f4f4">

        <!-- Votre en-tête ici -->

        <!-- Contenu principal -->
        <div class="container-fluid py-1 mt-1" style="background-color: #eeeeee;border-radius:25px;">
            <h2 class="title">Votre Panier</h2>
            <table class="tablee">
                <thead>
                <tr>
                    <th>ID Produit</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($commandes as $product): ?>
                    <tr>
                        <td><?php echo $product[2]; ?></td>
                        <td><?php echo $product['0']; ?></td>
                        <td><?php echo $product['1']; ?> MAD</td>

                        <!--                        <td>-->
<!--                            <form method="post" action="panier.php">-->
<!--                                <input type="number" name="quantity[--><?php //echo $product['id']; ?><!--]"-->
<!--                                       value="--><?php //echo $product['quantite']; ?><!--" min="1" class="edit-button">-->
<!--                                <input type="submit" name="update_cart" value="Mettre à jour" class="edit-button">-->
<!--                            </form>-->
<!--                        </td>-->
<!--                        <td>--><?php //echo $product['prix'] * $product['quantite']; ?><!-- MAD</td>-->
                        <td><a href="panier.php?action=delete&id=<?php echo $product['2']; ?>" class="delete-button">Supprimer</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3">Total:</td>
<!--                    <td>--><?php //echo $total_panier; ?><!-- MAD</td>-->
                    <td></td>
                </tr>
                </tfoot>
            </table>
            <a href="panier.php?action=finaliser" class="btn btn-primary mt-1">Passer à la caisse</a>
            <a href="panier.php?action=consulter" class="btn btn-primary mt-1">Consulter le contenu</a>
            <a href="../home/home.php" class="btn btn-primary mt-1">contenu acheter</a>
        </div>

        <!-- Votre pied de page ici -->

    </div>
</mainb>


<?php include '../../include/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
