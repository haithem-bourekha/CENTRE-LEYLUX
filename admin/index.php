<?php
// admin/index.php
// يجب أن تكون هذه الأسطر الأولى في الملف (قبل أي إخراج HTML)

// بدء الجلسة
session_start();

// استدعاء ملف الاتصال بقاعدة البيانات
require '../config.php';

// التحقق من تسجيل الدخول
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // بيانات الإدارة (يمكنك تحديثها لاحقًا)
    $admin_username = 'admin';
    $admin_password = 'admin123';

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Identifiants incorrects. Veuillez réessayer.';
    }
}

// منع الوصول المباشر إلى لوحة الإدارة بدون تسجيل الدخول
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Centre Leylux</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- أنماط مخصصة -->
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-8">
            <div class="logo">CL</div>
            <h1 class="text-3xl font-bold text-gray-800">Centre Leylux</h1>
            <p class="text-gray-600 mt-2">Connexion Administrateur</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-5">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Nom d'utilisateur
                </label>
                <input 
                    type="text" 
                    name="username" 
                    id="username" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                    placeholder="admin"
                    required
                    autocomplete="username"
                >
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Mot de passe
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button 
                type="submit" 
                name="login" 
                class="w-full btn-login text-white font-semibold py-3 rounded-lg"
            >
                Se connecter
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500">
            <p>© 2025 Centre Leylux. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>