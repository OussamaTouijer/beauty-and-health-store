<?php
session_start();

// Vérification de l'authentification
if (isset($_SESSION['email']) && $_SESSION['user_type']=="client"){
    $id = $_SESSION['id']; // Récupère l'ID de la session
    header("Location: client/profile/profile.php");
    exit(); // Assurez-vous de sortir après avoir redirigé
}

if (isset($_SESSION['email']) && $_SESSION['user_type']=="admin"){
    $id = $_SESSION['id']; // Récupère l'ID de la session
    header('location:admin/profile/profile.php');//rederection
    exit(); // Assurez-vous de sortir après avoir redirigé
}


include 'include/functionsLoginRegistre.php';


$user = true;

if (!empty($_POST)) {
    $user = connectUser($_POST);
    if (is_array($user)) {
        if (count($user) > 0 && $user['user_type']=="client") {
            $_SESSION['email']=$user['email'];
            $_SESSION['prenom']=$user['prenom'];
            $_SESSION['nom']=$user['nom'];
            $_SESSION['user_type']=$user['user_type'];
            $_SESSION['id']=$user['id'];
            $_SESSION['address']=$user['address'];
            $_SESSION['ville']=$user['ville'];

            header("Location: index.php");
        }

        if (count($user) > 0 && $user['user_type']=="admin") {
            $_SESSION['email']=$user['email'];
            $_SESSION['prenom']=$user['prenom'];
            $_SESSION['nom']=$user['nom'];
            $_SESSION['user_type']=$user['user_type'];
            $_SESSION['id']=$user['id'];
            $_SESSION['address']=$user['address'];
            $_SESSION['ville']=$user['ville'];

            header('location:admin/profile/profile.php');//rederection
        }

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

<body style="background-color: #f4f4f4">


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
                            <a class="nav-link  active custom" href="login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  custom" href="registre.php">S'inscrire</a>
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
                            <a class="nav-link active custom" href="login.php">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  custom" href="registre.php">S'inscrire</a>
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
    height: 86px;
    background-color: #f4f4f4;">

</div>

<main style="background-color: #f4f4f4">
    <div class="container d-flex justify-content-center align-items-center" style="background-color: #f4f4f4">
        <div class="container-fluid py-1 mt-1">
            <div class="col-12 p-5" style="background-color: #eeeeee; border-radius: 25px;">
                <span class="title">Connexion</span>
                <form action="" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                        <div class="invalid-feedback">
                            Veuillez entrer une adresse email valide.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="invalid-feedback">
                            Veuillez entrer votre mot de passe.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</main>


<!-- Footer -->
<?php include 'include/footer.php'?>

<?php
// Si la connexion a échoué, afficher un message d'erreur avec SweetAlert
if(!$user){
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Identifiants non valides!',
            text: 'Le mot de passe ou lemail nest pas valide.',
            confirmButtonText: 'ok',
            timer: 2000 // Durée pendant laquelle le message sera affiché (en millisecondes)
        });
        </script>";
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
