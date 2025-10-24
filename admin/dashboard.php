
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
include '../config.php';

// Fetch statistics with error handling
try {
    $total_courses = $conn->query("SELECT COUNT(*) as count FROM courses");
    $total_courses = $total_courses ? $total_courses->fetch_assoc()['count'] : 0;

    $total_clients = $conn->query("SELECT COUNT(*) as count FROM clients");
    $total_clients = $total_clients ? $total_clients->fetch_assoc()['count'] : 0;

    $total_registrations = $conn->query("SELECT COUNT(*) as count FROM registrations");
    $total_registrations = $total_registrations ? $total_registrations->fetch_assoc()['count'] : 0;

    // Statistiques par statut (basées sur les inscriptions, comme dans manage_clients.php)
    $stats_query = $conn->query("
        SELECT 
            SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) AS confirmed_count,
            SUM(CASE WHEN status = 'not_confirmed' THEN 1 ELSE 0 END) AS not_confirmed_count,
            SUM(CASE WHEN status = 'refused' THEN 1 ELSE 0 END) AS refused_count
        FROM registrations
    ");
    $stats = $stats_query->fetch_assoc();
    $confirmed_count = $stats['confirmed_count'] ?? 0;
    $not_confirmed_count = $stats['not_confirmed_count'] ?? 0;
    $refused_count = $stats['refused_count'] ?? 0;
} catch (mysqli_sql_exception $e) {
    echo "<p class='text-red-600 text-center'>Erreur de base de données : " . htmlspecialchars($e->getMessage()) . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles.css">
    <style>
        aside {
            position: fixed;
            top: 0;
            left: 0;
            width: 64px;
            height: 100vh;
            transition: width 0.3s ease;
            overflow: hidden;
            z-index: 1000;
        }
        aside:hover {
            width: 256px;
        }
        aside:not(:hover) .nav-text {
            opacity: 0;
            visibility: hidden;
        }
        aside:hover .nav-text {
            opacity: 1;
            visibility: visible;
            transition: opacity 0.3s ease 0.1s;
        }
        .nav-text {
            white-space: nowrap;
        }
        .main-content {
            margin-left: 64px;
            transition: margin-left 0.3s ease;
        }
        aside:hover ~ .main-content {
            margin-left: 256px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="bg-blue-800 text-white p-4 flex flex-col h-full justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-4 flex items-center">
                    <i class="fas fa-user-shield mr-2"></i>
                    <span class="nav-text">Admin</span>
                </h2>
                <nav class="space-y-2">
                    <a href="dashboard.php" class="flex items-center py-2 px-4 bg-blue-700 rounded transition-transform duration-200 hover:scale-105">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        <span class="nav-text">Tableau de Bord</span>
                    </a>
                    <a href="manage_courses.php" class="flex items-center py-2 px-4 hover:bg-blue-700 rounded transition-transform duration-200 hover:scale-105">
                        <i class="fas fa-book mr-2"></i>
                        <span class="nav-text">Gérer les formations</span>
                    </a>
                    <a href="manage_clients.php" class="flex items-center py-2 px-4 hover:bg-blue-700 rounded transition-transform duration-200 hover:scale-105">
                        <i class="fas fa-users mr-2"></i>
                        <span class="nav-text">Gérer les clients</span>
                    </a>
                </nav>
            </div>
            <nav>
                <a href="logout.php" class="flex items-center py-2 px-4 hover:bg-blue-700 rounded transition-transform duration-200 hover:scale-105">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    <span class="nav-text">Déconnexion</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-8 main-content">
            <h1 class="text-3xl font-bold mb-6">Tableau de Bord Admin</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Courses -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-700">Nombre de Formations</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2"><?php echo $total_courses; ?></p>
                </div>
                <!-- Total Clients -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-700">Nombre de Clients</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2"><?php echo $total_clients; ?></p>
                </div>
                <!-- Total Registrations -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-700">Nombre d'Inscriptions</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2"><?php echo $total_registrations; ?></p>
                </div>
                <!-- Confirmed Registrations -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-700">Inscriptions Confirmées</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2"><?php echo $confirmed_count; ?></p>
                </div>
                <!-- Not Confirmed Registrations -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-700">Inscriptions Non Confirmées</h3>
                    <p class="text-3xl font-bold text-yellow-600 mt-2"><?php echo $not_confirmed_count; ?></p>
                </div>
                <!-- Refused Registrations -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-700">Inscriptions Refusées</h3>
                    <p class="text-3xl font-bold text-red-600 mt-2"><?php echo $refused_count; ?></p>
                </div>
            </div>

            <!-- Statistiques par Statut -->
            <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Statistiques par Statut</h2>
                <?php
                $total = $confirmed_count + $not_confirmed_count + $refused_count;
                ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="bg-green-100 p-4 rounded-lg">
                        <p class="text-lg font-semibold">Confirmé</p>
                        <p class="text-2xl"><?php echo $confirmed_count; ?> (<?php echo $total ? round(($confirmed_count / $total) * 100, 1) : 0; ?>%)</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg">
                        <p class="text-lg font-semibold">Non confirmé</p>
                        <p class="text-2xl"><?php echo $not_confirmed_count; ?> (<?php echo $total ? round(($not_confirmed_count / $total) * 100, 1) : 0; ?>%)</p>
                    </div>
                    <div class="bg-red-100 p-4 rounded-lg">
                        <p class="text-lg font-semibold">Refusé</p>
                        <p class="text-2xl"><?php echo $refused_count; ?> (<?php echo $total ? round(($refused_count / $total) * 100, 1) : 0; ?>%)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
