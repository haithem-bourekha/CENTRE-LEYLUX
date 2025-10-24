<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Connexion Admin</h2>
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Nom d'utilisateur</label>
                    <input type="text" name="username" id="username" class="w-full p-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Mot de passe</label>
                    <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
                </div>
                <button type="submit" name="login" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">Connexion</button>
            </form>
            <?php
            session_start();
            if (isset($_POST['login'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                if ($username === 'admin' && $password === 'admin123') {
                    $_SESSION['admin'] = true;
                    header('Location: dashboard.php');
                } else {
                    echo "<p class='text-red-600 mt-4'>Identifiants incorrects.</p>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>