<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #5e5cac;
            display: flex;
            justify-content: flex-end; /* Move container to the right */
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('biblio1.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.5);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 350px;
            height: auto;
            margin-right: 50px; /* Adjust the position */
        }

        .form-section {
            width: 100%;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center; /* Center inputs and buttons horizontally */
            height: 100%;
        }

        h1 {
            margin-bottom: 15px;
        }

        .input-group {
            display: flex;
            align-items: center;
            position: relative; /* Allows for icon positioning */
            max-width: 350px;  /* Make sure the input box doesn't grow too wide */
            margin: 10px auto;
        }

        .input-group img {
            width: 20px;
            height: 20px;
            position: absolute;
            left: 10px; /* Position icon inside input field */
        }

        .input-group input {
            width: 100%; /* Make the input box take the full width of the container */
            padding: 10px 12px 10px 40px;
            border: 1px solid #a6a4a4;
            border-radius: 8px;
        }

        /* Button container to arrange buttons horizontally */
        .button-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 350px;
            margin-top: 10px;
        }

        button {
            padding: 10px 18px;
            background: linear-gradient(45deg, #b473bc, #8e44ad);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            width: 48%;  /* Make buttons take 48% width of their container */
        }

        button:hover {
            background: linear-gradient(45deg, #9258a0, #7d3c98);
        }

        .erreur {
            margin: 10px 0;
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-section">
        <h1>Welcome to BiblioHub.</h1>
        <form method="POST">
            <div class="input-group">
                <img src="user-icon.png" alt="User Icon">
                <input type="text" name="login" placeholder="Login" required>
            </div>
            <div class="input-group">
                <img src="lock-icon.png" alt="Lock Icon">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <!-- Container for the buttons -->
            <div class="button-container">
                <button type="submit" name="valider">Se connecter comme admin</button>
                <button type="submit" name="client">Se connecter comme client</button>
            </div>
        </form>
    </div>
</div>
<?php
session_start();
require 'db.php'; // Connexion à la base de données

if (isset($_POST["valider"]) || isset($_POST["client"])) {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $erreur = "";

    if (empty($login) || empty($password)) {
        $erreur = "Les champs Login et Mot de passe sont requis.";
        echo "<div class='erreur'>$erreur</div>";
    } else {
        // Vérification des identifiants
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if ($user && $user['password'] === $password) { // Vérification du mot de passe
            $_SESSION["autoriser"] = "oui";
            $_SESSION["user_name"] = $user['username'];// Store the username in session
            $_SESSION['user_id'] = $user['id'];

            // Redirect based on the role
            if ($user['role'] === 'admin' && isset($_POST["valider"])) {
                header("location:dashboardadmin.php");
                exit();
            } elseif ($user['role'] === 'client' && isset($_POST["client"])) {
                header("location:dashboardclien.php");
                exit();
            } else {
                $erreur = "Vous n'avez pas les permissions requises.";
                echo "<div class='erreur'>$erreur</div>";
            }
        } else {
            $erreur = "Login ou mot de passe incorrect.";
            echo "<div class='erreur'>$erreur</div>";
        }
    }
}
?>
</body>
</html>

