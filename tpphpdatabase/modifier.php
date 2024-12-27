<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Étudiant</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: linear-gradient(to top, #ebc0fd 0%, #d9ded8 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            padding: 10px 20px;
            background-color: #8e44ad;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: pink;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Modifier Étudiant</h1>
    <?php include 'buttons.php'; ?>
    <?php
    try {
        $db = new PDO('mysql:host=localhost;dbname=studylobby', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];

            // Récupération des données de l'étudiant
            $stmt = $db->prepare("SELECT * FROM etudiants WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($etudiant) {
                echo "
                <form method='POST' action='modifier.php'>
                    <input type='hidden' name='id' value='{$etudiant['id']}'>
                    <input type='text' name='nom' value='{$etudiant['nom']}' required>
                    <input type='text' name='prenom' value='{$etudiant['prenom']}' required>
                    <input type='date' name='date_naissance' value='{$etudiant['date_naissance']}' required>
                    <input type='text' name='lieu_naissance' value='{$etudiant['lieu_naissance']}' required>
                    <input type='email' name='email' value='{$etudiant['email']}' required>
                    <input type='text' name='filiere' value='{$etudiant['filiere']}' required>
                    <button type='submit' name='update'>Mettre à jour</button>
                </form>";
            } else {
                echo "<div style='color: red;'>Étudiant introuvable.</div>";
            }
        } elseif (isset($_POST['update'])) {
            // Mise à jour des données
            $stmt = $db->prepare("
                UPDATE etudiants 
                SET nom = :nom, prenom = :prenom, date_naissance = :date_naissance, 
                    lieu_naissance = :lieu_naissance, email = :email, filiere = :filiere 
                WHERE id = :id
            ");
            $stmt->execute([
                'id' => $_POST['id'],
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'date_naissance' => $_POST['date_naissance'],
                'lieu_naissance' => $_POST['lieu_naissance'],
                'email' => $_POST['email'],
                'filiere' => $_POST['filiere']
            ]);

            echo "<div style='color: green;'>Étudiant mis à jour avec succès.</div>";
            echo "<a href='affichagesql.php'><button>Retour à la liste</button></a>";
        }
    } catch (PDOException $e) {
        echo "<div style='color: red;'>Erreur : " . $e->getMessage() . "</div>";
    }
    ?>
</div>
</body>
</html>
