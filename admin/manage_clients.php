<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
include '../config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <style>
        /* Styles inchangés */
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
        <!-- Sidebar (inchangée) -->
        <aside class="bg-blue-800 text-white p-4 flex flex-col h-full justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-4 flex items-center">
                    <i class="fas fa-user-shield mr-2"></i>
                    <span class="nav-text">Admin</span>
                </h2>
                <nav class="space-y-2">
                    <a href="dashboard.php" class="flex items-center py-2 px-4 hover:bg-blue-700 rounded transition-transform duration-200 hover:scale-105">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        <span class="nav-text">Tableau de Bord</span>
                    </a>
                    <a href="manage_courses.php" class="flex items-center py-2 px-4 hover:bg-blue-700 rounded transition-transform duration-200 hover:scale-105">
                        <i class="fas fa-book mr-2"></i>
                        <span class="nav-text">Gérer les formations</span>
                    </a>
                    <a href="manage_clients.php" class="flex items-center py-2 px-4 bg-blue-700 rounded transition-transform duration-200 hover:scale-105">
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
            <h1 class="text-3xl font-bold mb-6">Gérer les Clients</h1>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Liste des Clients</h2>

                <!-- Statistiques selon le statut -->
                <?php
                // Requête pour compter les clients par statut
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
                $total = $confirmed_count + $not_confirmed_count + $refused_count;
                ?>
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-2">Statistiques par Statut</h3>
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

                <!-- Search Bar -->
                <div class="mb-4">
                    <div class="relative">
                        <input type="text" id="searchInput" class="w-full p-2 pl-10 border rounded" placeholder="Rechercher par nom, email, numéro, wilaya, formation, date ou statut...">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <table class="w-full" id="clientTable">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2">Nom</th>
                            <th class="p-2">Email</th>
                            <th class="p-2">Numéro</th>
                            <th class="p-2">Wilaya</th>
                            <th class="p-2">Formation</th>
                            <th class="p-2">Date d'inscription</th>
                            <th class="p-2">Statut</th>
                            <th class="p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("
                            SELECT c.id AS client_id, r.id AS registration_id, c.name, c.email, c.phone, c.wilaya, r.status, 
                                   co.title, DATE_FORMAT(r.registration_date, '%d/%m/%Y %H:%i') AS reg_date
                            FROM clients c 
                            LEFT JOIN registrations r ON c.id = r.client_id 
                            LEFT JOIN courses co ON r.course_id = co.id 
                        ");
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td class="p-2"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="p-2"><?php echo htmlspecialchars($row['email']); ?></td>
                                <td class="p-2"><?php echo htmlspecialchars($row['phone'] ?? 'N/A'); ?></td>
                                <td class="p-2"><?php echo htmlspecialchars($row['wilaya'] ?? 'N/A'); ?></td>
                                <td class="p-2"><?php echo htmlspecialchars($row['title'] ?? 'Aucune formation'); ?></td>
                                <td class="p-2"><?php echo htmlspecialchars($row['reg_date'] ?? 'N/A'); ?></td>
                                <td class="p-2"><?php echo $row['status'] == 'not_confirmed' ? 'Non confirmé' : ($row['status'] == 'confirmed' ? 'Confirmé' : 'Refusé'); ?></td>
                                <td class="p-2">
                                    <?php if ($row['status'] == 'not_confirmed') { ?>
                                        <a href="manage_clients.php?confirm=<?php echo $row['registration_id']; ?>" class="text-green-600 hover:underline">Confirmer</a>
                                        <a href="manage_clients.php?refuse=<?php echo $row['registration_id']; ?>" class="text-red-600 hover:underline ml-2">Refuser</a>
                                    <?php } ?>
                                    <a href="edit_client.php?id=<?php echo $row['client_id']; ?>" class="text-blue-600 hover:underline ml-2">Modifier</a>
                                    <a href="manage_clients.php?delete=<?php echo $row['client_id']; ?>" class="text-red-600 hover:underline ml-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php
            if (isset($_GET['confirm'])) {
                $registration_id = intval($_GET['confirm']);
                $registration = $conn->query("
                    SELECT c.name, c.email, c.phone, c.wilaya, r.status, co.title, co.telegram_link
                    FROM clients c 
                    JOIN registrations r ON c.id = r.client_id 
                    JOIN courses co ON r.course_id = co.id 
                    WHERE r.id = $registration_id
                ")->fetch_assoc();
                if ($registration) {
                    $conn->query("UPDATE registrations SET status = 'confirmed' WHERE id = $registration_id");
                    if (!empty($registration['telegram_link'])) {
                        $link = htmlspecialchars($registration['telegram_link']);
                        echo "<p class='text-green-600 mt-4'>✅ Inscription confirmée : {$registration['name']} a été ajouté au groupe Telegram pour la formation {$registration['title']}. Lien du groupe : <a href='$link' target='_blank' class='text-blue-600 hover:underline'>$link</a></p>";
                    } else {
                        echo "<p class='text-yellow-600 mt-4'>⚠️ Inscription confirmée : {$registration['name']} pour la formation {$registration['title']}, mais aucun lien Telegram n'est associé.</p>";
                    }
                } else {
                    echo "<p class='text-red-600 mt-4'>❌ Inscription non trouvée.</p>";
                }
                echo '<meta http-equiv="refresh" content="3;url=manage_clients.php">';
            }
            if (isset($_GET['refuse'])) {
                $registration_id = intval($_GET['refuse']);
                $conn->query("UPDATE registrations SET status = 'refused' WHERE id = $registration_id");
                echo "<p class='text-green-600 mt-4'>✅ Inscription refusée.</p>";
                echo '<meta http-equiv="refresh" content="1;url=manage_clients.php">';
            }
            if (isset($_GET['delete'])) {
                $client_id = intval($_GET['delete']);
                // Delete related registrations first to avoid foreign key constraints (if any)
                $conn->query("DELETE FROM registrations WHERE client_id = $client_id");
                // Then delete the client
                $conn->query("DELETE FROM clients WHERE id = $client_id");
                echo "<p class='text-green-600 mt-4'>✅ Client supprimé avec succès.</p>";
                echo '<meta http-equiv="refresh" content="1;url=manage_clients.php">';
            }
            ?>
        </div>
    </div>
    <script>
        // Script pour la recherche
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#clientTable tbody tr');
            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const email = row.cells[1].textContent.toLowerCase();
                const phone = row.cells[2].textContent.toLowerCase();
                const wilaya = row.cells[3].textContent.toLowerCase();
                const course = row.cells[4].textContent.toLowerCase();
                const regDate = row.cells[5].textContent.toLowerCase();
                const status = row.cells[6].textContent.toLowerCase();
                const actions = row.cells[7].textContent.toLowerCase();
                if (name.includes(searchTerm) || email.includes(searchTerm) || phone.includes(searchTerm) || wilaya.includes(searchTerm) || course.includes(searchTerm) || regDate.includes(searchTerm) || status.includes(searchTerm) || actions.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>