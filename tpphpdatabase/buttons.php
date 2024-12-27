<style>

    .buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .buttons form {
        margin: 0;
    }

    .buttons button {
        padding: 12px 20px;
        background: #b473bc;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        margin-right: 10px;
    }

    .buttons button:hover {
        background-color: #ebc0fd;
    }
</style>
<div class="buttons">
    <form method="POST" action="phpsqlTD1.php">
        <button type="submit">Ajouter un étudiant</button>
    </form>

    <form method="POST" action="phpetabli.php">
        <button type="submit">Ajouter un établissement</button>
    </form>

    <form method="GET" action="affichagesql.php">
        <button type="submit">Afficher les étudiants</button>
    </form>

    <form method="GET" action="afficheretabli.php">
        <button type="submit">Afficher les établissements</button>
    </form>
</div>
