<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email'])){
    header('Location: login.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
}

include '../../include/functionsProductCate.php';

if(!empty($_POST['sPro'])) {
    $products = searchProducts($_POST['sPro']);
} else {
    $products = getAllProducts();
}


// Pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$categoriesPerPage = 4;
$totalProducts = count($products);
$totalPages = ceil($totalProducts / $categoriesPerPage);
$startIndex = ($page - 1) * $categoriesPerPage;
$productsToShow = array_slice($products, $startIndex, $categoriesPerPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éclat & Vitalité (Admin)</title>
    <link rel="stylesheet" href="stylesProduits.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<div class="app-container">
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../profile.php">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="../categorise/listeCategorise.php">
                        <i class="fas fa-th-list"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="listeProduits.php">
                        <i class="fas fa-box"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-users"></i> Customers
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="container mt-3" style=" width: 260px;
    height: 52px;
    background-color: #ffffff;">

    </div>

    <header style="position: fixed; top: 0; width: 100%; background-color: #f8f9fa; padding: 10px 20px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); z-index: 100;">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo-wrapper">
                <h1 style="margin: 0; font-size: 24px; color: #333;">Éclat & Vitalité (Admin)</h1>
            </div>
            <form method="post" action="">
                <div class="search-wrapper">
                    <input type="text" name="sPro" placeholder="Search..." style="padding: 5px; border-radius: 5px; border: 1px solid #ced4da;">
                    <button type="button" style="background-color: transparent; border: none; cursor: pointer; margin-left: 5px;"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="20" height="20"><path fill="currentColor" d="M507.601 484.398L374.1 350.9c35.4-43.9 57-99.7 57-160.9C431.1 76.5 354.6 0 256 0S80.9 76.5 80.9 174.9c0 98.5 76.5 174.9 174.9 174.9 61.2 0 117-21.6 160.9-57l133.5 133.5c3.1 3.1 7.2 4.7 11.3 4.7s8.2-1.6 11.3-4.7c6.3-6.2 6.3-16.2 0-22.4zM92.8 174.9C92.8 99 149 42.8 224.9 42.8S357 99 357 174.9s-56.2 132.1-132.1 132.1S92.8 250.8 92.8 174.9z"/></svg></button>
                </div>
            </form>
            <div class="user-wrapper">
                <img src="user.jpg" alt="user" width="40" height="40" style="border-radius: 50%;">
                <span class="username" style="margin-left: 10px;">John Doe</span>
                <?php
                // Vérifiez l'existence des données de session avant de les afficher
                if(isset($_SESSION['email'])) {
                    echo '<span class="username"><a class="nav-link active btn btn-primary" aria-current="page" href="../deconnexion.php" style="margin-left: 10px;">Déconnexion</a></span>';
                }
                ?>
            </div>
        </div>
    </header>



    <div class="main-content">
        <div style=" width: 1px;
             height: 52px;
             background-color: #ffffff;">

        </div>
        <main>
            <div class="container">
                <?php
                // Vérifiez l'existence des données de session avant de les afficher
                if(isset($_SESSION['email'])) {
                echo "<div class='title-and-button'>";
                echo "<h1>Liste des Produits</h1>";
                echo '<a href="ajout.php" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutModal"> Ajouter Produit + </a>';
                echo "</div>";?>
            </div>

            <div class="container">
                <?php

                if (empty($productsToShow)) {
                    echo "<p>Aucun produit trouvé.</p>";
                } else {
                if(isset($_GET['ajout'])&& $_GET['ajout']=="ok")
                    echo "<div class='alert alert-success'>Nouveau produit ajouté avec succès !!!</div>";
                if(isset($_GET['ajout'])&& $_GET['ajout']=="Nok")
                    echo "<div class='alert alert-danger'>Le libellé existe déjà. Veuillez en choisir un autre !!!</div>";

                if(isset($_GET['delete'])&& $_GET['delete']=="ok")
                    echo "<div class='alert alert-success'>Produit supprimé avec succès !!!</div>";
                if(isset($_GET['delete'])&& $_GET['delete']=="Nok")
                    echo "<div class='alert alert-danger'>Échec de la suppression du produit !!!</div>";

                if(isset($_GET['update'])&& $_GET['update']=="ok")
                    echo "<div class='alert alert-success'>Produit mis à jour avec succès !!!</div>";
                if(isset($_GET['update'])&& $_GET['update']=="Nok")
                    echo "<div class='alert alert-danger'>Échec de la mise à jour du produit. Veuillez réessayer !!!</div>";



                echo ' <div class="container"> <table>
                    <thead>
                <tr>
                    <th>ID</th>
                    <th>Libellé</th>
                    <th>Prix</th>
                    <th>Réduction</th>
                    <th>ID Catégorie</th>
                    <th>Date de création</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Couleur</th>
                    <th>Date de modification</th>
                    <th>Actions</th>
                </tr>
                    </thead>
                    <tbody>';
                foreach ($productsToShow as $product) {
                    echo "<tr>
                                      <td>{$product['id']}</td>
                                      <td>{$product['libelle']}</td>
                                      <td>{$product['prix']} DH</td>
                                      <td>{$product['discount']}</td>
                                      <td>{$product['id_categorie']}</td>
                                      <td>{$product['date_creation']}</td>
                                      <td>{$product['description']}</td>
                                      <td>{$product['image']}</td>
                                      <td>{$product['color']}</td>
                                       <td>{$product['date_modification']}</td>
            <td class='action-buttons'>
                <a class='btn btn-success edit-button' href='modifier.php?id={$product['id']}' data-bs-toggle='modal' data-bs-target='#modifierModal{$product['id']}' >Modifier</a>
                <a class='btn btn-danger delete-button' href='supprimer.php?id={$product['id']}'>Supprimer</a>
            </td>
        </tr>";
                }
                echo '</tbody>
                </table>';?>
            </div>


            <?php

            // Boutons de pagination
            echo '<div class="pagination-buttons">';
            if ($page > 1) {
                echo '<a href="?page='.($page-1).'" class="btn btn-primary"><=Précédent</a>';
            }
            if ($page < $totalPages) {
                echo '<a href="?page='.($page+1).'" class="btn btn-primary">Suivant=></a>';
            }
            echo '</div>';
            }
            } else {
                echo "<p>Session data not found.</p>";
            }
            ?>


        </main>

    </div>
</div>

<!-- Modal ajouter Produit -->
<div class="modal fade" id="ajoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Produit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="ajout.php" method="post">
                    <div class="form-group">
                        <label for="libelle">Nom Produit :</label>
                        <input type="text" name="libelle" id="libelle" class="form-control" placeholder="Nom de produit ..." required>
                    </div>

                    <div class="form-group">
                        <label for="prix">Prix :</label>
                        <input type="number" name="prix" id="prix" class="form-control" placeholder="Prix du produit ..." required>
                    </div>

                    <div class="form-group">
                        <label for="id_categorie">ID Catégorie :</label>
                        <input type="number" name="id_categorie" id="id_categorie" class="form-control" placeholder="ID de la catégorie ..." required>
                    </div>

                    <div class="form-group">
                        <label for="quantite">Quantite :</label>
                        <input type="number" name="quantite" id="quantite" class="form-control" placeholder="Quantité ..." required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description :</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Description de produit ..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Image :</label>
                        <input type="text" name="image" id="image" class="form-control" placeholder="URL de l'image ..." required>
                    </div>

                    <div class="form-group">
                        <label for="couleur">Couleur :</label>
                        <input type="text" name="color" id="couleur" class="form-control" placeholder="Couleur du produit ..." required>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- chaque Produit admet un modal -->
<?php
foreach ($productsToShow as $item => $product) { ?>
    <!-- Modal Modifier Produit -->
    <div class="modal fade" id="modifierModal<?php echo "{$product['id']}"; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Produit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="modifier.php?id=<?php echo "{$product['id']}"; ?>" method="post">
                        <div class="form-group">
                            <label for="libelle">Libellé :</label>
                            <input type="text" name="libelle" class="form-control" value="<?php echo "{$product['libelle']}"; ?>" placeholder="Nom de produit ..." required>
                        </div>

                        <div class="form-group">
                            <label for="prix">Prix :</label>
                            <input type="number" name="prix" class="form-control" value="<?php echo "{$product['prix']}"; ?>" placeholder="Prix du produit ..." required>
                        </div>


                        <div class="form-group">
                            <label for="id_categorie">ID Catégorie :</label>
                            <input type="text" name="id_categorie" class="form-control" value="<?php echo "{$product['id_categorie']}"; ?>" placeholder="ID de la catégorie ..." required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description :</label>
                            <textarea name="description" class="form-control" placeholder="Description de produit ..." required><?php echo "{$product['description']}"; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Image :</label>
                            <input type="text" name="image" class="form-control" value="<?php echo "{$product['image']}"; ?>" placeholder="URL de l'image ..." required>
                        </div>

                        <div class="form-group">
                            <label for="couleur">Couleur :</label>
                            <input type="text" name="couleur" class="form-control" value="<?php echo "{$product['color']}"; ?>" placeholder="Couleur du produit ..." required>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<?php } ?>




</body>
</html>
