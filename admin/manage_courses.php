<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
include '../config.php';

// Fetch course statistics
$total_courses = $conn->query("SELECT COUNT(*) as count FROM courses")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Formations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
        #courseListContainer.faded {
            opacity: 0.5;
            transition: opacity 0.3s ease;
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
                    <a href="dashboard.php" class="flex items-center py-2 px-4 hover:bg-blue-700 rounded transition-transform duration-200 hover:scale-105">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        <span class="nav-text">Tableau de Bord</span>
                    </a>
                    <a href="manage_courses.php" class="flex items-center py-2 px-4 bg-blue-700 rounded transition-transform duration-200 hover:scale-105">
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
            <h1 class="text-3xl font-bold mb-6">Gérer les Formations</h1>

            <!-- Course Statistics -->
            <div class="mb-8">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-700">Nombre de Formations</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2"><?php echo $total_courses; ?></p>
                </div>
            </div>

            <!-- Add Course Button -->
            <div class="mb-4">
                <button id="toggleAddForm" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
                    Ajouter une Formation
                </button>
            </div>

            <!-- Add Course Form (Hidden by Default) -->
            <div id="addCourseForm" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">Ajouter une Formation</h2>
                        <button id="closeAddForm" class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700">Titre</label>
                            <input type="text" name="title" id="title" class="w-full p-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700">Prix (DZD)</label>
                            <input type="number" step="0.01" name="price" id="price" class="w-full p-2 border rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700">Description</label>
                            <textarea name="description" id="description" class="w-full p-2 border rounded" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="photo" class="block text-gray-700">Photo (facultatif)</label>
                            <input type="file" name="photo" id="photo" class="w-full p-2 border rounded" accept="image/*">
                        </div>
                        <div class="mb-4">
                            <label for="audio" class="block text-gray-700">Audio/Vocale (facultatif)</label>
                            <input type="file" name="audio" id="audio" class="w-full p-2 border rounded" accept="audio/*">
                        </div>
                        <div class="mb-4">
                            <label for="telegram_link" class="block text-gray-700">Lien Telegram</label>
                            <input type="url" name="telegram_link" id="telegram_link" class="w-full p-2 border rounded">
                        </div>
                        <button type="submit" name="add_course" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Ajouter</button>
                    </form>

                    <?php
                    // Fonction utilitaire pour sécuriser les noms de fichiers
                    function secureFileName($originalName) {
                        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                        $basename = pathinfo($originalName, PATHINFO_FILENAME);
                        $safeBasename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $basename);
                        return $safeBasename . '.' . strtolower($extension);
                    }

                    if (isset($_POST['add_course'])) {
                        $title = trim($_POST['title']);
                        $price = floatval($_POST['price']);
                        $description = trim($_POST['description']);
                        $telegram_link = trim($_POST['telegram_link']);
                        $photo = null;
                        $audio = null;

                        // Upload photo
                        if (!empty($_FILES['photo']['name'])) {
                            $photoName = secureFileName($_FILES['photo']['name']);
                            $uploadDir = '../Uploads/';
                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0755, true);
                            }
                            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photoName)) {
                                $photo = $photoName;
                            } else {
                                echo "<p class='text-red-600 mt-4'>❌ Erreur lors de l'upload de la photo.</p>";
                            }
                        }

                        // Upload audio
                        if (!empty($_FILES['audio']['name'])) {
                            $audioName = secureFileName($_FILES['audio']['name']);
                            $uploadDir = '../Uploads/';
                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0755, true);
                            }
                            if (move_uploaded_file($_FILES['audio']['tmp_name'], $uploadDir . $audioName)) {
                                $audio = $audioName;
                            } else {
                                echo "<p class='text-red-600 mt-4'>❌ Erreur lors de l'upload de l'audio.</p>";
                            }
                        }

                        $stmt = $conn->prepare("INSERT INTO courses (title, price, description, photo, audio, telegram_link) VALUES (?, ?, ?, ?, ?, ?)");
                        if ($stmt) {
                            $stmt->bind_param("sdssss", $title, $price, $description, $photo, $audio, $telegram_link);
                            if ($stmt->execute()) {
                                echo "<p class='text-green-600 mt-4'>✅ Formation ajoutée avec succès.</p>";
                                echo '<meta http-equiv="refresh" content="1;url=manage_courses.php">';
                            } else {
                                echo "<p class='text-red-600 mt-4'>❌ Erreur lors de l'ajout de la formation.</p>";
                            }
                            $stmt->close();
                        } else {
                            echo "<p class='text-red-600 mt-4'>❌ Erreur de préparation de la requête.</p>";
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Course List -->
            <div id="courseListContainer">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold mb-4">Liste des Formations</h2>
                    <!-- Search Bar -->
                    <div class="mb-4">
                        <div class="relative">
                            <input type="text" id="searchInput" class="w-full p-2 pl-10 border rounded" placeholder="Rechercher par titre, description, prix...">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    <table class="w-full" id="courseTable">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2">Titre</th>
                                <th class="p-2">Prix (DZD)</th>
                                <th class="p-2">Description</th>
                                <th class="p-2">Photo</th>
                                <th class="p-2">Audio</th>
                                <th class="p-2">Lien Telegram</th>
                                <th class="p-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT * FROM courses");
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td class="p-2"><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td class="p-2"><?php echo number_format((float)$row['price'], 2); ?></td>
                                    <td class="p-2"><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
                                    <td class="p-2">
                                        <?php if (!empty($row['photo'])): ?>
                                            <img src="../Uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="Photo" class="w-16 h-16 object-cover rounded">
                                        <?php else: ?>
                                            <span class="text-gray-500">Aucune</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-2">
                                        <?php if (!empty($row['audio'])): ?>
                                            <audio controls class="w-32"><source src="../Uploads/<?php echo htmlspecialchars($row['audio']); ?>" type="audio/mpeg"></audio>
                                        <?php else: ?>
                                            <span class="text-gray-500">Aucun</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-2">
                                        <?php if (!empty($row['telegram_link'])): ?>
                                            <a href="<?php echo htmlspecialchars($row['telegram_link']); ?>" target="_blank" class="text-blue-600 hover:underline">Lien</a>
                                        <?php else: ?>
                                            <span class="text-gray-500">Aucun</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-2">
                                        <a href="#" class="text-blue-600 hover:underline edit-course" data-id="<?php echo $row['id']; ?>">Modifier</a>
                                        <a href="manage_courses.php?delete=<?php echo $row['id']; ?>" class="text-red-600 hover:underline ml-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette formation ?');">Supprimer</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Edit Course Form (Hidden by Default) -->
            <?php
            if (isset($_GET['edit'])) {
                $id = intval($_GET['edit']);
                $course = $conn->query("SELECT * FROM courses WHERE id = $id")->fetch_assoc();
                if ($course) {
            ?>
                <div id="editCourseForm" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-2xl font-bold">Modifier la Formation</h2>
                            <button id="closeEditForm" class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700">Titre</label>
                                <input type="text" name="title" id="title" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($course['title']); ?>" required>
                            </div>
                            <div class="mb-4">
                                <label for="price" class="block text-gray-700">Prix (DZD)</label>
                                <input type="number" step="0.01" name="price" id="price" class="w-full p-2 border rounded" value="<?php echo $course['price']; ?>" required>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="block text-gray-700">Description</label>
                                <textarea name="description" id="description" class="w-full p-2 border rounded" required><?php echo htmlspecialchars($course['description']); ?></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="photo" class="block text-gray-700">Photo (laisser vide pour ne pas changer)</label>
                                <input type="file" name="photo" id="photo" class="w-full p-2 border rounded" accept="image/*">
                                <?php if (!empty($course['photo'])): ?>
                                    <p class="text-sm text-gray-600 mt-1">Photo actuelle : <img src="../Uploads/<?php echo htmlspecialchars($course['photo']); ?>" alt="Photo actuelle" class="w-16 h-16 object-cover rounded"></p>
                                <?php endif; ?>
                            </div>
                            <div class="mb-4">
                                <label for="audio" class="block text-gray-700">Audio (laisser vide pour ne pas changer)</label>
                                <input type="file" name="audio" id="audio" class="w-full p-2 border rounded" accept="audio/*">
                                <?php if (!empty($course['audio'])): ?>
                                    <p class="text-sm text-gray-600 mt-1">Audio actuel : 
                                        <audio controls class="w-32"><source src="../Uploads/<?php echo htmlspecialchars($course['audio']); ?>" type="audio/mpeg"></audio>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="mb-4">
                                <label for="telegram_link" class="block text-gray-700">Lien Telegram</label>
                                <input type="url" name="telegram_link" id="telegram_link" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($course['telegram_link']); ?>">
                            </div>
                            <button type="submit" name="update_course" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Mettre à jour</button>
                        </form>
                    </div>
                </div>
            <?php
                }
                if (isset($_POST['update_course'])) {
                    $id = intval($_POST['id']);
                    $title = trim($_POST['title']);
                    $price = floatval($_POST['price']);
                    $description = trim($_POST['description']);
                    $telegram_link = trim($_POST['telegram_link']);
                    $existing = $conn->query("SELECT photo, audio FROM courses WHERE id = $id")->fetch_assoc();
                    $photo = $existing['photo'];
                    $audio = $existing['audio'];

                    // Nouvelle photo ?
                    if (!empty($_FILES['photo']['name'])) {
                        $photoName = secureFileName($_FILES['photo']['name']);
                        if (move_uploaded_file($_FILES['photo']['tmp_name'], '../Uploads/' . $photoName)) {
                            $photo = $photoName;
                        } else {
                            echo "<p class='text-red-600 mt-4'>❌ Erreur upload photo.</p>";
                        }
                    }

                    // Nouvel audio ?
                    if (!empty($_FILES['audio']['name'])) {
                        $audioName = secureFileName($_FILES['audio']['name']);
                        if (move_uploaded_file($_FILES['audio']['tmp_name'], '../Uploads/' . $audioName)) {
                            $audio = $audioName;
                        } else {
                            echo "<p class='text-red-600 mt-4'>❌ Erreur upload audio.</p>";
                        }
                    }

                    $stmt = $conn->prepare("UPDATE courses SET title = ?, price = ?, description = ?, photo = ?, audio = ?, telegram_link = ? WHERE id = ?");
                    if ($stmt) {
                        $stmt->bind_param("sdssssi", $title, $price, $description, $photo, $audio, $telegram_link, $id);
                        if ($stmt->execute()) {
                            echo "<p class='text-green-600 mt-4'>✅ Formation mise à jour.</p>";
                            echo '<meta http-equiv="refresh" content="1;url=manage_courses.php">';
                        } else {
                            echo "<p class='text-red-600 mt-4'>❌ Erreur mise à jour.</p>";
                        }
                        $stmt->close();
                    } else {
                        echo "<p class='text-red-600 mt-4'>❌ Erreur de préparation de la requête.</p>";
                    }
                }
            }
            ?>

            <!-- Suppression -->
            <?php
            if (isset($_GET['delete'])) {
                $id = intval($_GET['delete']);
                $fileCheck = $conn->query("SELECT photo, audio FROM courses WHERE id = $id")->fetch_assoc();
                if ($fileCheck) {
                    if (!empty($fileCheck['photo']) && file_exists('../Uploads/' . $fileCheck['photo'])) {
                        unlink('../Uploads/' . $fileCheck['photo']);
                    }
                    if (!empty($fileCheck['audio']) && file_exists('../Uploads/' . $fileCheck['audio'])) {
                        unlink('../Uploads/' . $fileCheck['audio']);
                    }
                }
                $conn->query("DELETE FROM courses WHERE id = $id");
                if ($conn->affected_rows > 0) {
                    echo "<p class='text-green-600 mt-4'>✅ Formation supprimée avec succès.</p>";
                    echo '<meta http-equiv="refresh" content="1;url=manage_courses.php">';
                } else {
                    echo "<p class='text-red-600 mt-4'>❌ Aucune formation supprimée.</p>";
                }
            }
            ?>
        </div>
    </div>
    <script>
        // Toggle Add Course Form
        document.getElementById('toggleAddForm').addEventListener('click', function() {
            const form = document.getElementById('addCourseForm');
            const courseList = document.getElementById('courseListContainer');
            form.classList.toggle('hidden');
            courseList.classList.toggle('faded');
        });

        // Close Add Course Form
        document.getElementById('closeAddForm').addEventListener('click', function() {
            const form = document.getElementById('addCourseForm');
            const courseList = document.getElementById('courseListContainer');
            form.classList.add('hidden');
            courseList.classList.remove('faded');
        });

        // Toggle Edit Course Form via Edit Links
        document.querySelectorAll('.edit-course').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const courseId = this.getAttribute('data-id');
                window.location.href = 'manage_courses.php?edit=' + courseId;
            });
        });

        // Close Edit Course Form (if visible)
        if (document.getElementById('editCourseForm')) {
            document.getElementById('closeEditForm').addEventListener('click', function() {
                window.location.href = 'manage_courses.php';
            });
            // Apply faded effect on page load if edit form is visible
            document.getElementById('courseListContainer').classList.add('faded');
        }

        // Search Bar Functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#courseTable tbody tr');

            rows.forEach(row => {
                const title = row.cells[0].textContent.toLowerCase();
                const price = row.cells[1].textContent.toLowerCase();
                const description = row.cells[2].textContent.toLowerCase();
                const telegram = row.cells[5].textContent.toLowerCase();

                if (title.includes(searchTerm) || price.includes(searchTerm) || description.includes(searchTerm) || telegram.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>