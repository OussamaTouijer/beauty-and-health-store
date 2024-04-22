<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["userType"]) && !empty($_POST["telephone"]) && !empty($_POST["address"]) && !empty($_POST["password"]) && !empty($_POST["password1"]) && !empty($_POST["ville"])) {
        // Retrieve form data
        $nom = htmlspecialchars($_POST["nom"]);
        $prenom = htmlspecialchars($_POST["prenom"]);
        $email = htmlspecialchars($_POST["email"]);
        $userType = htmlspecialchars($_POST["userType"]);
        $telephone = htmlspecialchars($_POST["telephone"]);
        $address = htmlspecialchars($_POST["address"]);
        $password = htmlspecialchars($_POST["password"]);
        $password1 = htmlspecialchars($_POST["password1"]);
        $ville = htmlspecialchars($_POST["ville"]);

        // Check if passwords match
        if ($password != $password1) {
            header('location:listeCustomers.php?ajout=Mok');
            exit;
        }

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Database connection
        require_once '../../include/functionsProductCate.php';
        $conn = connectToDatabase(); // Modify this function according to your database connection method

        // Check if email already exists
        $sql_check_email = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt_check_email = $conn->prepare($sql_check_email);
        $stmt_check_email->bindParam(':email', $email);
        $stmt_check_email->execute();
        $email_exists = $stmt_check_email->fetchColumn();

        if ($email_exists) {
            header('location:listeCustomers.php?ajout=Nok');
            exit;
        }

        // Insert data into the users table
        if ($conn) {
            try {
                $sql_insert = "INSERT INTO users (nom, prenom, email, password, user_type, telephone, address, ville) VALUES (:nom, :prenom, :email, :password, :userType, :telephone, :address, :ville)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bindParam(':nom', $nom);
                $stmt_insert->bindParam(':prenom', $prenom);
                $stmt_insert->bindParam(':email', $email);
                $stmt_insert->bindParam(':password', $hashedPassword);
                $stmt_insert->bindParam(':userType', $userType);
                $stmt_insert->bindParam(':telephone', $telephone);
                $stmt_insert->bindParam(':address', $address);
                $stmt_insert->bindParam(':ville', $ville);

                if ($stmt_insert->execute()) {
                    header('location:listeCustomers.php?ajout=ok'); // Redirect to a success page
                    exit;
                } else {
                    echo "Erreur lors de l'ajout de l'utilisateur.";
                }

                $stmt_insert->closeCursor();
                $conn = null;
            } catch (PDOException $e) {
                echo "Erreur: " . $e->getMessage();
            }
        } else {
            echo "Erreur de connexion à la base de données.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}

?>
