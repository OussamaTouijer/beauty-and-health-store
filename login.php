<?php
session_start();

// Vérification de l'authentification
if (isset($_SESSION['email']) && $_SESSION['user_type']=="client"){
    header('location: profile.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
}

if (isset($_SESSION['email']) && $_SESSION['user_type']=="admin"){
    header('location:admin/profile/profile.php');//rederection
    exit(); // Assurez-vous de sortir après avoir redirigé
}

include 'include/functionsProductCate.php';
include 'include/functionsLoginRegistre.php';

$categories = getAllCategories();

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

            header('location:profile.php');//rederection
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
    <title>Éclat &amp; Vitalité</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.7/sweetalert2.all.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
</head>
<body>
<!-- Navigation dans l'en-tête -->
<?php include 'include/header.php'?>

<!-- Formulaire -->
<div class="col-12 p-5">
    <h1 class="text-center">Connexion</h1>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

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
</html>
