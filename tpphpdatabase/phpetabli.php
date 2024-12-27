<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Établissement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(to top, #7028e4 0%, #e5b2ca 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 600px;
            margin-right: 10px;
            margin-bottom: 20px;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #b473bc;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background: darkgray;
        }

        .message {
            margin: 15px 0;
            font-size: 14px;
        }

        .success {
            color: green;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Ajouter un Établissement</h1>
    <form method="POST" action="">
        <input type="text" name="nom_etablissement" placeholder="Nom de l'établissement" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit" name="ajouter">Ajouter</button>
    </form>
<?php include 'buttons.php'; ?>
    <?php
    try {
        // Connexion à la base de données
        $db = new PDO('mysql:host=localhost;dbname=studylobby', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
            $nom_etablissement = $_POST['nom_etablissement'];
            $email = $_POST['email'];

            $stmt = $db->prepare("INSERT INTO etablissements (nom_etablissement, email) VALUES (:nom_etablissement, :email)");
            $stmt->execute([
                'nom_etablissement' => $nom_etablissement,
                'email' => $email
            ]);

            echo "<div class='success'>Établissement ajouté avec succès !</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='error'>Erreur : " . $e->getMessage() . "</div>";
    }
    ?>
</div>
</body>
</html>
