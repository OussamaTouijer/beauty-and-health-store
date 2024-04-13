<?php
include 'include/functionsProductCate.php';
include 'include/functionsLoginRegistre.php';

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
    <title>Éclat & Vitalité</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
</head>
<body>
<?php include 'include/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="card col-md-6 p-5">
            <?php if($product): ?>
                <img src="images/<?php echo $product['image']; ?>" class="card-img-top" alt="...">
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

<?php include 'include/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
