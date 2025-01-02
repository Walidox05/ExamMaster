<?php
// Informations de connexion
$host = 'localhost';
$dbname = 'exammaster';
$user = 'root';
$password = 'DD102';

session_start();


try {
    $pdo = new PDO("mysql:host=$host;port=3307;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare('SELECT * FROM Utilisateur WHERE email = ? and motDePasse = ?');
        $stmt->execute([$email, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && isset($user['motDePasse'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom'];
            $_SESSION['user_role'] = $user['role']; // Assuming 'role' column exists

            // Redirect based on role
            if ($user['role'] === 'Administrateur') {
                header("Location: Administrateur.php");
            } elseif ($user['role'] === 'Enseignant') {
                header("Location: teacher.php");
            } elseif ($user['role'] === 'Etudiant') {
                header("Location: Etudiant.php");
            } else {
                $error = "Rôle utilisateur inconnu.";
            }

            exit();
        } else {
            $error = "Identifiants invalides.";
        }
    }
} catch (PDOException $e) {
    $error = "Erreur de connexion : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExamMaster</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="main-container">
        <div class="form-section">
            <div class="welcome">
                <h1>Connexion à ExamMaster</h1>
            </div>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post" action="SignUp.php">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Exemple@email.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Au moins 8 caractères" required>
                </div>
                <button type="submit" class="connect-button">Se connecter</button>
            </form>
        </div>

        <div class="photo-container">
            <div class="photo-frame">
                <img src="examination_tools 1.png" alt="Student Reading">
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
