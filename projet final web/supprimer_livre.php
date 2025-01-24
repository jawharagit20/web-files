<?php
session_start();
require 'db.php'; // Connexion à la base de données

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Supprimer le livre
    $stmt = $pdo->prepare("DELETE FROM livres WHERE id = ?");
    $stmt->execute([$id]);

    echo "Livre supprimé avec succès.";
    header("Location: list_livres.php");
    exit();
} else {
    echo "Livre non trouvé.";
}
?>

