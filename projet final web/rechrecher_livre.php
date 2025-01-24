<?php
session_start();
require 'db.php'; // Connexion à la base de données

// Initialisation des variables
$search_result = [];
$error_message = "";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Erreur: Vous devez être connecté pour rechercher des livres.";
    exit();
}

// Vérifier la soumission du formulaire de recherche
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
    if (!empty($search_term)) {
        // Préparer la requête SQL pour rechercher des livres par titre, auteur ou ISBN
        $stmt = $pdo->prepare("SELECT * FROM livres WHERE titre LIKE ? OR auteur LIKE ? OR isbn LIKE ?");
        $stmt->execute(["%$search_term%", "%$search_term%", "%$search_term%"]);
        $search_result = $stmt->fetchAll();

        // Vérification si la requête a renvoyé des résultats
        if (empty($search_result)) {
            $error_message = "Aucun livre trouvé.";
        }
    } else {
        $error_message = "Veuillez entrer un terme de recherche.";
    }
}

// Fonction pour vérifier si un utilisateur a emprunté un livre
function hasBorrowedBook($livre_id, $user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM loans WHERE livres_id = ? AND user_id = ? AND return_date IS NULL");
    $stmt->execute([$livre_id, $user_id]);
    return $stmt->rowCount() > 0;
}

// Emprunter un livre (action)
if (isset($_GET['livre_id']) && isset($_GET['user_id'])) {
    $livre_id = $_GET['livre_id'];
    $user_id = $_GET['user_id'];

    // Vérifier si l'utilisateur a déjà emprunté le livre
    if (!hasBorrowedBook($livre_id, $user_id)) {
        // Insérer un nouvel emprunt dans la base de données
        $stmt = $pdo->prepare("INSERT INTO loans (livres_id, user_id, loan_date) VALUES (?, ?, NOW())");
        $stmt->execute([$livre_id, $user_id]);

        // Rediriger vers une page de confirmation ou afficher un message
        header("Location: listreserver_livres.php");
        exit();
    } else {
        $error_message = "Vous avez déjà emprunté ce livre.";
    }
}
?>

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
        flex-direction: column; /* Ensure the page content is stacked */
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
        padding: 12px 25px;
        background-color: #bf5c5a;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        font-style: italic;
    }
    .links a:hover {
        background-color: #d57f5f; /* Slightly darker coral */
        transform: scale(1.1); /* Subtle zoom effect */
    }

    form {
        width: 60%;
        margin: 0 auto;
        padding: 30px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.9); /* Slight transparency for background */
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
        margin-top: 100px; /* Space below the header */
    }

    h1 {
        color: #433c3c;
        font-size: 32px;
        margin-bottom: 30px;
        font-weight: 600;
        text-align: center;
    }

    input[type="text"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus {
        border-color: #d57f5f;
        outline: none;
    }

    .button {
        padding: 12px 25px;
        background-color: #d67168;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .button:hover {
        background-color: #d57f5f;
        transform: scale(1.05); /* Slight zoom effect */
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

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .borrowed {
        background-color: #f44336;
        color: white;
        text-align: center;
    }

    .logout {
        background-color: red;
    }

    .logout:hover {
        background-color: #e03c3c; /* Slightly darker red for logout button */
    }
</style>


</head>
<body>
<div class="links">
    <a href="list_livres_client.php" class="link-button">Afficher les livres</a>
    <a href="listreserver_livres.php" class="link-button">Afficher les livres réservés</a>
    <a href="phplogin.php" class="link-button logout">Se déconnecter</a>
</div>


<form action="rechrecher_livre.php" method="POST">
    <h1>Rechercher un livre</h1>

    <label for="search_term">Entrez le titre, auteur ou ISBN</label>
    <input type="text" name="search_term" id="search_term" required>
    <button type="submit" name="search" class="button">Rechercher</button>
</form>

<?php if (!empty($error_message)): ?>
    <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
<?php endif; ?>

<?php if (!empty($search_result)): ?>
    <table>
        <thead>
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>ISBN</th>
            <th>Disponibilité</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($search_result as $livre): ?>
            <tr>
                <td><?= htmlspecialchars($livre['titre']) ?></td>
                <td><?= htmlspecialchars($livre['auteur']) ?></td>
                <td><?= htmlspecialchars($livre['isbn']) ?></td>
                <td>
                    <?php
                    if (hasBorrowedBook($livre['id'], $_SESSION['user_id'])) {
                        echo "<span class='borrowed'>Déjà emprunté</span>";
                    } else {
                        // Créez un lien pour emprunter directement le livre
                        echo "<a href='rechrecher_livre.php?livre_id={$livre['id']}&user_id={$_SESSION['user_id']}' class='button'>Emprunter</a>";
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
