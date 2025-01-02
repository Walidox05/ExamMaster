<?php
// index.php
session_start();

$exams = [
    ['name' => 'Français', 'id' => 1],
    ['name' => 'Anglais technique', 'id' => 2],
    ['name' => 'Culture entrepreneuriale', 'id' => 3],
    ['name' => 'Culture et techniques avancées du numérique', 'id' => 4],
    ['name' => 'Gestion de project', 'id' => 5],
    ['name' => 'Entrepreneuriat-PIE 2', 'id' => 6]
];

// Determine which view to show based on URL parameter
$view = isset($_GET['view']) ? $_GET['view'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExamMaster - Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f0f4f8;
        }

        .navbar {
            background-color: #1a365d;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .nav-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .profile-section {
            background-color: white;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .profile-icon {
            width: 80px;
            height: 80px;
            background-color: #4a90e2;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-icon img {
            width: 50px;
            height: 50px;
        }

        .navigation-tabs {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .nav-tab {
            padding: 0.75rem 1.5rem;
            color: #1a365d;
            text-decoration: none;
            border-bottom: 2px solid transparent;
        }

        .nav-tab:hover {
            border-bottom-color: #4a90e2;
        }

        .exam-section {
            background-color: white;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .exam-icon {
            width: 60px;
            height: 60px;
            background-color: #4a90e2;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .exam-icon img {
            width: 40px;
            height: 40px;
        }

        .exam-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #1a365d;
            color: white;
        }

        .btn-secondary {
            background-color: #2b4c7e;
            color: white;
        }

        .sidebar {
            width: 250px;
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            position: fixed;
            height: calc(100vh - 100px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .profile-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .profile-icon-small {
            width: 40px;
            height: 40px;
            background-color: #4a90e2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-icon-small img {
            width: 25px;
            height: 25px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .menu-item {
            padding: 0.75rem 1rem;
            color: #1a365d;
            text-decoration: none;
            border-radius: 4px;
        }

        .menu-item:hover, .menu-item.active {
            background-color: #f0f4f8;
        }

        .main-content {
            margin-left: 270px;
            background-color: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .exam-list-header {
            margin-bottom: 2rem;
        }

        .exam-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .exam-table th, .exam-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .exam-table th {
            background-color: #f8fafc;
            font-weight: bold;
            color: #1a365d;
        }

        .btn-take-exam {
            background-color: #1a365d;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-take-exam:hover {
            background-color: #2b4c7e;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-brand">ExamMaster</div>
       <a href="logout.php" class="logout-btn">Déconnexion</a>

    </nav>

    <div class="container">
        <?php if ($view === 'dashboard'): ?>
            <!-- Dashboard View -->
            <div class="profile-section">
                <div class="profile-icon">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23ffffff' d='M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4z'/%3E%3C/svg%3E" alt="Profile">
                </div>
                <h2>Salut Etudiant</h2>
            </div>

            <div class="navigation-tabs">
                <a href="?page=profile" class="nav-tab">Profile</a>
                <a href="?page=dashboard" class="nav-tab">Tableau de bord</a>
                <a href="?page=compte" class="nav-tab">Compte</a>
                <a href="?page=notification" class="nav-tab">Notification</a>
            </div>

            <div class="exam-section">
                <div class="exam-icon">
                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23ffffff' d='M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z'/%3E%3C/svg%3E" alt="Exam">
                </div>
                <div class="exam-buttons">
                    <a href="?view=exams" class="btn btn-primary">Examens Disponible</a>
                    <a href="?view=take-exam" class="btn btn-secondary">Passer un examen</a>
                </div>
            </div>

        <?php elseif ($view === 'exams'): ?>
            <!-- Exam List View -->
            <div class="sidebar">
                <div class="profile-info">
                    <div class="profile-icon-small">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23ffffff' d='M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4z'/%3E%3C/svg%3E" alt="Profile">
                    </div>
                    <div class="profile-text">
                        <h3>Nom</h3>
                        <p>(Etudiant)</p>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <a href="?view=dashboard" class="menu-item">Compte</a>
                    <a href="?view=dashboard" class="menu-item">Tableau de bord</a>
                    <a href="?view=exams" class="menu-item active">Passer un Examen</a>
                    <a href="?page=notes" class="menu-item">Mes Notes</a>
                    <a href="?page=profile" class="menu-item">Profile</a>
                    <a href="?page=notification" class="menu-item">Notification</a>
                </div>
            </div>

            <div class="main-content">
                <div class="exam-list-header">
                    <h2>Exam Disponible</h2>
                </div>
                <div class="exam-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Nom d'examen</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($exams as $exam): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($exam['name']); ?></td>
                                <td>
                                    <a href="take-exam.php?id=<?php echo $exam['id']; ?>" class="btn-take-exam">
                                        Passer l'examen
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>