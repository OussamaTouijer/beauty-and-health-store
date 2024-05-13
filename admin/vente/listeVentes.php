<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['email']) || $_SESSION['user_type'] !== "admin") {
    header('Location: ../../login.php?redirect=admin_panel.php');
    exit(); // Assurer de sortir après la redirection
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
$paniersPerPage = 12;
$totalPaniers = count($paniers);
$totalPages = ceil($totalPaniers / $paniersPerPage);
$startIndex = ($page - 1) * $paniersPerPage;
$paniersToShow = array_slice($paniers, $startIndex, $paniersPerPage);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éclat & Vitalité (Admin)</title>
    <link rel="stylesheet" href="stylesVentes.css">
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
                        <a class="nav-link custom" href="../produits/listeProduits.php">
                            Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../users/listeCustomers.php">
                            Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active custom" href="listeVentes.php">
                            Ventes
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
                        <a class="nav-link active custom" href="../produits/listeProduits.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../users/listeCustomers.php">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="listeVentes.php">
                            Ventes
                        </a>
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
                echo "<h2 class='title' >Liste des Paniers</h1>";
                //formulair pour la recherch de produit
                print'<form method="post" action="" >
                    <input type="text" for="b1" name="sPro" placeholder="Recherche..." class="iptR">
                    <button type="submit" id="b1" class="buR" >
                        Recherche
                    </button>
                </form>';
                echo "</div>";?>
            </div>



       <div class="container">


                <?php

                if (empty($paniersToShow)) {
                    echo "<p>Aucun paniers trouvé.</p>";
                } else {
                if(isset($_GET['ajout'])&& $_GET['ajout']=="ok")
                    echo "<div class='alert alert-success'>Nouveau panier ajouté avec succès !!!</div>";
                if(isset($_GET['ajout'])&& $_GET['ajout']=="Nok")
                    echo "<div class='alert alert-danger'>Le libellé existe déjà. Veuillez en choisir un autre !!!</div>";

                if(isset($_GET['delete'])&& $_GET['delete']=="ok")
                    echo "<div class='alert alert-success'>Panier supprimé avec succès !!!</div>";
                if(isset($_GET['delete'])&& $_GET['delete']=="Nok")
                    echo "<div class='alert alert-danger'>Échec de la suppression du panier !!!</div>";

                if(isset($_GET['update'])&& $_GET['update']=="ok")
                    echo "<div class='alert alert-success'>Panier mis à jour avec succès !!!</div>";
                if(isset($_GET['update'])&& $_GET['update']=="Nok")
                    echo "<div class='alert alert-danger'>Échec de la mise à jour du panier. Veuillez réessayer !!!</div>";?>
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
                echo ' <div class="siw"> <table class="tablee" style="margin-left: auto; margin-right: auto;">
                    <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Email</th>
                    <th>Addresse</th>
                    <th>Prix Total</th>
                    <th>Mode de paiement</th>
                    <th>Etat</th>
                    <th>Actions</th>
                </tr>
                    </thead>
                    <tbody>';
                foreach ($paniersToShow as $panier) {
                    echo "<tr>
                                      <td>{$panier['id']}</td>
                                      <td>{$panier['nom']} {$panier['prenom']}</td>
                                      <td>{$panier['email']}</td>
                                      <td>{$panier['address']}</td>
                                      <td>{$panier['total']} DH</td>
                                      <td>{$panier['mode_paiement']}</td>
                                      <td>{$panier['etat_commande']}</td>
                                      <td class='action-buttons'>
                                           <a  data-bs-toggle='modal' data-bs-target='#modifierModal{$panier['id']}' ><button class='edit-button'>Affichier</button></a>
                                           <a data-bs-toggle='modal' data-bs-target='#traitModal{$panier['id']}' ><button class='delete-button'>Traiter</button></a>
                                           
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


<!-- Chaque produit admet un modal Traiter -->
<!-- Modals pour chaque panier -->
<?php foreach ($paniersToShow as $panier) : ?>
    <!-- Modal Modifier Produit -->
    <div class="modal fade swd" id="traitModal<?php echo "{$panier['id']}"; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Traiter la commande</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="" method="post">
                        <input type="hidden" name="idP" value="<?php echo "{$panier['id']}"; ?>">
                        <div class="form-group">
                            <select name='etat_commande' class="form-control">
                                <option value='en cours' <?php if($panier['etat_commande'] == 'en cours') echo 'selected'; ?>>En cours</option>
                                <option value='en livraison' <?php if($panier['etat_commande'] == 'en livraison') echo 'selected'; ?>>En livraison</option>
                                <option value='livrée' <?php if($panier['etat_commande'] == 'livrée') echo 'selected'; ?>>Livrée</option>
                                <option value='annulée' <?php if($panier['etat_commande'] == 'annulée') echo 'selected'; ?>>Annulée</option>
                            </select>
                        </div>



                </div>
                <div class="modal-footer">
                    <!-- Boutons ou actions pour modifier ou supprimer le panier -->
                    <button type="submit" name="btnSu" class="btn btn-primary">Sauvgarder</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>


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
