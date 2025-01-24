<?php
session_start();
require 'db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Erreur: Vous devez être connecté pour afficher vos livres réservés.";
    exit();
}

// Définir le rôle comme "admin" pour tous les utilisateurs
$_SESSION['role'] = 'admin'; // Attribuer le rôle admin à l'utilisateur

// Assigner le rôle à la variable $role à partir de la session
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Fonction pour obtenir les livres empruntés
function getAllBorrowedBooks($role, $user_id) {
    global $pdo;

    try {
        if ($role == 'admin') {
            // Si l'utilisateur est un admin, on récupère tous les emprunts
            $stmt = $pdo->query("SELECT l.id AS loan_id, b.titre, b.auteur, b.isbn, l.loan_date, l.return_date, u.id AS emprunteur_id
                                 FROM loans l
                                 JOIN livres b ON l.livres_id = b.id
                                 JOIN users u ON l.user_id = u.id
                                 ORDER BY l.loan_date DESC");
        } else {
            // Si l'utilisateur est un utilisateur régulier, on récupère seulement ses propres emprunts
            $stmt = $pdo->prepare("SELECT l.id AS loan_id, b.titre, b.auteur, b.isbn, l.loan_date, l.return_date, u.id AS emprunteur_id
                                 FROM loans l
                                 JOIN livres b ON l.livres_id = b.id
                                 JOIN users u ON l.user_id = u.id
                                 WHERE l.user_id = ? 
                                 ORDER BY l.loan_date DESC");
            $stmt->execute([$user_id]);
        }

        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Erreur de requête : " . $e->getMessage();
        exit();
    }
}

// Obtenir tous les emprunts selon le rôle
$borrowed_books = getAllBorrowedBooks($role, $user_id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Emprunts</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('library.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .links {
            position: absolute;
            top: 20px;
            width: 80%;
            display: flex;
            justify-content: center;
            gap: 20px;
            z-index: 10; /* Ensure links stay on top */
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

        h1 {
            color: #433c3c;
            font-size: 32px;
            margin-bottom: 30px;
            font-weight: 600;
            text-align: center; /* Center-align the header */
        }

        table {
            width: 80%;
            margin-top: 40px;
            border-collapse: separate;
            border-spacing: 0;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px 25px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 16px;
            font-weight: 500;
        }

        th {
            background-color: #9e82b1;
            color: white;
            text-transform: uppercase;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
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

        .button {
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
            transform: scale(1.05); /* Slight zoom effect */
        }

        .return {
            background-color: #f44336;
        }

        .return:hover {
            background-color: #e03c3c; /* Slightly darker red for return button */
        }
    </style>
</head>
<body>
<div class="links">
    <a href="ajouter_livre.php">Ajouter un livre</a>
    <a href="add_category.php">Ajouter une catégorie</a>
    <a href="list_livres.php">Afficher la liste des livres</a>
    <a href="graphe.php">Statistiques des emprunts de livres par catégorie</a>
    <a href="phplogin.php">Se déconnecter</a>
</div>
<div class="container">
    <h1>Gestion des Emprunts</h1>

    <?php if (empty($borrowed_books)): ?>
        <p>Aucun livre emprunté actuellement.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>ISBN</th>
                <th>Date d'emprunt</th>
                <th>Date de retour</th>
                <th>Emprunteur (ID)</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($borrowed_books as $book): ?>
                <tr>
                    <td><?= htmlspecialchars($book['titre']) ?></td>
                    <td><?= htmlspecialchars($book['auteur']) ?></td>
                    <td><?= htmlspecialchars($book['isbn']) ?></td>
                    <td><?= htmlspecialchars($book['loan_date']) ?></td>
                    <td>
                        <?= $book['return_date'] ? htmlspecialchars($book['return_date']) : "Non retourné" ?>
                    </td>
                    <td><?= htmlspecialchars($book['emprunteur_id']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
