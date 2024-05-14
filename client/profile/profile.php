<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email'])){
    header('location: login.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
}

include '../../include/functionsLoginRegistre.php';

if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
$user = userById($id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="profilCss.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <title>Éclat & Vitalité</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

<!-- header-->
<header>
    <div class="container d-flex justify-content-between align-items-center">

        <div style="margin-right: 15px;">
            <div class="logo-wrapper">
                <a href="../../index.php" style="text-align: center; text-decoration: none; color: #333; font-size: 22px; margin-top: 40px;"><h4 style=" margin-top: 10px;">Éclat & Vitalité</h4></a>
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
                            <a class="nav-link active custom" href="profile.php">Profil</a>
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
                            <a class="nav-link active custom" href="profile.php">Profil</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link  custom" href="../../login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../../registre.php">S'inscrire</a>
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
            <h6 style=" font-size: 22px; color: #333;">Éclat & Vitalité</h6>
        </div>

        <?php
        if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client") {
            // Suppose que vous avez un moyen de récupérer le nombre d'articles dans le panier (par exemple depuis une base de données)
            $nombre_articles_panier = isset($_SESSION['Nbt']) ? intval($_SESSION['Nbt']) : 0;?>

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

<div style=" width: 1px; height: 120px; background-color: #ffffff;"></div>
<!-- main contenu-->
<div class="main-content">
    <main>
        <div class="container">
            <?php
            if(isset($_GET['update'])&& $_GET['update']=="ok")
            echo "<div class='alert alert-success'> mis à jour avec succès !!!</div>";


            if(isset($_SESSION['email'])) {
                echo "<div class='title-and-button'>";
                echo "<h2 class='title'>Bienvenue  Client</h2>";
                echo "<p class='user-type'><i class='fas' style='color: #1e1e1e' > Type d'utilisateur : </i> " . htmlspecialchars($_SESSION['user_type']) . "</p>";
                echo "</div>";
            } else {
                echo "<p class='session-error'>Données de session introuvables.</p>";
            }
            ?>
        </div>
        <div class="container user-details">
            <?php
            if (count($user) > 0 ) {
                print
                    "<p><i class='fas fa-id-card' > ID : </i> " .' ' . htmlspecialchars($user['id']). "</p>" .
                    "<p><i class='fas fa-user'> Prenom & Nom : </i>  " .' ' .$user['prenom'] .' '.$user['nom'] . "</p>" .
                    "<p><i class='fas fa-envelope'> Email : </i>  " .' ' . htmlspecialchars($user['email']) . "</p>" .
                    "<p><i class='fas fa-map-marker-alt'> Adresse : </i>".' ' . htmlspecialchars($user['address']) . "</p>" .
                    "<p><i class='fas fa-phone'></i> Telephone : " . htmlspecialchars($user['telephone']) . "</p>".
                    "<p><i class='fas fa-city'> Ville : </i>" .' ' . htmlspecialchars($user['ville']) . "</p>";
            }
            ?>

        </div>

        <a href='modifer.php' data-bs-toggle='modal' data-bs-target='#modifierModal' ><button class='btn btn-success mt-2'>Modifier</button></a>
    </main>
</div>


<!-- chaque Client admet un modal -->
    <!-- Modal Modifier Clients -->
    <div class="modal fade" id="modifierModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier les Information</h1>
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
