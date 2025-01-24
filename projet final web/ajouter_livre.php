<?php
session_start();
require 'db.php'; // Connexion à la base de données

// Récupérer les catégories pour le menu déroulant
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

// Si le formulaire est soumis, insérer les données dans la base
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $isbn = $_POST['isbn'];
    $categorie_id = $_POST['categorie_id'];

    // Préparer et exécuter l'insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO livres (titre, auteur, isbn, categorie_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$titre, $auteur, $isbn, $categorie_id]);

    echo "<p>Le livre a été ajouté avec succès !</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un livre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('library.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: #ffffff;
            margin: 0;
            padding: 0;

        }

        h1 {
            color: #6A4C9C; /* Lavender color */
            text-align: center;
            margin-top: 30px;
            font-size: 36px;
        }

        form {
            width: 50%;
            margin: 20px auto;
            padding: 30px;
            border: 1px solid #ddd; /* Simple border for the form */
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.7); /* Light background with transparency */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #6A4C9C; /* Lavender color */
            font-weight: bold;
        }

        input, select {
            width: 90%; /* Consistent width for all inputs */
            padding: 10px; /* Same padding for all input types */
            margin-bottom: 15px;
            border: 1px solid #ddd; /* Light border for inputs */
            border-radius: 5px;
            font-size: 16px;
        }


        .button {
            padding: 12px 25px;
            background-color: #cc72be; /* Light green background */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .button:hover {
            background-color: #8e68a3; /* Darker light green on hover */
        }

        .links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
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

<!-- "Ajouter un livre" link at the top -->
<div class="links">
    <a href="add_category.php">Ajouter une catégorie</a>
    <a href="list_livres.php">Afficher la liste des livres</a>
    <a href="graphe.php">Statistiques des emprunts de livres par catégorie</a>
    <a href="listreserver_admin.php">Afficher les livres réservés</a>
    <a href="phplogin.php">Se déconnecter</a>
</div>


<form action="ajouter_livre.php" method="POST">
    <h1>Ajouter un livre</h1>
    <label for="titre">Titre:</label>
    <input type="text" name="titre" id="titre" placeholder="Entrez le titre" required>

    <label for="auteur">Auteur:</label>
    <input type="text" name="auteur" id="auteur" placeholder="Entrez l'auteur" required>

    <label for="isbn">ISBN:</label>
    <input type="text" name="isbn" id="isbn" PLACEHOLDER="Entrez le ISBN" required>

    <label for="categorie_id">Catégorie:</label>
    <select name="categorie_id" id="categorie_id" required>
        <option value="">Sélectionnez une catégorie</option>
        <?php foreach ($categories as $categorie) : ?>
            <option value="<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['nom']) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit" class="button">Ajouter le livre</button>
</form>

</body>
</html>



