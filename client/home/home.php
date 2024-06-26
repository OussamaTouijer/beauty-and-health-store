<?php
session_start();
include '../../include/functionsProductCate.php';

// Récupération des catégories
$categories = getAllCategories();

// Initialisation du tableau de produits
$products = [];

// Filtrage des produits
$priceRange = isset($_POST['price_range']) ? $_POST['price_range'] : null;
$color = isset($_POST['Categories-1']) ? $_POST['Categories-1'] : null;

if (!empty($_POST['search'])) {
    $products = searchProducts($_POST['search']);
} else {
    // Aucune recherche, récupérer tous les produits
    $products = getAllProducts();
}

// Filtrage par prix
if (!empty($priceRange)) {
    // Appliquer la logique de filtrage par prix
    // Par exemple, sélectionner les produits dont le prix est compris dans la plage spécifiée
    $filteredProducts = [];
    foreach ($products as $product) {
        // Assurez-vous que $product['prix'] est numérique avant de comparer
        if (isset($product['prix']) && is_numeric($product['prix']) && $product['prix'] <= $priceRange) {
            $filteredProducts[] = $product;
        }
    }
} else {
    // Aucun filtre de prix spécifié, donc tous les produits sont éligibles
    $filteredProducts = $products;
}

// Filtrage par couleur
if (!empty($color)) {
    // Appliquer la logique de filtrage par couleur
    // Par exemple, sélectionner les produits ayant la couleur spécifiée
    $filteredProductsByColor = [];
    foreach ($filteredProducts as $product) {
        // Assurez-vous que $product['couleur'] est bien défini avant de comparer
        if (isset($product['color']) && $product['color'] == $color) {
            $filteredProductsByColor[] = $product;
        }
    }
    // Remplacer les produits par les produits filtrés par couleur
    $products = $filteredProductsByColor;
} else {
    // Aucun filtre de couleur spécifié, donc tous les produits filtrés par prix sont éligibles
    $products = $filteredProducts;
}


// Tri des produits par prix
if (isset($_POST['descending'])) {
    // Trier les produits par prix en ordre décroissant
    usort($products, function ($a, $b) {
        return $b['prix'] <=> $a['prix'];
    });
} elseif (isset($_POST['ascending'])) {
    // Trier les produits par prix en ordre croissant
    usort($products, function ($a, $b) {
        return $a['prix'] <=> $b['prix'];
    });
}

// Pagination
$categoriesPerPage = 40;
$totalProducts = count($products);
$totalPages = ceil($totalProducts / $categoriesPerPage);
$page = isset($_GET['page']) ? max(1, min($_GET['page'], $totalPages)) : 1;
$startIndex = ($page - 1) * $categoriesPerPage;
$productsToShow = array_slice($products, $startIndex, $categoriesPerPage);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="homeCss.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Éclat & Vitalité</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<!-- header-->
<header>
    <div class="container d-flex justify-content-between align-items-center">

        <div style="margin-right: 15px;">
            <div class="logo-wrapper">
                <a href="../../index.php" style="text-align: center; text-decoration: none; color: #333; font-size: 22px; margin-top: 40px;"><h4 style=" margin-top: 10px;">Éclat & Vitalité</h4></a>
            </div>
        </div>

        <div class="container">

            <nav class="p-1">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active custom" href="home.php">Home</a>
                    </li>

                    <?php if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client"): ?>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../profile/profile.php">Profil</a>
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
       <div class="container">
            <form class="d-flex" role="search" action="index.php" method="POST">
                <input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Rechercher" name="search"/>
                <button class="btn btn-outline-success" type="submit">Rechercher</button>
            </form>
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
                        <a class="nav-link active custom" href="home.php">Home</a>
                    </li>

                    <?php if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client"): ?>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../profile/profile.php">Profil</a>                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link  custom" href="../../login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../../registre.php">S'inscrire</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../../registre.php">S'inscrire</a>
                        </li>
                    <?php endif; ?>
                        <li class="nav-item">
                            <form class="d-flex" role="search" action="index.php" method="POST">
                                <input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Rechercher" name="search"/>
                                <button class="btn btn-outline-success" type="submit">Rechercher</button>
                            </form>
                        </li>

                </ul>
            </nav>
        </div>

        <!-- Autres éléments de la barre de navigation -->
        <div class="logo-wrapper">
            <a href="../../index.php" style="text-align: center; text-decoration: none; color: #333; font-size: 22px; margin-top: 40px;"><h4 style=" margin-top: 10px;">Éclat & Vitalité</h4></a>
        </div>


        <?php
        if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client") {
            // Suppose que vous avez un moyen de récupérer le nombre d'articles dans le panier (par exemple depuis une base de données)
            // Récupérer le nombre d'articles dans le panier depuis $_GET['NobP']
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
    height: 20px;
    background-color: #ffffff;">

</div>


