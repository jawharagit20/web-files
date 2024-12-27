<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion StudyLobby</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(to top, #7028e4 0%, #e5b2ca 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background : white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        button {
            padding: 12px;
            background: #ebc0fd;
            color: black;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background: darkgray;
        }

        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Gestion StudyLobby</h1>
    <div class="buttons">
        <button onclick="location.href='phpsqlTD1.php'">Ajouter Étudiant</button>
        <button onclick="location.href='phpetabli.php'">Ajouter Établissement</button>
        <button onclick="location.href='affichagesql.php'">Afficher les Étudiants</button>
        <button onclick="location.href='afficheretabli.php'">Afficher les Établissements</button>
    </div>
</div>
</body>
</html>
