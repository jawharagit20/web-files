<?php
session_start();
require 'db.php'; // Connexion à la base de données

// Récupérer les livres avec leurs catégories
$stmt = $pdo->query("SELECT livres.id, livres.titre, livres.auteur, livres.isbn, categories.nom AS categorie
                     FROM livres
                     JOIN categories ON livres.categorie_id = categories.id");
$livres = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des livres</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('client.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden; /* Prevent scrollbars */
        }

        .links {
            position: absolute;
            top: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 20px;
            z-index: 10; /* Ensure links stay on top */
        }

        .links a {
            padding: 14px 25px;
            background-color: #ed8686; /* Coral color */
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 18px;
            font-style: italic;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .links a:hover {
            background-color: #d57f5f; /* Slightly darker coral */
            transform: scale(1.1); /* Subtle zoom effect */
        }

        .container {
            background: rgba(255, 255, 255, 0.85);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Stronger shadow */
            text-align: center;
            width: 80%;
            margin-top: 100px;
            transition: transform 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px); /* Lift effect */
        }

        h1 {
            margin-bottom: 30px;
            color: #7e5533;
            font-size: 36px;
            letter-spacing: 1px;
            font-weight: 600;

        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: separate;
            border-spacing: 0;
            background-color: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        th, td {
            padding: 18px 30px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 16px;
            font-weight: 500;
        }

        th {
            background-color: #975e5e; /* Coral header */
            color: white;
            text-transform: uppercase;
            font-weight: bold;
        }



        tr:hover {
            background-color: #f1f1f1; /* Slight highlight effect */
        }




    </style>


</head>
<body>
<div class="links">
    <a href="rechrecher_livre.php">Rechercher un livre</a>
    <a href="listreserver_livres.php">Afficher les livres réservés</a>
    <a href="phplogin.php" style="background-color: red;">Se déconnecter</a>
</div>

<div class="container">

    <h1>Liste des livres</h1>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Auteur</th>
            <th>ISBN</th>
            <th>Catégorie</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($livres as $livre) : ?>
            <tr>
                <td><?= htmlspecialchars($livre['id']) ?></td>
                <td><?= htmlspecialchars($livre['titre']) ?></td>
                <td><?= htmlspecialchars($livre['auteur']) ?></td>
                <td><?= htmlspecialchars($livre['isbn']) ?></td>
                <td><?= htmlspecialchars($livre['categorie']) ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>



</body>
</html>
