<?php
session_start();
session_unset(); // suppression des variables de session
session_destroy(); // suppression des sessions

header('location: ../login.php'); // Correction : enlever l'espace après 'location'
exit(); // Assurez-vous de sortir après la redirection du header
?>
