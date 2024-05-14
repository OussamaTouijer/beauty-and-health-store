<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== "client") {
    header("Location: ../../login.php");
    exit(); // Assurez-vous de sortir après avoir redirigé
}

// Inclure les fonctions nécessaires
include '../../include/functionsPanier.php';

// Traitement du changement d'état du panier s'il y a une soumission de formulaire
if (isset($_POST['btnSu'])) {
    changerEtatPanier($_POST);
}

// Initialiser les tableaux
$paniers = [];
$commands = [];

// Obtenir toutes les commandes
$commands = getAllCommands();

// Effectuer une recherche ou récupérer tous les paniers
if (!empty($_POST['sPro'])) {
    $paniers = searchPaniers($_POST['sPro']);
} else {
    $paniers = getAllPaniers();
}

// Filtrer les paniers par état de commande s'il y a une soumission de formulaire
if (isset($_POST['btS']) && isset($_POST['etat_commande'])) {
    $paniers = getByEta($paniers, $_POST['etat_commande']);
}

// Pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$paniersPerPage = 40;
$totalPaniers = count($paniers);
$totalPages = ceil($totalPaniers / $paniersPerPage);
$startIndex = ($page - 1) * $paniersPerPage;
$paniersToShow = array_slice($paniers, $startIndex, $paniersPerPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="panierCss.css">
    <title>Éclat & Vitalité</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
</head>
<body style="background-color: #f4f4f4">

<!-- header-->

<header>
    <div class="container d-flex justify-content-between align-items-center">

        <div style="margin-right: 15px;">
            <!-- Autres éléments de la barre de navigation -->
            <div class="logo-wrapper">
                <a href="../../index.php" style="text-align: center; text-decoration: none; color: #333; font-size: 22px;"><h4>Éclat & Vitalité</h4></a>
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
                            <a class="nav-link custom" href="../profile/profile.php">Profil</a>                        </li>
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
        <!-- <div class="container">
             <form class="d-flex" role="search" action="index.php" method="POST">
                 <input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Rechercher" name="search"/>
                 <button class="btn btn-outline-success" type="submit">Rechercher</button>
             </form>
         </div> -->
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
                        <a class="nav-link  custom" href="../home/home.php">Home</a>
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
                    <?php endif; ?>

                </ul>
            </nav>
        </div>

        <!-- Autres éléments de la barre de navigation -->
        <div class="logo-wrapper">
            <a href="../../index.php" style="text-align: center; text-decoration: none; color: #333; font-size: 22px;"><h4>Éclat & Vitalité</h4></a>
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



<div class="container mt-3" style="width: 1px; height: 96px; background-color: #f4f4f4;"></div>


<mainb style="background-color: #f4f4f4">
    <div class="container d-flex justify-content-center align-items-center" style="background-color: #f4f4f4">

        <!-- Votre en-tête ici -->

        <!-- Contenu principal -->
        <div class="container-fluid py-1 mt-1" style="background-color: #eeeeee;border-radius:25px;">
            <h2 class="title">Vos Achats</h2>

            <style>
                @media only screen and (max-width: 1024px) {
                    .siw {
                        overflow-x: auto;
                    }
                    .sid {
                        overflow-x: auto;
                    }
                }
            </style>
            <div class="container mb-2">
                <form action="" method="post" class="d-flex align-items-end">
                    <select name='etat_commande' class="form-control me-2">
                        <option value='en cours'>===Choisir l'etat===</option>
                        <option value='en cours'>En cours</option>
                        <option value='en livraison'>En livraison</option>
                        <option value='livrée'>Livrée</option>
                        <option value='annulée'>Annulée</option>
                    </select>
                    <button type="submit" name="btS" class="btn btn-primary">Chercher</button>
                </form>
            </div>

            <?php
            echo '<div class="siw"> <table class="tablee" style="margin-left: auto; margin-right: auto;">
                    <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Prix Total</th>
                    <th>Mode de paiement</th>
                    <th>Etat</th>
                    <th>Actions</th>
                </tr>
                    </thead>
                    <tbody>';
            foreach ($paniersToShow as $panier) {
            if ($_SESSION['id'] == $panier['idClient']) {
                echo "<tr>
                                      <td>{$panier['id']}</td>
                                      <td>{$panier['nom']} {$panier['prenom']}</td>
                                      <td>{$panier['date_creation']}</td>
                                      <td>{$panier['total']} DH</td>
                                      <td>{$panier['mode_paiement']}</td>
                                      <td>{$panier['etat_commande']}</td>
                                      <td class='action-buttons'>
                                           <a  data-bs-toggle='modal' data-bs-target='#modifierModal{$panier['id']}' ><button class='edit-button'>Affichier</button></a>                                           
                                      </td>
                                      
                         </tr>";}
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            ?>


            <!-- Boutons de pagination -->
            <div class="container pagination-buttons mt-2" style="margin-left: auto; margin-right: auto;">
                <?php
                if ($page > 1) {
                    echo '<a href="?page='.($page-1).'" class="btn btn-primary"><= Précédent</a>';
                }
                if ($page < $totalPages) {
                    echo '<a href="?page='.($page+1).'" class="btn btn-primary">Suivant =></a>';
                }
                ?>
            </div>

            <a href="../home/home.php" class="btn btn-primary mt-1">Continuer les achats</a>
        </div>

        <!-- Votre pied de page ici -->

    </div>
</mainb>



<!-- Chaque produit admet un modal -->
<!-- Modals pour chaque panier -->
<?php foreach ($paniersToShow as $panier) : ?>
    <!-- Modal Modifier Produit -->
    <div class="modal fade swd" id="modifierModal<?php echo "{$panier['id']}"; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Liste des commandes</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tableau pour afficher les détails du panier -->
                    <div class="siw">
                        <table class="table" style="margin-left: auto; margin-right: auto;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produit</th>
                                <th>Images</th>
                                <th>Quantité</th>
                                <th>Total</th>
                                <!--                                <th>Actions</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Affichage des détails du panier -->
                            <?php foreach ($commands as $command) {
                                if ($command['id_panier'] == $panier['id']) {
                                    echo "<tr>
                                                <td>{$command['id']}</td>
                                                <td>{$command['libelle']} : {$command['marque']}</td>
                                                <td><img class='image-style' src='../../images/{$command['image']}' class='card-img-top' alt='...' /></td>
                                                <td>{$command['quantite']}</td>
                                                <td>{$command['total']} DH</td>
                                              <!--  <td class='action-buttons'>
                                                    <a href='modifier.php?id={$command['id']}' data-bs-toggle='modal' data-bs-target='#modifierModal{$command['id']}'><button class='edit-button'>Afficher</button></a>
                                                    <a href='supprimer.php?id={$command['id']}'><button class='delete-button'>Supprimer</button></a>
                                                </td>-->
                                            </tr>";
                                }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Boutons ou actions pour modifier ou supprimer le panier
                    <button type="button" class="btn btn-primary">Modifier</button>-->
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<?php include '../../include/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
