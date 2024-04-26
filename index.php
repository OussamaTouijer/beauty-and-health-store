<?php
session_start();
include 'include/functionsProductCate.php';

// Récupération des catégories et des produits
$categories = getAllCategories();

// Initialisation du tableau de produits
$products = [];

// Récupération des catégories et des produits
$categories = getAllCategories();

// Initialisation du tableau de produits
$products = [];

// Vérifier si une recherche est effectuée
if (!empty($_POST['search'])) {
    $products = searchProducts($_POST['search']);
} else {
    // Aucune recherche, récupérer tous les produits
    $products = getAllProducts();
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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Éclat & Vitalité</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php include 'include/header.php'; ?>

<!-- Début Boutique de Fruits-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Boutique Éclat & Vitalité</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <!-- Recherche -->
                    <div class="col-xl-3">
                        <div class="input-group w-100 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="mots-clés" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>

                    <div class="col-6"></div>

                    <!-- Tri -->
                    <div class="col-xl-3">
                        <form method="POST" action="">
                            <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                <label for="produits">Tri par défaut :</label>
                                <select id="produits" name="sort" class="border-0 form-select-sm bg-light me-3" form="produitform">
                                    <option value="rien">Rien</option>
                                    <option value="popularite">Popularité</option>
                                    <option value="biologique">Biologique</option>
                                    <option value="fantastique">Fantastique</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Appliquer</button>
                            </div>
                        </form>
                    </div>

                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">

                            <div class="col-lg-12">

                                <!-- Catégories -->
                                <div class="mb-3">
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
                                                      <a href="#"><i class="fas  me-2"></i>'.$Cat['libelle'].'</a>
                                                      <span>('.$count.')</span>
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
                                    <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0" max="500" value="0" oninput="amount.value=rangeInput.value">
                                    <output id="amount" name="amount" min-velue="0" max-value="500" for="rangeInput">0</output><span> DH</span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <h4>Couleur</h4>
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
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rouge">
                                        <label for="Categories-3">Marron</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rouge">
                                        <label for="Categories-3">Violet</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rouge">
                                        <label for="Categories-3">Vert</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rouge">
                                        <label for="Categories-3">Blanc</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rouge">
                                        <label for="Categories-3">Rose</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rouge">
                                        <label for="Categories-3">Beige</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rouge">
                                        <label for="Categories-3">Noir</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rouge">
                                        <label for="Categories-3">Green</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rouge">
                                        <label for="Categories-3">Noir</label>
                                    </div>
                                    <div class="mb-2">
                                        <input type="radio" class="me-2" id="Categories-3" name="Categories-1" value="Rouge">
                                        <label for="Categories-3">Noir</label>
                                    </div>
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
                                            <img src="images/<?php echo $product['image']; ?>" class="img-fluid rounded-top image-style" width="500" height="500" alt="">
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
                                                <a href="produit.php?id=<?php echo $product['id']; ?>" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                    <i class="fa fa-shopping-bag me-2 text-primary"></i> Afficher Produit en détail
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <div class="col-12">
                                <div class="pagination d-flex justify-content-center mt-5">
                                    <a href="<?php echo ($page > 1) ? 'index.php?page='.($page-1) : ''; ?>" class="rounded"><button class="btn btn-light m-1">&laquo </button></a>
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <a href="index.php?page=<?php echo $i; ?>" class="<?php echo ($i === $page) ? 'active ' : ''; ?>rounded"><button class="btn btn-primary m-1"><?php echo $i; ?></button></a>
                                    <?php endfor; ?>
                                    <a href="<?php echo ($page < $totalPages) ? 'index.php?page='.($page+1) : ''; ?>" class="rounded"><button class="btn btn-light m-1">&raquo </button> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin Boutique de Fruits-->

<?php include 'include/footer.php'; ?>
</body>
</html>
