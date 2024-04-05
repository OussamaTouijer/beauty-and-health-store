<?php 
include 'include/functionsProductCate.php';

// Récupération des catégories et des produits
$categories = getAllCategories();

if(!empty($_POST['search'])) {
    $products = searchProducts($_POST['search']);
} else {
    $products = getAllProducts();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <title>Votre titre</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include 'include/header.php'; ?>

    <div class="container mt-3">
        <div class="row">
            <?php foreach($products as $product): ?>
                <div class="col-3">
                    <div class="card mb-3">
                        <img src="..." class="card-img-top" alt="..." />
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['libelle']; ?></h5>
                            <p class="card-text"><?php echo $product['description']; ?></p>
                            <a href="produit.php?id=<?php echo $product['id']; ?>" class="btn btn-primary">Afficher</a>
                        </div>
                    </div>
                </div> 
            <?php endforeach; ?>
        </div>
    </div>

    <?php include 'include/footer.php'; ?>
</body>
</html>
