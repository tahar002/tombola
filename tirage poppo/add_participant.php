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

// Insérer le participant dans la base de données
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $id_poppo = $_POST['id_poppo'];
    $categorie_tirage = $_POST['categorie_tirage'];

    $stmt = $conn->prepare("INSERT INTO participants (name, id_poppo, categorie_tirage) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $id_poppo, $categorie_tirage);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Redirection vers la page principale
header("Location: index.php");
?>
