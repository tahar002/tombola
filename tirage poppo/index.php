<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tirage au Sort</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Tirage au Sort</h1>

        <!-- Formulaire pour ajouter un participant -->
        <form action="add_participant.php" method="POST">
            <input type="text" name="name" placeholder="Nom du participant" required>
            <input type="text" name="id_poppo" placeholder="ID Poppo" required>
            <input type="text" name="categorie_tirage" placeholder="Catégorie Tirage" required>
            <button type="submit">Ajouter un participant</button>
        </form>

        <!-- Formulaire pour le tirage au sort -->
        <form id="drawForm">
            <input type="text" id="categorie_tirage" name="categorie_tirage" placeholder="Catégorie Tirage" required>
            <button type="button" id="drawButton">Tirer au Sort</button>
        </form>

        <!-- Bouton pour supprimer tous les participants -->
        <form action="delete_all.php" method="POST">
            <button type="submit" onclick="return confirm('Es-tu sûr de vouloir supprimer tous les participants ?');">Supprimer tous les participants</button>
        </form>

        <!-- Div pour afficher le résultat du tirage -->
        <div id="result"></div>
    </div>

    <script>
        document.getElementById('drawButton').addEventListener('click', function() {
            const resultDiv = document.getElementById('result');
            const categorieTirage = document.getElementById('categorie_tirage').value;

            resultDiv.innerHTML = "Tirage en cours...";

            setTimeout(function() {
                fetch('draw.php?categorie_tirage=' + encodeURIComponent(categorieTirage))
                    .then(response => response.text())
                    .then(data => resultDiv.innerHTML = "Le gagnant est : " + data);
            }, 2000);
        });
    </script>
</body>
</html>
