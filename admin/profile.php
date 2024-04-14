<?php
session_start();

// Vérification de l'authentification
if (!isset($_SESSION['email'])){
    header('location: login.php');
    exit(); // Assurez-vous de sortir après avoir redirigé
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éclat & Vitalité (Admin)</title>
    <link rel="stylesheet" href="stylesProfile.css">
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
                    <a class="nav-link active" href="profile.php">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="categorise/listeCategorise.php">
                        <i class="fas fa-th-list"></i> Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produits/listeProduits.php">
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
                    echo '<span class="username"><a class="nav-link active btn btn-primary" aria-current="page" href="deconnexion.php" style="margin-left: 10px;">Déconnexion</a></span>';
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
                    print '';
                    echo "<h1>Bienvenue"." Administrateur. </h1>";
                    echo "<p>Email: " . htmlspecialchars($_SESSION['email']) . "</p>";
                    echo "<p>Prénom: " . htmlspecialchars($_SESSION['prenom']) . "</p>";
                    echo "<p>Nom: " . htmlspecialchars($_SESSION['nom']) . "</p>";
                    echo "<p>Type d'utilisateur: " . htmlspecialchars($_SESSION['user_type']) . "</p>";
                    echo "<p>ID: " . htmlspecialchars($_SESSION['id']) . "</p>";
                    echo "<p>Adresse: " . htmlspecialchars($_SESSION['address']) . "</p>";
                    echo "<p>Ville: " . htmlspecialchars($_SESSION['ville']) . "</p>";
                } else {
                    echo "<p>Session data not found.</p>";
                }
                ?>
            </div>
        </main>
    </div>
</div>
</body>
</html>
