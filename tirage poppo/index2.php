<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tirage au Sort</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style de la roulette */
        #roulette {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 5px solid #333;
            position: relative;
            margin: 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        /* L'aiguille de la roulette */
        #needle {
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-bottom: 40px solid red;
            position: absolute;
            top: -40px;
            left: calc(50% - 20px);
        }

        /* Conteneur des feux d'artifice */
        .fireworks-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        /* Style des ballons */
        .balloon {
            position: absolute;
            width: 30px;
            height: 40px;
            background-color: #FF5F6D;
            border-radius: 50%;
            animation: riseUp 5s ease-in infinite;
            transform-origin: bottom center;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .balloon:before {
            content: '';
            position: absolute;
            width: 2px;
            height: 20px;
            background: #ccc;
            top: 40px;
            left: 50%;
            transform: translateX(-50%);
        }

        @keyframes riseUp {
            0% {
                transform: translateY(100vh) scale(0.7);
                opacity: 0;
            }
            100% {
                transform: translateY(-100vh) scale(1);
                opacity: 1;
            }
        }

        /* Style des fleurs */
        .flower {
            position: absolute;
            width: 0;
            height: 0;
            border-radius: 50%;
            border: 15px solid transparent;
            animation: bloom 3s ease-in-out forwards;
        }

        .flower:nth-child(odd) {
            border-color: #FF85A1;
        }

        .flower:nth-child(even) {
            border-color: #FFD54F;
        }

        @keyframes bloom {
            0% {
                width: 0;
                height: 0;
                opacity: 0;
            }
            50% {
                width: 50px;
                height: 50px;
                opacity: 1;
            }
            100% {
                width: 80px;
                height: 80px;
                opacity: 0;
            }
        }

        /* Style des étoiles */
        .star {
            position: absolute;
            width: 3px;
            height: 3px;
            background-color: #FFD700;
            border-radius: 50%;
            animation: sparkle 1.5s infinite alternate;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        @keyframes sparkle {
            0% {
                transform: scale(0.5);
                opacity: 0.5;
            }
            100% {
                transform: scale(1.5);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tirage Poppo live dz سحب بوبو ليف</h1>

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
            <button type="button" id="drawButton">السحب</button>
        </form>
          
        <!-- Div pour la roulette -->
        <div id="roulette">
            <div id="needle"></div>
            <div id="rouletteValue">Cliquez sur Tirer au Sort</div>
        </div>

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
            const rouletteValue = document.getElementById('rouletteValue');
            const categorieTirage = document.getElementById('categorie_tirage').value;

            resultDiv.innerHTML = "Tirage en cours...";
            rouletteValue.innerHTML = "La roulette tourne...";

            fetch('draw.php?categorie_tirage=' + encodeURIComponent(categorieTirage))
                .then(response => response.text())
                .then(data => {
                    const [nom, id_poppo] = data.split(", ID Poppo: ");
                    const result = "Le gagnant est : " + nom + " avec ID Poppo : " + id_poppo;

                    // Simuler la rotation de la roulette
                    const rotations = Math.floor(Math.random() * 5) + 5; // Nombre de tours
                    const totalRotation = 360 * rotations; // Tour complet
                    const finalRotation = totalRotation + Math.random() * 360; // Ajouter un angle aléatoire

                    // Appliquer la rotation finale
                    document.getElementById('roulette').style.transition = 'transform 4s ease-out';
                    document.getElementById('roulette').style.transform = 'rotate(' + finalRotation + 'deg)';

                    // Afficher le résultat après la rotation
                    setTimeout(function() {
                        rouletteValue.innerHTML = id_poppo;
                        resultDiv.innerHTML = result;

                        // Déclencher l'animation de feu d'artifice
                        launchFireworks();
                    }, 4000); // Délai de 4 secondes pour s'aligner sur l'animation
                });
        });

        function launchFireworks() {
            const container = document.createElement('div');
            container.className = 'fireworks-container';
            document.body.appendChild(container);

            // Générer des ballons
            for (let i = 0; i < 10; i++) {
                const balloon = document.createElement('div');
                balloon.className = 'balloon';
                balloon.style.backgroundColor = getRandomColor();
                balloon.style.left = Math.random() * 100 + 'vw';
                balloon.style.animationDelay = (Math.random() * 2) + 's';
                container.appendChild(balloon);

                setTimeout(() => balloon.remove(), 5000); // Supprimer après animation
            }

            // Générer des fleurs
            for (let i = 0; i < 5; i++) {
                const flower = document.createElement('div');
                flower.className = 'flower';
                flower.style.left = Math.random() * 100 + 'vw';
                flower.style.top = Math.random() * 100 + 'vh';
                flower.style.animationDelay = (Math.random() * 2) + 's';
                container.appendChild(flower);

                setTimeout(() => flower.remove(), 3000); // Supprimer après animation
            }

            // Générer des étoiles
            for (let i = 0; i < 20; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                star.style.left = Math.random() * 100 + 'vw';
                star.style.top = Math.random() * 100 + 'vh';
                star.style.animationDelay = (Math.random() * 2) + 's';
                container.appendChild(star);

                setTimeout(() => star.remove(), 1500); // Supprimer après animation
            }

            setTimeout(() => container.remove(), 6000); // Supprimer le conteneur complet après toutes les animations
        }

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
</body>
</html>
