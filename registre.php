<?php
session_start();

// Vérification de l'authentification
if (isset($_SESSION['email'])){
    header('location: profile.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
}

include 'include/functionsProductCate.php';
include 'include/functionsLoginRegistre.php';

$categories = getAllCategories();

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<!-- navigation in header -->
<?php include 'include/header.php'?>

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
</html>
