<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StudyLobby</title>
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
            display: flex;
            align-items: left;
            justify-content: space-between;
            width: 500px;
            flex-direction: column;
        }

        h1 {
            margin-bottom: 20px;
        }

        input, select {
            width: 50%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #a6a4a4;
            border-radius: 8px;
            display: block;
        }

        button {
            padding: 12px 20px;
            background: linear-gradient(45deg, #b473bc, #8e44ad);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background-color: #4cae4c;
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
    <h1>StudyLobby</h1>
    <form method="POST" action="">
        <input type="text" name="nom" placeholder="Entrez votre nom" required>
        <input type="text" name="prenom" placeholder="Entrez votre prénom" required>
        <input type="date" name="date_naissance" placeholder="Entrez votre date de naissance" required>
        <input type="text" name="lieu_naissance" placeholder="Entrez votre lieu de naissance" required>
        <input type="email" name="email" placeholder="Entrez votre email" required>
        <input type="password" name="password" placeholder="Choisissez un mot de passe" required>
        <input type="text" name="filiere" placeholder="Entrez votre filière" required>


        <select name="id_etablissement" required>
            <option value="">Sélectionnez un établissement</option>
<?php include 'buttons.php'; ?>
            <?php
            try {
                // Connexion à la base de données
                $db = new PDO('mysql:host=localhost;dbname=studylobby', 'root', '');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                $stmt = $db->query("SELECT id, nom_etablissement FROM etablissements");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nom_etablissement'] . "</option>";
                }
            } catch (PDOException $e) {
                echo "<div style='color: red;'>Erreur : " . $e->getMessage() . "</div>";
            }
            ?>
        </select>

        <button type="submit" name="ajouter">Ajouter</button>
    </form>

    <form action="affichagesql.php" method="get">
        <button type="submit">Afficher</button>
    </form>

    <?php
    try {
        // Connexion
        $db = new PDO('mysql:host=localhost;dbname=studylobby', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajouter'])) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $date_naissance = $_POST['date_naissance'];
            $lieu_naissance = $_POST['lieu_naissance'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe
            $filiere = $_POST['filiere'];
            $id_etablissement = $_POST['id_etablissement']; // Récupérer l'ID de l'établissement sélectionné

            $stmt = $db->prepare("
                INSERT INTO etudiants (nom, prenom, date_naissance, lieu_naissance, email, password, filiere, id_etablissement) 
                VALUES (:nom, :prenom, :date_naissance, :lieu_naissance, :email, :password, :filiere, :id_etablissement)
            ");
            $stmt->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'date_naissance' => $date_naissance,
                'lieu_naissance' => $lieu_naissance,
                'email' => $email,
                'password' => $password,
                'filiere' => $filiere,
                'id_etablissement' => $id_etablissement,
            ]);

            echo "<div style='color: green; text-align: center;'>Étudiant ajouté avec succès !</div>";
        }
    } catch (PDOException $e) {
        echo "<div style='color: red; text-align: center;'>Erreur : " . $e->getMessage() . "</div>";
    }
    ?>
</div>
</body>
</html>