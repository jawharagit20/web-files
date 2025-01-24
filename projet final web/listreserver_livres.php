<?php
session_start();
require 'db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Erreur: Vous devez être connecté pour afficher vos livres réservés.";
    exit();
}

// Fonction pour obtenir les livres empruntés par l'utilisateur
function getBorrowedBooks($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT l.id AS loan_id, b.titre, b.auteur, b.isbn, l.loan_date, l.return_date FROM loans l 
                           JOIN livres b ON l.livres_id = b.id 
                           WHERE l.user_id = ? AND l.return_date IS NULL");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

// Retourner un livre (mise à jour de la date de retour)
if (isset($_GET['return_id'])) {
    $loan_id = $_GET['return_id'];

    // Mettre à jour la date de retour dans la base de données
    $stmt = $pdo->prepare("UPDATE loans SET return_date = NOW() WHERE id = ?");
    $stmt->execute([$loan_id]);

    // Rediriger vers la liste des livres réservés
    header("Location: listreserver_livres.php");
    exit();
}

// Obtenir les livres empruntés
$borrowed_books = getBorrowedBooks($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Livres Empruntés</title>
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
            flex-direction: column;
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
            background-color: #FF7F50;
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
    <a href="list_livres_client.php" class="button">Afficher les livres</a>
    <a href="rechrecher_livre.php" class="button">Rechercher un livre</a>
    <a href="phplogin.php" class="button return">Se déconnecter</a>
</div>
<div class="container">
<h1>Mes Livres Empruntés</h1>

<?php if (empty($borrowed_books)): ?>
    <p>Aucun livre emprunté.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>ISBN</th>
            <th>Date d'emprunt</th>
            <th>Date de retour</th>
            <th>Action</th>
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
                    <?php if ($book['return_date'] === null): ?>
                        <span>Non retourné</span>
                    <?php else: ?>
                        <?= htmlspecialchars($book['return_date']) ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($book['return_date'] === null): ?>
                        <!-- Ajouter un bouton pour retourner le livre -->
                        <a href="listreserver_livres.php?return_id=<?= $book['loan_id'] ?>" class="button return">Retourner</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</div>

</body>
</html>
