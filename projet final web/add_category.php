<?php
session_start();

require 'db.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];

    if (!empty($nom)) {
        // Ajouter la catégorie dans la base de données
        $stmt = $pdo->prepare("INSERT INTO categories (nom) VALUES (?)");
        $stmt->execute([$nom]);
        echo "Catégorie ajoutée avec succès.";
    } else {
        echo "Le champ nom de catégorie est requis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une catégorie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('library.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: #4A4A4A;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            flex-direction: column;
        }

        h1 {
            color: #6A4C9C; /* Lavender color */
            text-align: center;
            margin-top: 30px;
            font-size: 36px;
        }

        .links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 60px; /* Added margin to separate links from container */
        }

        .links a {
            padding: 14px 20px;
            background-color: #cc72be; /* Coral color */
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 18px;
            font-style: italic;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .links a:hover {
            background-color: #9e82b1; /* Slightly darker coral */
            transform: scale(1.1); /* Subtle zoom effect */
        }

        .container {
            width: 50%;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.7); /* Light background with transparency */
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #424147; /* Lavender color */
            font-weight: bold;
        }

        input[type="text"] {
            width: 90%; /* Consistent width for the text input */
            padding: 10px; /* Same padding for all input types */
            margin-bottom: 15px;
            border: 1px solid #ddd; /* Light border for inputs */
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 12px 25px;
            background-color: #ba61d1; /* Light green background */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #8e68a3; /* Darker light green on hover */
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #ba61d1; /* Light green background */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-style: italic;
        }

        a:hover {
            background-color: #8e68a3; /* Darker light green on hover */
        }
    </style>
</head>
<body>

<!-- Links at the top -->
<div class="links">
    <a href="ajouter_livre.php">Ajouter un livre</a>
    <a href="list_livres.php">Afficher la liste des livres</a>
    <a href="graphe.php">Statistiques des emprunts de livres par catégorie</a>
    <a href="listreserver_admin.php">Afficher les livres réservés</a>
    <a href="phplogin.php">Se déconnecter</a>
</div>


<!-- Main form container -->
<div class="container">
    <h1>Ajouter une catégorie de livre</h1>
    <form action="add_category.php" method="POST">
        <label for="nom">Nom de la catégorie:</label>
        <input type="text" id="nom" name="nom" placeholder="Entrez la catégorie" required>
        <input type="submit" value="Ajouter la catégorie">
    </form>

</div>

</body>
</html>



