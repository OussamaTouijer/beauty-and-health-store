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
            <!-- button pour remplire modale-->
            <?php echo '<div class="container"><a href="ajout.php" class="btnAjout" data-bs-toggle="modal" data-bs-target="#ajoutModal"> Ajouter Cliente + </a></div><br>';?>


            <div class="container">
                <?php

                if (empty($usersToShow)) {
                    echo "<p>Aucun Clientes trouvé.</p>";
                } else {
                if(isset($_GET['ajout'])&& $_GET['ajout']=="ok")
                    echo "<div class='alert alert-success'>Nouveau Clientes ajouté avec succès !!!</div>";
                if(isset($_GET['ajout'])&& $_GET['ajout']=="Nok")
                    echo "<div class='alert alert-danger'>Email existe déjà. Veuillez en choisir un autre !!!</div>";
                if(isset($_GET['ajout'])&& $_GET['ajout']=="Mok")
                    echo "<div class='alert alert-danger'>Les mots de passe ne correspondent pas !!!</div>";

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
                                      <td>{$users['prenom']}</td>
                                      <td>{$users['email']}</td>
                                      <td>{$users['address']}</td>
                                      <td>{$users['ville']}</td>
                                      <td>{$users['telephone']}</td>
                                      <td>{$users['user_type']}</td>
                                      <td>{$users['date_creation']}</td>
                                      <td>
                                           <a href='modifer.php' data-bs-toggle='modal' data-bs-target='#modifierModal{$users['id']}' ><button class='edit-button'>Modifier</button></a>
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

<!-- Modal ajouter Client -->
<div class="modal fade" id="ajoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter Client</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="ajout.php" method="post">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" name="nom" class="form-control" placeholder="Nom de Client ..." required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prenom :</label>
                        <input type="text" name="prenom" class="form-control"  placeholder="Prenom de Client ..." required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" name="email" class="form-control"  placeholder="Email de Client ..." required>
                    </div>

                    <div class="form-group">
                        <label for="userType">Type d'utilisateur : </label>
                        <select name='userType' class="form-control">
                            <option value='admin'>Admin</option>
                            <option value='client'>Client</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="telephone">Téléphone :</label>
                        <input type="tel" name="telephone" class="form-control" placeholder="Téléphone de Client ..." pattern="(05|06|07)[0-9]{8}" title="Veuillez saisir un numéro de téléphone valide au Maroc (format : 06XXXXXXXX, 07XXXXXXXX pour les mobiles ou 05XXXXXXXX pour les fixes)" required>
                    </div>


                    <div class="form-group">
                        <label for="address">Address :</label>
                        <input type="text" name="address" class="form-control" placeholder="Address de Client ..." required>
                    </div>

                    <div class="form-group">
                        <label for="password">Saisir mot de passe :</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Saisir le mot de passe du client..." required>
                    </div>

                    <div class="form-group">
                        <label for="password1">Répéter mot de passe :</label>
                        <input type="password" id="password1" name="password1" class="form-control" placeholder="Répéter le mot de passe du client..." required>
                    </div>


                    <div class="form-group">
                        <label for="ville">Ville :</label>
                        <select name='ville' class="form-control">
                            <option value="Agadir">Agadir</option>
                            <option value="Al Hoceima">Al Hoceima</option>
                            <option value="Asilah">Asilah</option>
                            <option value="Azemmour">Azemmour</option>
                            <option value="Azrou">Azrou</option>
                            <option value="Beni Mellal">Beni Mellal</option>
                            <option value="Berkane">Berkane</option>
                            <option value="Berrechid">Berrechid</option>
                            <option value="Casablanca">Casablanca</option>
                            <option value="Chefchaouen">Chefchaouen</option>
                            <option value="Dakhla">Dakhla</option>
                            <option value="El Jadida">El Jadida</option>
                            <option value="Errachidia">Errachidia</option>
                            <option value="Essaouira">Essaouira</option>
                            <option value="Fès">Fès</option>
                            <option value="Guelmim">Guelmim</option>
                            <option value="Ifrane">Ifrane</option>
                            <option value="Kenitra">Kenitra</option>
                            <option value="Khemisset">Khemisset</option>
                            <option value="Khenifra">Khenifra</option>
                            <option value="Khouribga">Khouribga</option>
                            <option value="Laâyoune">Laâyoune</option>
                            <option value="Larache">Larache</option>
                            <option value="Marrakech">Marrakech</option>
                            <option value="Meknès">Meknès</option>
                            <option value="Mohammedia">Mohammedia</option>
                            <option value="Nador">Nador</option>
                            <option value="Ouarzazate">Ouarzazate</option>
                            <option value="Oujda">Oujda</option>
                            <option value="Rabat">Rabat</option>
                            <option value="Safi">Safi</option>
                            <option value="Salé">Salé</option>
                            <option value="Tanger">Tanger</option>
                            <option value="Taza">Taza</option>
                            <option value="Tétouan">Tétouan</option>
                            <option value="Tiznit">Tiznit</option>
                        </select>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- chaque Client admet un modal -->
<?php foreach ($usersToShow as $item => $user) { ?>
    <!-- Modal Modifier Clients -->
    <div class="modal fade" id="modifierModal<?php echo "{$user['id']}"; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier Clients</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="modifier.php?id=<?php echo "{$user['id']}"; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nom">Nom :</label>
                            <input type="text" name="nom" class="form-control" value="<?php echo "{$user['nom']}"; ?>" placeholder="Nom de Client ..." required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prenom :</label>
                            <input type="text" name="prenom" class="form-control" value="<?php echo "{$user['prenom']}"; ?>" placeholder="Prenom de Client ..." required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="email" name="email" class="form-control" value="<?php echo "{$user['email']}"; ?>" placeholder="Email de Client ..." required>
                        </div>

                        <div class="form-group">
                            <label for="userType">Type d'utilisateur : <?php echo $user['user_type']; ?></label>
                            <select name='userType' class="form-control">
                                <option value='admin' <?php if($user['user_type'] == 'admin') echo 'selected'; ?>>Admin</option>
                                <option value='client' <?php if($user['user_type'] == 'client') echo 'selected'; ?>>Client</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="telephone">Téléphone :</label>
                            <input type="tel" name="telephone" class="form-control" value="<?php echo "{$user['telephone']}"; ?>" placeholder="Téléphone de Client ..." pattern="(05|06)[0-9]{8}" title="Veuillez saisir un numéro de téléphone valide au Maroc (format : 06XXXXXXXX pour les mobiles ou 05XXXXXXXX pour les fixes)" required>
                        </div>


                        <div class="form-group">
                            <label for="address">Address :</label>
                            <input type="text" name="address" class="form-control" value="<?php echo "{$user['address']}"; ?>" placeholder="Address de Client ..." required>
                        </div>

                        <!-- <div class="form-group">
                            <label for="password">Dernier mot de passe :</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Saisir le mot de passe du client..." required>
                        </div>

                        <button id="modifyPasswordBtn" class="btn btn-primary">Modifier mot de passe</button>

                        <div id="newPasswordFields" style="display: none;">
                            <div class="form-group">
                                <label for="newPassword">Nouveau mot de passe :</label>
                                <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="Saisir le nouveau mot de passe du client..." required>
                            </div>

                            <div class="form-group">
                                <label for="confirmNewPassword">Répéter le nouveau mot de passe :</label>
                                <input type="password" id="confirmNewPassword" name="confirmNewPassword" class="form-control" placeholder="Répéter le nouveau mot de passe du client..." required>
                            </div>
                        </div>

                        <script>
                            document.getElementById("modifyPasswordBtn").addEventListener("click", function() {
                                document.getElementById("newPasswordFields").style.display = "block";
                            });
                        </script> -->




                        <div class="form-group">
                            <label for="ville">Ville :</label>
                            <select name='ville' class="form-control">
                                <option value="Agadir" <?php if($user['ville'] == 'Agadir') echo 'selected'; ?>>Agadir</option>
                                <option value="Al Hoceima" <?php if($user['ville'] == 'Al Hoceima') echo 'selected'; ?>>Al Hoceima</option>
                                <option value="Asilah" <?php if($user['ville'] == 'Asilah') echo 'selected'; ?>>Asilah</option>
                                <option value="Azemmour" <?php if($user['ville'] == 'Azemmour') echo 'selected'; ?>>Azemmour</option>
                                <option value="Azrou" <?php if($user['ville'] == 'Azrou') echo 'selected'; ?>>Azrou</option>
                                <option value="Beni Mellal" <?php if($user['ville'] == 'Beni Mellal') echo 'selected'; ?>>Beni Mellal</option>
                                <option value="Berkane" <?php if($user['ville'] == 'Berkane') echo 'selected'; ?>>Berkane</option>
                                <option value="Berrechid" <?php if($user['ville'] == 'Berrechid') echo 'selected'; ?>>Berrechid</option>
                                <option value="Casablanca" <?php if($user['ville'] == 'Casablanca') echo 'selected'; ?>>Casablanca</option>
                                <option value="Chefchaouen" <?php if($user['ville'] == 'Chefchaouen') echo 'selected'; ?>>Chefchaouen</option>
                                <option value="Dakhla" <?php if($user['ville'] == 'Dakhla') echo 'selected'; ?>>Dakhla</option>
                                <option value="El Jadida" <?php if($user['ville'] == 'El Jadida') echo 'selected'; ?>>El Jadida</option>
                                <option value="Errachidia" <?php if($user['ville'] == 'Errachidia') echo 'selected'; ?>>Errachidia</option>
                                <option value="Essaouira" <?php if($user['ville'] == 'Essaouira') echo 'selected'; ?>>Essaouira</option>
                                <option value="Fès" <?php if($user['ville'] == 'Fès') echo 'selected'; ?>>Fès</option>
                                <option value="Guelmim" <?php if($user['ville'] == 'Guelmim') echo 'selected'; ?>>Guelmim</option>
                                <option value="Ifrane" <?php if($user['ville'] == 'Ifrane') echo 'selected'; ?>>Ifrane</option>
                                <option value="Kenitra" <?php if($user['ville'] == 'Kenitra') echo 'selected'; ?>>Kenitra</option>
                                <option value="Khemisset" <?php if($user['ville'] == 'Khemisset') echo 'selected'; ?>>Khemisset</option>
                                <option value="Khenifra" <?php if($user['ville'] == 'Khenifra') echo 'selected'; ?>>Khenifra</option>
                                <option value="Khouribga" <?php if($user['ville'] == 'Khouribga') echo 'selected'; ?>>Khouribga</option>
                                <option value="Laâyoune" <?php if($user['ville'] == 'Laâyoune') echo 'selected'; ?>>Laâyoune</option>
                                <option value="Larache" <?php if($user['ville'] == 'Larache') echo 'selected'; ?>>Larache</option>
                                <option value="Marrakech" <?php if($user['ville'] == 'Marrakech') echo 'selected'; ?>>Marrakech</option>
                                <option value="Meknès" <?php if($user['ville'] == 'Meknès') echo 'selected'; ?>>Meknès</option>
                                <option value="Mohammedia" <?php if($user['ville'] == 'Mohammedia') echo 'selected'; ?>>Mohammedia</option>
                                <option value="Nador" <?php if($user['ville'] == 'Nador') echo 'selected'; ?>>Nador</option>
                                <option value="Ouarzazate" <?php if($user['ville'] == 'Ouarzazate') echo 'selected'; ?>>Ouarzazate</option>
                                <option value="Oujda" <?php if($user['ville'] == 'Oujda') echo 'selected'; ?>>Oujda</option>
                                <option value="Rabat" <?php if($user['ville'] == 'Rabat') echo 'selected'; ?>>Rabat</option>
                                <option value="Safi" <?php if($user['ville'] == 'Safi') echo 'selected'; ?>>Safi</option>
                                <option value="Salé" <?php if($user['ville'] == 'Salé') echo 'selected'; ?>>Salé</option>
                                <option value="Tanger" <?php if($user['ville'] == 'Tanger') echo 'selected'; ?>>Tanger</option>
                                <option value="Taza" <?php if($user['ville'] == 'Taza') echo 'selected'; ?>>Taza</option>
                                <option value="Tétouan" <?php if($user['ville'] == 'Tétouan') echo 'selected'; ?>>Tétouan</option>
                                <option value="Tiznit" <?php if($user['ville'] == 'Tiznit') echo 'selected'; ?>>Tiznit</option>
                            </select>
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

<script>
    function openDrawer() {
        document.getElementById("drawer").style.width = "250px";
    }

    function closeDrawer() {
        document.getElementById("drawer").style.width = "0";
    }
</script>

</html>
