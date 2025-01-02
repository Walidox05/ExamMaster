<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: SignUp.php');
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
    header('Location: SignUp.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExamMaster - Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <link rel="stylesheet" href="stylesE.css">
</head>
<body>
    <nav class="navbar">
        <a href="#" class="logo">ExamMaster</a>
        <div class="nav-links">
            <form method="post" style="display: inline;">
                <button type="submit" name="logout" class="logout-btn">Déconnexion</button>
            </form>
        </div>
    </nav>

    <div class="main-content">
        <div class="user-profile">
            <div class="profile-icon">
                <i class="fas fa-user-graduate fa-2x"></i>
            </div>
            
            <h3><?php echo htmlspecialchars($user['nom'] ?? 'Utilisateur'); ?></h3>
        </div>

        <div class="nav-menu">
            <a href="#" class="nav-item">Profile</a>
            <a href="#" class="nav-item">Tableau de bord</a>
            <a href="#" class="nav-item">Compte</a>
            <a href="#" class="nav-item">Notification</a>
        </div>

        <div class="exam-section">
            <div class="exam-icon">
                <i class="fas fa-book-open fa-3x" style="color:rgb(255, 255, 255);"></i>
            </div>
<br>            <div class="buttons">
                <button class="btn btn-primary" id="available-exams">Examens Disponible</button>
                <button class="btn btn-secondary" id="request-exam">Passer un examen</button>
            </div>
        </div>
    </div>

    <script src="dashboard-script.js"></script>
</body>
</html>