<?php
$servername = "localhost:3307";
$username = "root"; // change selon ta configuration
$password = "root"; // change selon ta configuration
$dbname = "tirage_au_sort";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer la catégorie de tirage de l'utilisateur
$categorie_tirage = $_GET['categorie_tirage'] ?? '';

if (!empty($categorie_tirage)) {
    // Sélectionner un participant aléatoire de la catégorie spécifiée
    $stmt = $conn->prepare("SELECT name, id_poppo FROM participants WHERE categorie_tirage = ? ORDER BY RAND() LIMIT 1");
    $stmt->bind_param("s", $categorie_tirage);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Nom: " . $row['name'] . ", ID Poppo: " . $row['id_poppo'];
    } else {
        echo "Aucun participant dans cette catégorie";
    }

    $stmt->close();
} else {
    echo "Veuillez spécifier une catégorie de tirage";
}

$conn->close();
?>
