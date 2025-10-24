<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
include '../config.php';

$client_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$client = $conn->query("SELECT * FROM clients WHERE id = $client_id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $wilaya = $conn->real_escape_string($_POST['wilaya']);
    $conn->query("UPDATE clients SET name = '$name', email = '$email', phone = '$phone', wilaya = '$wilaya' WHERE id = $client_id");
    header('Location: manage_clients.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Client</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="p-8">
        <h1 class="text-3xl font-bold mb-6">Modifier Client</h1>
        <form method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <label class="block text-gray-700">Nom</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($client['name']); ?>" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Numéro</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($client['phone'] ?? ''); ?>" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Wilaya</label>
                <input type="text" name="wilaya" value="<?php echo htmlspecialchars($client['wilaya'] ?? ''); ?>" class="w-full p-2 border rounded">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
        </form>
    </div>
</body>
</html>