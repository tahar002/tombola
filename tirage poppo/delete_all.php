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

// Supprimer tous les participants
$sql = "DELETE FROM participants";

if ($conn->query($sql) === TRUE) {
    echo "Tous les participants ont été supprimés.";
} else {
    echo "Erreur lors de la suppression : " . $conn->error;
}

$conn->close();

// Redirection vers la page principale après suppression
header("Location: index.php");
exit();
?>
