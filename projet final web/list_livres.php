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
            font-family: Arial, sans-serif;
            background-image: url('library.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .container {
            width: 80%; /* Élargir la largeur du conteneur à 80% de l'écran */
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9); /* Légère transparence */
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #6A4C9C;
            font-size: 36px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 16px; /* Augmenter les espaces dans les cellules */
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #c5b3d3;
            color: #6A4C9C;
        }

        .actions {
            text-align: center;
        }

        .button {
            padding: 8px 15px;
            margin: 5px;
            text-decoration: none;
            background-color: #d89765;
            color: white;
            border-radius: 5px;
            font-size: 14px;
            display: inline-block;
        }

        .button:hover {
            background-color: #9f7b5f;
        }

        .links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
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

    </style>
</head>
<body>

<div class="links">
    <a href="ajouter_livre.php">Ajouter un livre</a>
    <a href="add_category.php">Ajouter une catégorie</a>
    <a href="listreserver_admin.php">Afficher les livres réservés</a>
    <a href="graphe.php">Statistiques des emprunts de livres par catégorie</a>
    <a href="phplogin.php">Se déconnecter</a>

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
            <th>Actions</th>
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
                <td class="actions">
                    <a class="button" href="modifier_livre.php?id=<?= $livre['id'] ?>">Modifier</a>
                    <a class="button" href="supprimer_livre.php?id=<?= $livre['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>

