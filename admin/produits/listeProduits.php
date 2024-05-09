<?php
session_start();

if (!isset($_SESSION['email']) || $_SESSION['user_type'] !== "admin"){
    header('Location: ../../login.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
}

include '../../include/functionsProductCate.php';
$categories = getAllCategories();

if(!empty($_POST['sPro'])) {
    $products = searchProducts($_POST['sPro']);
} else {
    $products = getAllProducts();
}



// Pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$categoriesPerPage = 12;
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
    <link rel="stylesheet" href="stylesProducts.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>



<!-- header-->
    <header >
        <div class="container d-flex justify-content-between align-items-center">

            <div class="" style="margin-right: 1px; ">
            <div class="logo-wrapper">
                <h6 style=" font-size: 22px; color: #333;">Éclat & Vitalité (Admin)</h6>
            </div></div>

            <div class="container">

            <nav class="p-1">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link custom" href="../home/Home.php">
                             Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../profile/profile.php">
                            Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../categorise/listeCategorise.php">
                            Catégories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active custom" href="listeProduits.php">
                            Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../users/listeCustomers.php">
                            Clientes
                        </a>
                    </li>
                </ul>
            </nav>

            </div>

            <div class="user-wrapper">
                <a href="../profile.php">
                <img src="../userImages/user.jpg" alt="user" class="user-image">
                </a>
                <span class="username"><?php echo htmlspecialchars($_SESSION['prenom'].' ' .$_SESSION['nom']); ?></span>
                <?php
                // Vérifiez l'existence des données de session avant de les afficher
                if(isset($_SESSION['email'])) {
                    echo '<a class="logout-btn" href="../deconnexion.php">Déconnexion</a>';
                }
                ?>
            </div>

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
            <nav>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link custom" href="../home/Home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../profile/profile.php">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../categorise/listeCategorise.php">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active custom" href="listeProduits.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../users/listeCustomers.php">Clientes</a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Autres éléments de la barre de navigation -->
        <div class="logo-wrapper">
            <h6 style=" font-size: 22px; color: #333;">Éclat & Vitalité (Admin)</h6>
        </div>

        <div class="user-wrapper">
            <a href="../profile.php">
                <img src="../userImages/user.jpg" alt="user" class="user-image">
            </a>
            <span class="username"><?php echo htmlspecialchars($_SESSION['prenom'].' ' .$_SESSION['nom']); ?></span>
            <?php
            // Vérifiez l'existence des données de session avant de les afficher
            if(isset($_SESSION['email'])) {
                echo '<a class="logout-btn" href="../deconnexion.php">Déconnexion</a>';
            }
            ?>
        </div>
    </div>
</header>



    <div style=" width: 1px;
             height: 68px;
             background-color: #ffffff;">
    </div>

<!-- main contenu-->
    <div class="main-content">

        <main >
            <div class="container">

                <?php
                // Vérifiez l'existence des données de session avant de les afficher
                if(isset($_SESSION['email'])) {

                echo "<div class='title-and-button'>";
                echo "<h2 class='title' >Liste des Produits</h1>";
                //formulair pour la recherch de produit
                print'<form method="post" action="" >
                    <input type="text" for="b1" name="sPro" placeholder="Recherche..." class="iptR">
                    <button type="submit" id="b1" class="buR" >
                        Recherche
                    </button>
                </form>';
                echo "</div>";?>
            </div>

            <!-- button pour remplire modale-->
            <?php echo '<div class="container"><a href="ajout.php" class="btnAjout" data-bs-toggle="modal" data-bs-target="#ajoutModal"> Ajouter Produit + </a></div><br>';?>

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
                    echo "<div class='alert alert-danger'>Échec de la mise à jour du produit. Veuillez réessayer !!!</div>";?>
<style>
    @media only screen and (max-width: 1024px) {
        .siw {
            overflow-x: auto;
        }
    }
</style>


                <?php
                echo ' <div class="siw"> <table class="tablee" style="margin-left: auto; margin-right: auto;">
                    <thead>
                <tr>
                    <th>ID</th>
                    <th>Libellé</th>
                    <th>Marque</th>
                    <th>Prix</th>
                    <th>Quantite</th>
                    <th>Catégorie</th>
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
                                      <td>{$product['marque']}</td>
                                      <td>{$product['prix']} DH</td>
                                      <td>{$product['discount']}</td>
                                      <td>" . getCategoriById($product['id_categorie']) . "</td>
                                      <td>{$product['date_creation']}</td>
                                      <td>{$product['description']}</td>
                                      <td><img class='image-style'src='../../images/{$product['image']}' class='card-img-top' alt='...' /></td>
                                      <td>{$product['color']}</td>
                                      <td>{$product['date_modification']}</td>
                                      <td class='action-buttons'>
                                           <a href='modifier.php?id={$product['id']}' data-bs-toggle='modal' data-bs-target='#modifierModal{$product['id']}' ><button class='edit-button'>Modifier</button></a>
                                           <a href='supprimer.php?id={$product['id']}'><button class='delete-button'>Supprimer</button></a>
                                           
                                      </td>
                                      
                         </tr>";
                        }

                    echo '</tbody>';
                    echo '</table>';?>




            </div>
            <div style=" width: 1px;
                       height: 17px;
                       background-color: #ffffff;">
            </div>

        <?php
                    // Boutons de pagination
                    echo '<div class="container pagination-buttons" style="margin-left: auto; margin-right: auto;">';
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


<!-- Modal ajouter Produit -->
<div class="modal fade" id="ajoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Produit</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="ajout.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="libelle">Nom Produit :</label>
                        <input type="text" name="libelle" id="libelle" class="form-control" placeholder="Nom de produit ..." required>
                    </div>
                    <div class="form-group">
                        <label for="marque">Marque Produit :</label>
                        <input type="text" name="marque" id="marque" class="form-control" placeholder="Marque de produit ..." required>
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix :</label>
                        <input type="number" name="prix" id="prix" class="form-control" placeholder="Prix du produit ..." required>
                    </div>

                    <div class="form-group">
                        <label for="id_categorie"> Catégorie :</label>
                        <select id="categories" name="id_categorie" class="form-control">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['libelle']; ?></option>
                            <?php endforeach; ?>
                        </select>
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
                        <input type="file" name="image" id="image" class="form-control" placeholder="URL de l'image ..." accept="image/jpeg, image/png" required>
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
                    <form action="modifier.php?id=<?php echo "{$product['id']}"; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="libelle">Libellé :</label>
                            <input type="text" name="libelle" class="form-control" value="<?php echo "{$product['libelle']}"; ?>" placeholder="Nom de produit ..." required>
                        </div>

                        <div class="form-group">
                            <label for="libelle">Marque :</label>
                            <input type="text" name="marque" class="form-control" value="<?php echo "{$product['marque']}"; ?>" placeholder="Marque de produit ..." required>
                        </div>

                        <div class="form-group">
                            <label for="prix">Prix :</label>
                            <input type="number" name="prix" class="form-control" value="<?php echo "{$product['prix']}"; ?>" placeholder="Prix du produit ..." required>
                        </div>


                        <div class="form-group">
                            <label for="id_categorie"> Catégorie est: <?php echo "**{$product['libelle']}**"; ?> :</label>
                            <select id="categories" name="id_categorie" class="form-control">
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['libelle']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Description :</label>
                            <textarea name="description" class="form-control" placeholder="Description de produit ..." required><?php echo "{$product['description']}"; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="prix">Quantite :</label>
                            <input type="number" name="quantite" class="form-control" value="<?php echo "{$product['discount']}"; ?>" placeholder="Prix du produit ..." required>
                        </div>

                        <div class="form-group">
                            <label for="image">Image : <?php echo "{$product['image']}"; ?></label>
                            <input type="file" name="image" class="form-control" placeholder="URL de l'image ..." required>
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

<!-- Footer -->
<?php include '../../include/footer.php'?>


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
