<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
    exit();
}

include '../../include/functionsCustomers.php';


if(!empty($_POST['sCus'])) {
    $users = searchCustomers($_POST['sCus']);
} else {
    $users = getAllCustomers();
}

// Pagination et traitement des utilisateurs à afficher
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$usersPerPage = 4;
$totalUsers = count($users);
$totalPages = ceil($totalUsers / $usersPerPage);
$startIndex = ($page - 1) * $usersPerPage;
$usersToShow = array_slice($users, $startIndex, $usersPerPage);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éclat & Vitalité (Admin)</title>
    <link rel="stylesheet" href="stylesCustomers.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
                        <a class="nav-link custom" href="#">
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
                        <a class="nav-link  custom" href="../produits/listeProduits.php">
                            Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active custom" href="listeCustomers.php">
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
                        <a class="nav-link custom" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../profile/profile.php">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom" href="../categorise/listeCategorise.php">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  custom" href="../produits/listeProduits.php">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active custom" href="listeCustomers.php">Clientes</a>
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
                echo "<h2 class='title' >Liste des Clientes</h1>";
                //formulair pour la recherch de Clientes
                print'<form method="post" action="" >
                    <input type="number" for="b1" name="sCus" placeholder="Recherche..." class="iptR">
                    <button type="submit" id="b1" class="buR" >
                        Recherche
                    </button>
                </form>';
                echo "</div>";?>
            </div>

            <div class="container">
                <?php

                if (empty($usersToShow)) {
                    echo "<p>Aucun Clientes trouvé.</p>";
                } else {
                if(isset($_GET['ajout'])&& $_GET['ajout']=="ok")
                    echo "<div class='alert alert-success'>Nouveau Clientes ajouté avec succès !!!</div>";
                if(isset($_GET['ajout'])&& $_GET['ajout']=="Nok")
                    echo "<div class='alert alert-danger'>Le libellé existe déjà. Veuillez en choisir un autre !!!</div>";

                if(isset($_GET['delete'])&& $_GET['delete']=="ok")
                    echo "<div class='alert alert-success'>Clientes supprimé avec succès !!!</div>";
                if(isset($_GET['delete'])&& $_GET['delete']=="Nok")
                    echo "<div class='alert alert-danger'>Échec de la suppression du Clientes !!!</div>";

                if(isset($_GET['update'])&& $_GET['update']=="ok")
                    echo "<div class='alert alert-success'>Clientes mis à jour avec succès !!!</div>";
                if(isset($_GET['update'])&& $_GET['update']=="Nok")
                    echo "<div class='alert alert-danger'>Échec de la mise à jour du Clientes. Veuillez réessayer !!!</div>";?>
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
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Ville</th>
                    <th>Telephone</th>
                    <th>user_type</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
                    </thead>
                    <tbody>';
                foreach ($usersToShow as $users) {
                    echo "<tr>
                                      <td>{$users['id']}</td>
                                      <td>{$users['nom']}</td>
                                      <td>{$users['prenom']} DH</td>
                                      <td>{$users['email']}</td>
                                      <td>{$users['address']}</td>
                                      <td>{$users['ville']}</td>
                                      <td>{$users['telephone']}</td>
                                      <td>{$users['user_type']}</td>
                                      <td>{$users['date_creation']}</td>
                                      <td>
                                           <a href='modifier.php?id={$users['id']}' data-bs-toggle='modal' data-bs-target='#modifierModal{$users['id']}' ><button class='edit-button'>Modifier</button></a>
                                           <a href='supprimer.php?id={$users['id']}'><button class='delete-button'>Supprimer</button></a>
                                           
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

<?php foreach ($usersToShow as $item => $user) { ?>
    <div class="modal fade" id="modifierModal<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Type d'utilisateur</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action='modiferType.php' method='post'>
                        <div class="form-group">
                            <label for="userType">Type d'utilisateur : <?php echo $user['user_type']; ?></label>
                            <select name='userType' class="form-control">
                                <option value='admin' <?php if($user['user_type'] == 'admin') echo 'selected'; ?>>Admin</option>
                                <option value='client' <?php if($user['user_type'] == 'client') echo 'selected'; ?>>Client</option>
                            </select>
                        </div>
                        <div style=" width: 1px;
                       height: 14px;
                       background-color: #ffffff;">
                        </div>
                        <!-- Vous pouvez ajouter d'autres champs ici si nécessaire -->
                        <div class="form-group">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

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
