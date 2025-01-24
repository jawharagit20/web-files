<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion StudyLobby</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('library.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.95); /* Fond blanc avec légère transparence */
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Ombre douce */
            text-align: center;
            width: 400px;
        }

        h1 {
            margin-bottom: 25px;
            color: #4A4A4A; /* Couleur neutre pour le titre */
            font-size: 24px;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 20px; /* Espacement entre les boutons */
        }

        button {
            padding: 12px 20px;
            background: #ebc0fd; /* Couleur pastel lavande */
            color: #333;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: #c89ce5; /* Couleur plus foncée au survol */
            color: white;
        }

        button:active {
            transform: scale(0.95); /* Effet de clic */
        }

        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="buttons">
        <button onclick="location.href='ajouter_livre.php'">Ajouter un livre</button>
        <button onclick="location.href='add_category.php'">Ajouter une catégorie</button>
        <button onclick="location.href='list_livres.php'">Afficher les livres</button>
        <button onclick="location.href='listreserver_admin.php'">Afficher les livres réservés</button>
        <button onclick="location.href='graphe.php'">Statistiques des emprunts de livres par catégorie</button>
        <button onclick="location.href='phplogin.php'">Se déconnecter</button>

    </div>
</div>
</body>
</html>



