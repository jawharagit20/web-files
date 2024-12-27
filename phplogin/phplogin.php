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
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: linear-gradient(120deg, #fccb90 0%, #d57eeb 100%);
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 800px;
            height: 400px;
            flex-direction: row-reverse;
        }

        .image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image img {
            max-width: 100%;
            max-height: 500px;
            border-radius: 8px;
        }

        .form-section {
            flex: 2;
            text-align: center;
        }

        h1 {
            margin-left: 0 px;
            margin-bottom: 15px;
        }

        input {
            width: 70%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #a6a4a4;
            border-radius: 8px;
            display: block;
        }

        button {
            padding: 12px 20px;
            background: linear-gradient(45deg, #b473bc, #8e44ad);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background-color: #4cae4c;
        }

        .erreur {
            margin: 10px 0;
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="image">
        <img src="user.jpg" alt="User Image">
    </div>
    <div class="form-section">
        <h1>Connexion</h1>
        <form method="POST">
            <input type="text" name="login" placeholder="Login" required><br/>
            <input type="password" name="password" placeholder="Password" required><br/>
            <button type="submit" name="valider">Se connecter</button>
        </form>

        <?php
        session_start();

        if (isset($_POST["valider"])) {
            $login = $_POST["login"];
            $password = $_POST["password"];
            $bonlogin = 'admin';
            $bonpassword = '123456';
            $erreur = "";

            // Check if login and password are empty
            if (empty($login) || empty($password)) {
                $erreur = "Les champs Login et Mot de passe sont requis.";
                echo "<div class='erreur'>$erreur</div>";
            } else {
                // Check if login and password are correct
                if ($login == $bonlogin && $password == $bonpassword) {
                    $_SESSION["autoriser"] = "oui";
                    header("location:phpbuttons.php");
                    exit();
                } else {
                    $erreur = "Login ou mot de passe incorrect";
                    echo "<div class='erreur'>$erreur</div>";
                }
            }
        }
        ?>
    </div>
</div>
</body>
</html>