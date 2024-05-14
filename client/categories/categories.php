<?php
session_start();
include '../../include/functionsProductCate.php';

// Récupération des catégories
$categories = getAllCategories();

// Initialisation du tableau de produits
$products = [];

// Vérifier si une recherche est effectuée
if (!empty($_POST['search'])) {
    $products = searchProducts($_POST['search']);
} elseif(isset($_GET['idCa'])) {
    $products = getProductByIdC($_GET['idCa']);
} else {
    // Aucune recherche, récupérer tous les produits
    //$products = getAllProducts();
}

// Vérifier si un tri par popularité est demandé
if (isset($_POST['sort']) && $_POST['sort'] == 'popularite') {
    // Si oui, trier les produits par popularité
    $products = sortByPopularity($products);
} else {
    // Sinon, aucun tri spécifié, utiliser un tri par défaut
    // Pour l'instant, aucune logique de tri par défaut n'a été spécifiée dans cet exemple
    // Vous pouvez remplacer cette ligne par une fonction de tri par défaut si nécessaire
    // Par exemple, $products = sortDefault($products);
}

// Pagination
$categoriesPerPage = 12;
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
    <link rel="stylesheet" href="categoriesCss.css">
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

<header>
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <div class="logo-wrapper">
                <a href="../../index.php" style="text-decoration: none; color: #333; font-size: 22px; margin-top: 40px;"><h4 style="margin-top: 10px;">Éclat & Vitalité</h4></a>
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
                            <a class="nav-link custom" href="../profile/profile.php">Profil</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../../login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../../registre.php">S'inscrire</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <div class="container">
            <form class="d-flex" role="search" action="" method="POST">
                <input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Rechercher" name="search"/>
                <button class="btn btn-outline-success" type="submit">Rechercher</button>
            </form>
        </div>

        <?php if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client"): ?>
            <div class="user-wrapper">
                <a href="../panier/panier.php">
                    <i class="fas fa-shopping-cart">Panier</i>
                </a>
                <!-- Affiche le nombre d'articles dans le panier -->
                <span style="color: red">(<?php echo isset($_SESSION['Nbt']) ? intval($_SESSION['Nbt']) : 0; ?>)</span>
                <a class="logout-btn" href="../../deconnexion.php">Déconnexion</a>
            </div>
        <?php endif; ?>
    </div>
</header>

<!-- Barre de navigation -->
<header class="ous">
    <div class="container d-flex justify-content-between align-items-center">
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
                            <a class="nav-link custom" href="../profile/profile.php">Profil</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../../login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../../registre.php">S'inscrire</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <div class="logo-wrapper">
            <a href="../../index.php" style="text-decoration: none; color: #333; font-size: 22px; margin-top: 40px;"><h4 style="margin-top: 10px;">Éclat & Vitalité</h4></a>
        </div>

        <?php if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client"): ?>
            <div class="user-wrapper">
                <a href="../panier/panier.php">
                    <i class="fas fa-shopping-cart">Panier</i>
                </a>
                <!-- Affiche le nombre d'articles dans le panier -->
                <span style="color: red">(<?php echo isset($_SESSION['Nbt']) ? intval($_SESSION['Nbt']) : 0; ?>)</span>
                <a class="logout-btn" href="../../deconnexion.php">Déconnexion</a>
            </div>
        <?php endif; ?>
    </div>
</header>

<div class="container mt-3"></div>

<!-- Début Boutique de Fruits-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Éclat & Vitalité : <i><?php echo getCategoriById($_GET['idCa']);?></i></h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4 justify-content-center">
                    <?php foreach($productsToShow as $product): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="rounded position-relative fruite-item">
                                <div class="fruite-img">
                                    <img src="../../images/<?php echo $product['image']; ?>" class="img-fluid rounded-top image-style" width="500" height="500" alt="">
                                </div>
                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                    <?php foreach($categories as $cat): ?>
                                        <?php if($product['id_categorie']==$cat['id']): ?>
                                            <?php echo $cat['libelle']; ?>
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
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="pagination d-flex justify-content-center mt-5">
                <a href="<?php echo ($page > 1) ? 'categories.php?idCa=' . urlencode($_GET['idCa']) . '&page=' . ($page - 1) : '#'; ?>" class="rounded"><button class="btn btn-light m-1">&laquo;</button></a>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="categories.php?idCa=<?php echo urlencode($_GET['idCa']); ?>&page=<?php echo $i; ?>" class="<?php echo ($i === $page) ? 'active' : ''; ?> rounded"><button class="btn btn-primary m-1"><?php echo $i; ?></button></a>
                <?php endfor; ?>
                <a href="<?php echo ($page < $totalPages) ? 'categories.php?idCa=' . urlencode($_GET['idCa']) . '&page=' . ($page + 1) : '#'; ?>" class="rounded"><button class="btn btn-light m-1">&raquo;</button></a>
            </div>
        </div>

    </div>
</div>
<!-- Fin Boutique de Produits-->

<?php include '../../include/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
