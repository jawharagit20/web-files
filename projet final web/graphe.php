<?php
session_start();
require 'db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "Erreur: Vous devez être connecté pour afficher les statistiques.";
    exit();
}

// Requête pour les statistiques (nombre d'emprunts par catégorie)
$stmt = $pdo->query("
    SELECT c.nom AS categorie, COUNT(l.id) AS emprunts 
    FROM categories c
    LEFT JOIN livres b ON c.id = b.categorie_id
    LEFT JOIN loans l ON b.id = l.livres_id AND l.return_date IS NULL
    GROUP BY c.nom
");
$stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Emprunts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6; /* Couleur de fond douce */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100vh;
        }

        h1 {
            font-size: 32px;
            color: #9e3969; /* Couleur du titre */
            margin-top: 50px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .chart-container {
            width: 80%; /* Largeur du graphique */
            max-width: 1000px; /* Largeur maximale */
            background-color: #fff; /* Fond blanc pour le graphique */
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre douce autour du graphique */
            padding: 30px;
            text-align: center;
            margin-bottom: 50px;
        }

        canvas {
            width: 100% !important; /* S'assurer que le graphique prend toute la largeur du conteneur */
            height: 400px !important; /* Hauteur fixe du graphique */
        }


    </style>
</head>
<body>

<h1>Statistiques des Emprunts</h1>

<!-- Conteneur pour le graphique -->
<div class="chart-container">
    <canvas id="statsChart"></canvas>
</div>

<script>
    // Données pour le graphique
    const categories = <?= json_encode(array_column($stats, 'categorie')) ?>;
    const emprunts = <?= json_encode(array_column($stats, 'emprunts')) ?>;

    // Initialiser le graphique avec Chart.js
    const ctx = document.getElementById('statsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [{
                label: 'Livres empruntés par catégorie',
                data: emprunts,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Statistiques des emprunts par catégorie' }
            },
            scales: {
                y: {
                    ticks: {
                        stepSize: 1, // Incrémenter par 1
                        callback: function(value) {
                            return value % 1 === 0 ? value : ''; // Afficher uniquement les entiers
                        }
                    }
                }
            }
        }
    });
</script>



</body>
</html>

