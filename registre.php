<?php
session_start();

// Vérification de l'authentification
if (isset($_SESSION['email']) && $_SESSION['user_type']=="client"){
    $id = $_SESSION['id']; // Récupère l'ID de la session
    header("Location: client/profile/profile.php?id={$id}");
    exit(); // Assurez-vous de sortir après avoir redirigé
}

if (isset($_SESSION['email']) && $_SESSION['user_type']=="admin"){
    $id = $_SESSION['id']; // Récupère l'ID de la session
    header('location:admin/profile/profile.php?id={$id}');//rederection
    exit(); // Assurez-vous de sortir après avoir redirigé
}


include 'include/functionsLoginRegistre.php';


$ShowRegistrationAlert = 0;
if (!empty($_POST)) {
    if (InsertClients($_POST)) {
        $ShowRegistrationAlert = 1;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet" />
    <title>Éclat & Vitalité</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>


<!-- header-->
<header>
    <div class="container d-flex justify-content-between align-items-center">

        <div style="margin-right: 15px;">
            <div class="logo-wrapper">
                <a href="index.php" style="text-align: center; text-decoration: none; color: #333; font-size: 22px; margin-top: 40px;"><h4 style=" margin-top: 10px;">Éclat & Vitalité</h4></a>
            </div>
        </div>


        <div class="container">

            <nav class="p-1">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link  custom" href="client/home/home.php">Home</a>
                    </li>

                    <?php if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client"): ?>
                        <li class="nav-item">
                            <a class="nav-link custom" href="../profile/profile.php?id=<?php $id=$_SESSION['id']; echo $id;?>">Profil</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link  custom" href="login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active custom" href="registre.php">S'inscrire</a>
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
            $nombre_articles_panier =0 ;/* code pour récupérer le nombre d'articles dans le panier */
            ?>

            <div class="user-wrapper">
                <a href="../panier/panier.php">
                    <i class="fas fa-shopping-cart">Panier</i>
                </a>
                <!-- Affiche le nombre d'articles dans le panier -->
                <span>(<?php echo $nombre_articles_panier; ?>)</span>

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
                        <a class="nav-link  custom" href="client/home/home.php">Home</a>
                    </li>

                    <?php if(isset($_SESSION['email']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "client"): ?>
                        <li class="nav-item">
                            <a class="nav-link  custom" href="../profile/profile.php">Profil</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link  custom" href="login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active custom" href="registre.php">S'inscrire</a>
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
            $nombre_articles_panier =0 ;/* code pour récupérer le nombre d'articles dans le panier */
            ?>

            <div class="user-wrapper">
                <a href="../panier/panier.php">
                    <i class="fas fa-shopping-cart">Panier</i>
                </a>
                <!-- Affiche le nombre d'articles dans le panier -->
                <span>(<?php echo $nombre_articles_panier; ?>)</span>

                <a class="logout-btn" href="../../deconnexion.php">Déconnexion</a>
            </div>
            <?php
        }
        ?>
    </div>
</header>



<div class="container mt-3" style="     width: 1px;
    height: 20px;
    background-color: #ffffff;">

</div>


<!-- formulaire -->
<div class="col-12 p-5">
    <h1 class="text-center">Inscription</h1>
    <form action="registre.php" method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" class="form-control" id="telephone" name="telephone">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="address" name="address">
        </div>
        <div class="mb-3">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" class="form-control" id="ville" name="ville">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
            <div id="emailHelp" class="form-text">Nous ne partagerons jamais votre adresse e-mail avec qui que ce soit.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>

<!-- footer -->
<?php include 'include/footer.php'?>

<?php
// Après avoir ajouté l'utilisateur avec succès dans la base de données
// Afficher un message de réussite à l'aide de SweetAlert
if ($ShowRegistrationAlert == 1) {
    echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Création de compte réussie !',
                text: 'Vous êtes maintenant inscrit.',
                showConfirmButton: false,
                timer: 2000 // Spécifiez la durée pendant laquelle le message sera affiché (en millisecondes)
            }).then((result) => {
                window.location.href = 'login.php'; // Redirection après la fermeture de la boîte de dialogue
            });
        </script>";
    $ShowRegistrationAlert = 0; // Correction de l'affectation de la variable
}
?>
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
