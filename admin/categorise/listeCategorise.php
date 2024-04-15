<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email'])){
    header('location: ../login.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
}

include '../../include/functionsProductCate.php';

if(!empty($_POST['sCat'])) {
    $categories = searchCategories($_POST['sCat']);
} else {
    $categories = getAllCategories();
}


// Pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$categoriesPerPage = 4;
$totalCategories = count($categories);
$totalPages = ceil($totalCategories / $categoriesPerPage);
$startIndex = ($page - 1) * $categoriesPerPage;
$categoriesToShow = array_slice($categories, $startIndex, $categoriesPerPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éclat & Vitalité (Admin)</title>
    <link rel="stylesheet" href="stylesCategorise.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<!-- header-->
<header style="position: fixed; top: 0; width: 100%; background-color: #f8f9fa; padding: 1px 2px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); z-index: 100;">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="" style="margin-right: 1px; ">
            <div class="logo-wrapper">
                <h6 style=" font-size: 22px; color: #333;">Éclat & Vitalité (Admin)</h6>
            </div></div>

        <div class="container">

            <nav class="p-1">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link custom" href="#">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../profile/profile.php">
                            Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active custom" href="listeCategorise.php">
                            Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../produits/listeProduits.php">
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="#">
                            Customers
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



    <div style=" width: 1px;
          height: 68px;
          background-color: #ffffff;">
    </div>

<!-- main contenu-->
        <div class="main-content">
            <main>
                <div class="container">
                    <?php
                    // Vérifiez l'existence des données de session avant de les afficher
                    if(isset($_SESSION['email'])) {
                        echo "<div class='title-and-button'>";
                        echo "<h2 class='title'>Liste des Catégories</h2>";
                    //formulair pour la recherch de produit
                    print'<form method="post" action="" >
                    <input type="text" for="b1" name="sCat" placeholder="Recherche..." class="iptR">
                    <button type="submit" id="b1" class="buR" >
                        Recherche
                    </button>
                </form>';
                    echo "</div>";?>
                </div>


                <!-- button pour remplire modale-->
                <?php echo '<div class="container"><a href="ajout.php" class="btnAjout" data-bs-toggle="modal" data-bs-target="#ajoutModal"> Ajouter Catégories + </a></div><br>';?>

                <div class="container">
                     <?php

                        if (empty($categoriesToShow)) {
                            echo "<p>Aucune catégorie trouvée.</p>";
                        } else {
                            if(isset($_GET['ajout'])&& $_GET['ajout']=="ok")
                            echo "<div class='alert alert-success'>Nouvelle catégorie ajoutée avec succès !!!</div>";
                            if(isset($_GET['ajout'])&& $_GET['ajout']=="Nok")
                            echo "<div class='alert alert-danger'>Le libellé existe déjà. Veuillez en choisir un autre !!!</div>";

                        if(isset($_GET['delete'])&& $_GET['delete']=="ok")
                            echo "<div class='alert alert-success'>Catégorie Supprimer avec succès !!!</div>";
                        if(isset($_GET['delete'])&& $_GET['delete']=="Nok")
                            echo "<div class='alert alert-danger'>Catégorie Supprimer avec Échec !!!</div>";

                       if(isset($_GET['update'])&& $_GET['update']=="ok")
                            echo "<div class='alert alert-success'>Catégorie mise à jour avec succès !!! !!!</div>";
                       if(isset($_GET['update'])&& $_GET['update']=="Nok")
                             echo "<div class='alert alert-danger'>Échec de la mise à jour de la catégorie. Veuillez réessayer !!!</div>";?>

                     <?php

                echo ' <div class="container"> <table class="tablee">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Libellé</th>
                            <th>Description</th>
                            <th>Date de création</th>
                            <th>Date de modification</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
                            foreach ($categoriesToShow as $category) {
                                echo "<tr>
                                <td>{$category['id']}</td>
                                <td>{$category['libelle']}</td>
                                <td>{$category['description']}</td>
                                <td>{$category['date_creation']}</td>
                                <td>{$category['date_modification']}</td>
                                <td class='action-buttons'>
                                    <a href='modifier.php' data-bs-toggle='modal' data-bs-target='#modifierModal{$category['id']}' ><button class='edit-button'>Modifier</button></a>
                                    <a href='supprimer.php?id={$category['id']}'><button class='delete-button'>Supprimer</button></a>
                                </td>
                            </tr>";
                            }

                     echo '</tbody>';
                     echo '</table>';?>

                     <div style=" width: 1px;
                       height: 14px;
                       background-color: #ffffff;">
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

               </div>


            </main>

        </div>

<!-- Modal ajouter Categirie -->
<div class="modal fade" id="ajoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Categorie</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="ajout.php" method="post">
                    <div class="form-group">
                        <input type="text" name="libelle" class="form-control" placeholder="nom de categorie ..." required>
                        <br>
                    </div>

                    <div class="form-group">
                        <textarea  name="description" class="form-control" placeholder="description de categorie ..." required></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- chaque Catégorie admet un modal -->
<?php
foreach ($categoriesToShow as $item => $category) { ?>
    <!-- Modal Modifier Catégorie -->
    <div class="modal fade" id="modifierModal<?php echo "{$category['id']}"; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Catégorie</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="modifier.php?id=<?php echo "{$category['id']}"; ?>"" method="post">
                        <div class="form-group">
                            <input type="text" name="libelle" class="form-control" value="<?php echo "{$category['libelle']}"; ?>" placeholder="Nom de catégorie ..." required>
                            <br>
                        </div>

                        <div class="form-group">
                            <textarea name="description" class="form-control" placeholder="Description de catégorie ..." required><?php echo "{$category['description']}"; ?></textarea>
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