<!-- Début Boutique de Fruits-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Boutique Éclat & Vitalité</h1>

        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">

                <div class="row g-4">

                    <div class="col-lg-3">
                        <div class="row g-4">

                            <div class="col-lg-12">

                                <form method="post" action="home.php">
                                    <h4>Trier par prix</h4>
                                    <button type="submit" name="descending" class="btn btn-dark mt-1">
                                        <i class="fas fa-sort-amount-down"></i> Décroissant
                                    </button>
                                    <button type="submit" name="ascending" class="btn btn-dark mt-1">
                                        <i class="fas fa-sort-amount-up"></i> Croissant
                                    </button>
                                </form>


                                <!-- Catégories -->
                                <div class="mb-3 mt-3">
                                    <h4>Catégories</h4>
                                    <ul class="list-unstyled produit-categorie">
                                        <li>
                                            <?php
                                            foreach($categories as $Cat) {
                                                $count = 0;
                                                foreach($products as $product) {
                                                    if ($product['id_categorie'] == $Cat['id']) {
                                                        $count++;
                                                    }
                                                }
                                                echo '<div class="d-flex justify-content-between fruite-name">
          <a href="../categories/categories.php?idCa=' . $Cat['id'] . '"><i class="fas me-2"></i><i style="color: dimgrey">' . $Cat['libelle'] . '</i></a>
          <span>(' . $count . ')</span>
          </div>';
                                            }
                                            ?>



                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <!-- Prix -->
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4 class="mb-2">Prix</h4>
                                    <form action="home.php" method="POST">
                                        <input type="range" class="form-range w-100" id="priceRange" name="price_range" min="0" max="500" value="<?php echo isset($_POST['price_range']) ? $_POST['price_range'] : '6'; ?>" oninput="amount.value=priceRange.value">
                                        <output id="amount" name="amount" min-value="6" max-value="500" for="priceRange"><?php echo isset($_POST['price_range']) ? $_POST['price_range'] : '6'; ?></output><span> DH</span>
                                        <!-- <button type="submit" class="btn btn-primary mt-2">Appliquer</button>
                                         </form>-->
                                </div>
                            </div>
                            <!-- Couleur -->
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Couleur</h4>
                                    <!-- Insérez ici vos boutons radio pour les couleurs -->
                                    <!-- Assurez-vous que chaque bouton a un attribut 'name'
                                    <form action="home.php" method="POST">-->
                                        <!-- Insérez vos boutons radio ici -->
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-1" name="Categories-1" value="Jaune">
                                            <label for="Categories-1">Jaune</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-2" name="Categories-1" value="Bleu">
                                            <label for="Categories-2">Bleu</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rouge">
                                            <label for="Categories-3">Rouge</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Marron">
                                            <label for="Categories-3">Marron</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Violet">
                                            <label for="Categories-3">Violet</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Blanc">
                                            <label for="Categories-3">Blanc</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rose">
                                            <label for="Categories-3">Rose</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Beige">
                                            <label for="Categories-3">Beige</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Vert">
                                            <label for="Categories-3">Vert</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Green">
                                            <label for="Categories-3">Green</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Noir">
                                            <label for="Categories-3">Noir</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">Appliquer</button>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row g-4 justify-content-center">
                            <?php foreach($productsToShow as $product): ?>
                                <div class="col-md-6 col-lg-6 col-xl-4">
                                    <div class="rounded position-relative fruite-item">
                                        <div class="fruite-img">
                                            <img src="../../images/<?php echo $product['image']; ?>" class="img-fluid rounded-top image-style" width="500" height="500" alt="">
                                        </div>
                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                            <?php foreach($categories as $cat): ?>
                                                <?php if($product['id_categorie']==$cat['id']): ?>
                                                    <?php echo "{$cat['libelle']}"; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                            <h4><?php echo $product['marque']; ?></h4>

                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                <p class="text-dark fs-5 fw-bold mb-0"><?php echo $product['prix']." DH"; ?></p>
                                                <a href="../produit/produit.php?id=<?php echo $product['id']; ?>" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Afficher Produit en détail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <div class="col-12">
                                <div class="pagination d-flex justify-content-center mt-5">
                                    <a href="<?php echo ($page > 1) ? 'home.php?page='.($page-1) : ''; ?>" class="rounded"><button class="btn btn-light m-1">&laquo </button></a>
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <a href="home.php?page=<?php echo $i; ?>" class="<?php echo ($i === $page) ? 'active ' : ''; ?>rounded"><button class="btn btn-primary m-1"><?php echo $i; ?></button></a>
                                    <?php endfor; ?>
                                    <a href="<?php echo ($page < $totalPages) ? 'home.php?page='.($page+1) : ''; ?>" class="rounded"><button class="btn btn-light m-1">&raquo </button> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Fin Boutique de Produits-->

<?php include '../../include/footer.php'; ?>
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
