<?php
session_start();

require 'db.php'; // Connexion à la base de données

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer le livre à modifier
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
    $stmt->execute([$id]);
    $livre = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titre = $_POST['titre'];
        $auteur = $_POST['auteur'];
        $isbn = $_POST['isbn'];

        // Mettre à jour le livre
        $stmt = $pdo->prepare("UPDATE livres SET titre = ?, auteur = ?, isbn = ? WHERE id = ?");
        $stmt->execute([$titre, $auteur, $isbn, $id]);

        echo "Livre modifié avec succès.";
    }
} else {
    echo "Livre non trouvé.";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le livre</title>
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
            height: 100vh;
            flex-direction: column;
        }

        h1 {
            color: #6A4C9C; /* Lavender color */
            margin-top: 0;
            font-size: 36px;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 500px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #333;
            text-align: left;
        }

        input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 12px 20px;
            background-color: #9f7b60;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;

        }

        button:hover {
            background-color: #d89765;
        }

        a {
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #cc72be;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            font-style: italic;
        }

        a:hover {
            background-color: #8e68a3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Modifier le livre</h1>
    <form method="POST">
        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($livre['titre']) ?>" required>

        <label for="auteur">Auteur :</label>
        <input type="text" id="auteur" name="auteur" value="<?= htmlspecialchars($livre['auteur']) ?>" required>

        <label for="isbn">ISBN :</label>
        <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($livre['isbn']) ?>" required>

        <button type="submit">Modifier</button>
    </form>
    <a href="list_livres.php">Retour à la liste des livres</a>
</div>

</body>
</html>

