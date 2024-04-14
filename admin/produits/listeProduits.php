<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email'])){
    header('location: login.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
}

include '../../include/functionsProductCate.php';


$categories = getAllCategories();

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
            <div class="search-wrapper">
                <input type="text" placeholder="Search..." style="padding: 5px; border-radius: 5px; border: 1px solid #ced4da;">
                <button type="button" style="background-color: transparent; border: none; cursor: pointer; margin-left: 5px;"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="20" height="20"><path fill="currentColor" d="M507.601 484.398L374.1 350.9c35.4-43.9 57-99.7 57-160.9C431.1 76.5 354.6 0 256 0S80.9 76.5 80.9 174.9c0 98.5 76.5 174.9 174.9 174.9 61.2 0 117-21.6 160.9-57l133.5 133.5c3.1 3.1 7.2 4.7 11.3 4.7s8.2-1.6 11.3-4.7c6.3-6.2 6.3-16.2 0-22.4zM92.8 174.9C92.8 99 149 42.8 224.9 42.8S357 99 357 174.9s-56.2 132.1-132.1 132.1S92.8 250.8 92.8 174.9z"/></svg></button>
            </div>
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
                        echo "<h1>Liste des Catégories</h1>";
                        echo '<a href="ajout.php" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutModal"> Ajouter Categorise + </a>';
                        echo "</div>";?>
                </div>

                <div class="container">
                <?php

                        if (empty($categories)) {
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
                             echo "<div class='alert alert-danger'>Échec de la mise à jour de la catégorie. Veuillez réessayer !!!</div>";



                echo ' <div class="container"> <table>
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
                                    <a class='btn btn-success edit-button' href='modifier.php' data-bs-toggle='modal' data-bs-target='#modifierModal{$category['id']}' >Modifier</a>
                                    <a class='btn btn-danger delete-button' href='supprimer.php?id={$category['id']}'>Supprimer</a>
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