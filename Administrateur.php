<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrateur') {
    header("Location: SignUp.php");  // Redirect to login page if not logged in or not an admin
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'exammaster';
$user = 'root';
$password = 'DD102';

try {
    $pdo = new PDO("mysql:host=$host;port=3307;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user details
    $stmt = $pdo->prepare('SELECT * FROM Utilisateur WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Erreur de connexion : " . $e->getMessage();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: SignUp.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExamMaster - Administrateur</title>
    <link rel="stylesheet" href="stylesA.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">ExamMaster</div>
        <ul>
            <li><a href="administrateur.php">Accueil</a></li>
            <li><a href="SignUp.php">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="welcome">
            <h1>Salut, <span><?php echo htmlspecialchars($user['nom']); ?></span>!</h1>
        </div>

        <div class="actions">
            <button class="action-btn">Attribuer Role</button>
            <button class="action-btn">Statistique</button>
            <button class="action-btn">Gérer Compte</button>
            <button class="action-btn">Restaurer Compte</button>
            <button class="action-btn">Supprimer Compte</button>
        </div>
    </div>
</body>
</html>
