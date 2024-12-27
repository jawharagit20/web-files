<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: linear-gradient(to top, #ebc0fd 0%, #d9ded8 100%);
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #8e44ad;
            color: white;
        }

        td {
            background-color: #f3f3f3;
        }

        tr:hover {
            background-color: #ebc0fd;
        }

        button {
            padding: 8px 16px;
            background-color: #b473bc;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: pink;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        a {
            text-decoration: none;
        }

        .message, .erreur {
            font-size: 16px;
            margin-top: 20px;
        }

        .message {
            color: green;
            font-weight: bold;
        }

        .erreur {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Liste des Étudiants</h1>

    <?php
    try {
        // Connexion à la base de données
        $db = new PDO('mysql:host=localhost;dbname=studylobby', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Gestion de la suppression
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $stmt = $db->prepare("DELETE FROM etudiants WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "<div class='message'>Étudiant supprimé avec succès.</div>";
            } else {
                echo "<div class='erreur'>Erreur : étudiant introuvable.</div>";
            }
        }

        // Récupération de la liste des étudiants
        $stmt = $db->prepare("SELECT * FROM etudiants");
        $stmt->execute();
        $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Affichage de la liste des étudiants
        if (count($etudiants) > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Date de Naissance</th><th>Lieu de Naissance</th><th>Email</th><th>Filière</th><th>Actions</th></tr>";
            foreach ($etudiants as $etudiant) {
                echo "<tr>
                        <td>{$etudiant['id']}</td>
                        <td>{$etudiant['nom']}</td>
                        <td>{$etudiant['prenom']}</td>
                        <td>{$etudiant['date_naissance']}</td>
                        <td>{$etudiant['lieu_naissance']}</td>
                        <td>{$etudiant['email']}</td>
                        <td>{$etudiant['filiere']}</td>
                        <td>
                            <div class='action-buttons'>
                            <form method='POST' action='modifier.php' style='display:inline;'>
                                    <input type='hidden' name='id' value='{$etudiant['id']}'>
                                    <button type='submit'>Modifier</button>
                                </form>
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='id' value='{$etudiant['id']}'>
                                    <button type='submit'>Supprimer</button>
                                </form>
                            </div>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='erreur'>Aucun étudiant trouvé.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='erreur'>Erreur : " . $e->getMessage() . "</div>";
    }
    ?>

    <a href="phpsqlTD1.php">
        <button>Retour au formulaire</button>
    </a>
</div>
</body>
</html>

