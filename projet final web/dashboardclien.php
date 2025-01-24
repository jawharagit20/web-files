<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion des Livres</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('client.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        header {
            color: white;
            text-align: center;
            padding: 20px 0;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5); /* Transparence noire */
        }

        .container {
            background: rgba(255, 255, 255, 0.95); /* Fond blanc avec légère transparence */
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Ombre douce */
            text-align: center;
            width: 400px;
            margin-top: 100px; /* Espacement sous l'en-tête */
        }

        h1 {
            margin-bottom: 25px;
            color: #4A4A4A;
            font-size: 24px;
        }

        .links {
            display: flex;
            flex-direction: column;
            gap: 15px; /* Espacement entre les liens */
        }

        a {
            padding: 12px 20px;
            background-color: #d57f5f; /* Couleur verte */
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #9a6b45; /* Changement de couleur au survol */
        }

        a:active {
            transform: scale(0.98); /* Effet de clic */
        }

        footer {
            text-align: center;
            padding: 15px;
            background-color: transparent; /* Pas de fond */
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Bienvenue, réserve ton premier livre.</h1>
    <div class="links">
        <a href="list_livres_client.php" class="link-button">Afficher les livres</a>
        <a href="rechrecher_livre.php" class="link-button">Rechercher un livre</a>
        <a href="listreserver_livres.php" class="link-button">Afficher les livres réservés</a>
        <a href="phplogin.php" class="link-button">Se déconnecter</a>
    </div>
</div>



</body>
</html>


