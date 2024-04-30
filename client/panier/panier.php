<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email'])){
    header('location: login.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
}

// Inclure vos fonctions de manipulation de la base de données ici
// Assurez-vous d'avoir les fonctions nécessaires pour récupérer les informations sur les produits

// Fonction pour calculer le total du panier
function calculateTotal($cart) {
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['prix'] * $item['quantite'];
    }
    return $total;
}

// Si le panier est vide, initialiser un tableau vide
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Ajouter un produit au panier s'il est passé par GET
if (isset($_GET['id']) && isset($_GET['prix'])) {
    $product_id = $_GET['id'];
    $product_price = $_GET['prix'];

    // Vérifier si le produit est déjà dans le panier
    if (isset($_SESSION['panier'][$product_id])) {
        $_SESSION['panier'][$product_id]['quantite']++;
    } else {
        // Ajouter le produit au panier avec une quantité de 1
        $_SESSION['panier'][$product_id] = array(
            'id' => $product_id,
            'prix' => $product_price,
            'quantite' => 1
        );
    }
}

// Mettre à jour la quantité du produit dans le panier
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $_SESSION['panier'][$product_id]['quantite'] = $quantity;
    }
}

// Supprimer un produit du panier
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    unset($_SESSION['panier'][$product_id]);
}

// Calculer le total du panier
$total_panier = calculateTotal($_SESSION['panier']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Panier</title>
    <!-- Vos liens CSS et scripts JS ici -->
</head>
<body>

<!-- Votre en-tête ici -->

<!-- Contenu principal -->
<div class="container">
    <h2>Votre Panier</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Produit</th>
            <th>Prix unitaire</th>
            <th>Quantité</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_SESSION['panier'] as $product): ?>
            <tr>
                <td>Produit <?php echo $product['id']; ?></td>
                <td><?php echo $product['prix']; ?> MAD</td>
                <td>
                    <form method="post" action="panier.php">
                        <input type="number" name="quantity[<?php echo $product['id']; ?>]" value="<?php echo $product['quantite']; ?>" min="1">
                        <input type="submit" name="update_cart" value="Mettre à jour">
                    </form>
                </td>
                <td><?php echo $product['prix'] * $product['quantite']; ?> MAD</td>
                <td><a href="panier.php?action=delete&id=<?php echo $product['id']; ?>">Supprimer</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3">Total:</td>
            <td><?php echo $total_panier; ?> MAD</td>
            <td></td>
        </tr>
        </tfoot>
    </table>
    <a href="checkout.php">Passer à la caisse</a>
</div>

<!-- Votre pied de page ici -->

</body>
</html>
