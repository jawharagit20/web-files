<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Afficher les établissements et les étudiants</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #5e5cac;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: linear-gradient(to top, #cd9cf2 0%, #f6f3ff 100%);
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 800px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:hover {
            background-color: lavenderblush;
        }

        .message {
            margin: 15px 0;
            color: green;
            font-size: 14px;
        }

        .erreur {
            margin: 10px 0;
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Liste des Établissements et leurs Étudiants</h1>
<?php include 'buttons.php'; ?>
    <?php
    try {
        // Connexion à la base de données
        $db = new PDO('mysql:host=localhost;dbname=studylobby', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $db->query("
            SELECT etablissements.id AS etab_id, etablissements.nom_etablissement, etablissements.email AS etab_email,
                   etudiants.id AS etudiant_id, etudiants.nom AS etudiant_nom, etudiants.prenom AS etudiant_prenom
            FROM etablissements
            LEFT JOIN etudiants ON etablissements.id = etudiants.id_etablissement
        ");


        echo "<table>";
        echo "<tr><th>ID Établissement</th><th>Nom de l'Établissement</th><th>Email Établissement</th><th>ID Étudiant</th><th>Nom Étudiant</th><th>Prénom Étudiant</th></tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['etab_id'] . "</td>";
            echo "<td>" . $row['nom_etablissement'] . "</td>";
            echo "<td>" . $row['etab_email'] . "</td>";
            echo "<td>" . ($row['etudiant_id'] ? $row['etudiant_id'] : 'Aucun') . "</td>";
            echo "<td>" . ($row['etudiant_nom'] ? $row['etudiant_nom'] : 'Aucun') . "</td>";
            echo "<td>" . ($row['etudiant_prenom'] ? $row['etudiant_prenom'] : 'Aucun') . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } catch (PDOException $e) {
        echo "<div class='erreur'>Erreur : " . $e->getMessage() . "</div>";
    }
    ?>
</div>

</body>
</html>
