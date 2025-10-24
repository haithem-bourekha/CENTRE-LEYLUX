<?php
include 'config.php';

// Configuration centralisée
define('CCP_NUMBER', '0025854185 clé 15 ');
define('INSTAGRAM_LINK', 'https://www.instagram.com/centre_leylux_de_formation?igsh=Z2x6YjgzbHEzbTE2');

// Validation de l'ID de la formation
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("<p class='text-red-600 text-center'>ID de formation invalide.</p>");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Formation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            position: relative;
            margin: 0;
            background: #f3f4f6;
        }
        #detailsBackground {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 1;
            overflow-y: auto; /* Enable vertical scrolling for the background container */
        }
        #detailsBackground::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 2;
        }
        .content-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            max-width: 7xl;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 3;
            min-height: 100vh; /* Ensure content takes at least full viewport height */
        }
        .content-container, .description-container {
            flex: 1;
            min-width: 300px;
            padding: 1.5rem;
            border-radius: 0.5rem;
        }
        .content-container {
            color: white;
        }
        .description-container {
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        #purchaseFormContainer {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        #purchaseFormContainer.show {
            opacity: 1;
            visibility: visible;
        }
        #detailsBackground.faded {
            opacity: 0.3;
            transition: opacity 0.3s ease;
        }
        .modal-content {
            transform: scale(0.7);
            transition: transform 0.3s ease;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            background: white;
            border-radius: 0.5rem;
            max-height: 90vh;
            overflow-y: auto;
            width: 100%;
            max-width: 90vw;
        }
        #purchaseFormContainer.show .modal-content {
            transform: scale(1);
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .form-row > div {
            flex: 1;
            min-width: 150px;
        }
        .status-message {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 0.5rem;
        }
        .status-message.success {
            background: #d1fae5;
            color: #065f46;
        }
        .status-message.error {
            background: #fee2e2;
            color: #991b1b;
        }
        .status-message.info {
            background: #dbeafe;
            color: #1e40af;
        }
        /* Mobile-specific adjustments */
        @media (max-width: 640px) {
            .content-row {
                flex-direction: column;
                padding: 1rem;
            }
            .content-container, .description-container {
                min-width: 100%;
                padding: 1rem;
            }
            .content-container h2 {
                font-size: 1.5rem;
            }
            .content-container p, .description-container p {
                font-size: 0.875rem;
            }
            .content-container button {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
            .modal-content {
                max-width: 95vw;
                padding: 1rem;
            }
            .modal-content h2 {
                font-size: 1.25rem;
            }
            .form-row {
                flex-direction: column;
            }
            .form-row > div {
                min-width: 100%;
            }
            .form-row input, .form-row select {
                font-size: 0.875rem;
                padding: 0.5rem;
            }
            .form-row button {
                padding: 0.75rem;
                font-size: 0.875rem;
            }
            .status-message {
                font-size: 0.875rem;
                padding: 0.75rem;
            }
            audio {
                width: 100%;
                max-width: 100%;
            }
        }
        @media (max-width: 400px) {
            .content-row {
                padding: 0.5rem;
            }
            .content-container, .description-container {
                padding: 0.75rem;
            }
            .modal-content {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Course Details as Background -->
    <div id="detailsBackground" style="background-image: url('<?php
        $stmt = $conn->prepare("SELECT photo FROM courses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $course = $result->fetch_assoc();
        $stmt->close();
        echo !empty($course['photo']) ? 'Uploads/' . htmlspecialchars($course['photo']) : 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Crect width=%22100%22 height=%22100%22 fill=%22%23e5e7eb%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%23555%22%3EAucune image%3C/text%3E%3C/svg%3E';
    ?>');">
        <?php
        $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $course = $result->fetch_assoc();
        $stmt->close();
        if ($course) {
        ?>
            <div class="content-row">
                <div class="content-container">
                    <h2 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($course['title']); ?></h2>
                    <p class="text-gray-200 mb-4">Prix: <?php echo number_format((float)$course['price'], 2); ?> DZD</p>
                    <?php if (!empty($course['audio'])) { ?>
                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Présentation Vocale</label>
                            <audio controls class="w-full">
                                <source src="Uploads/<?php echo htmlspecialchars($course['audio']); ?>" type="audio/mpeg">
                                Votre navigateur ne supporte pas l'audio.
                            </audio>
                        </div>
                    <?php } else { ?>
                        <p class="text-gray-300 mb-4">Aucune présentation vocale disponible.</p>
                    <?php } ?>
                    <button id="togglePurchaseForm" class="inline-block bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">Acheter maintenant</button>
                </div>
                <div class="description-container">
                    <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
                </div>
            </div>
        <?php } else { ?>
            <p class="text-red-600 text-center" style="position: relative; z-index: 3;">Formation non trouvée.</p>
        <?php } ?>
    </div>

    <!-- Purchase Form Modal (Foreground) -->
    <div id="purchaseFormContainer">
        <div class="modal-content">
            <?php if ($course) { ?>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Inscription: <?php echo htmlspecialchars($course['title']); ?></h2>
                    <button id="closePurchaseForm" class="text-gray-600 hover:text-gray-800 text-xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="modalContent">
                    <!-- Email Verification Form -->
                    <form id="emailForm">
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700">Email</label>
                            <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
                        </div>
                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 w-full">Vérifier</button>
                    </form>
                </div>
            <?php } else { ?>
                <p class="text-red-600 text-center mt-4">Formation non trouvée.</p>
            <?php } ?>
        </div>
    </div>

    <script>
        // Toggle Purchase Form
        document.getElementById('togglePurchaseForm').addEventListener('click', function() {
            const form = document.getElementById('purchaseFormContainer');
            const detailsBackground = document.getElementById('detailsBackground');
            form.classList.add('show');
            detailsBackground.classList.add('faded');
            // Reset modal content to email form
            document.getElementById('modalContent').innerHTML = `
                <form id="emailForm">
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm">Email</label>
                        <input type="email" name="email" id="email" class="w-full p-2 border rounded text-sm" required>
                    </div>
                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full text-sm">Vérifier</button>
                </form>
            `;
            attachEmailFormListener();
        });

        // Close Purchase Form
        document.getElementById('closePurchaseForm').addEventListener('click', function() {
            const form = document.getElementById('purchaseFormContainer');
            const detailsBackground = document.getElementById('detailsBackground');
            form.classList.remove('show');
            detailsBackground.classList.remove('faded');
        });

        // Close on outside click
        document.getElementById('purchaseFormContainer').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('show');
                document.getElementById('detailsBackground').classList.remove('faded');
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const form = document.getElementById('purchaseFormContainer');
                const detailsBackground = document.getElementById('detailsBackground');
                form.classList.remove('show');
                detailsBackground.classList.remove('faded');
            }
        });

        // Client-side validation and AJAX for email form
        function attachEmailFormListener() {
            const emailForm = document.getElementById('emailForm');
            if (emailForm) {
                emailForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = document.getElementById('email').value.trim();
                    const course_id = <?php echo $course['id']; ?>;
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        alert('Veuillez entrer un email valide.');
                        return;
                    }

                    // AJAX request to check client registration
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'check_registration.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);
                            const modalContent = document.getElementById('modalContent');
                            if (response.error) {
                                modalContent.innerHTML = `<p class="status-message error text-sm">❌ ${response.error}</p>`;
                                return;
                            }
                            if (response.exists && response.status) {
                                if (response.status === 'confirmed') {
                                    modalContent.innerHTML = `
                                        <p class="status-message success text-sm">🎉 Bienvenue ! Votre inscription à la formation <strong><?php echo htmlspecialchars($course['title']); ?></strong> est confirmée.</p>
                                        <p class="text-gray-700 mt-2 text-sm">Rejoignez le groupe Telegram de la formation : <a href="<?php echo htmlspecialchars($course['telegram_link'] ?? '#'); ?>" class="text-blue-600 underline"><?php echo htmlspecialchars($course['telegram_link'] ?? '#'); ?></a></p>
                                    `;
                                } else if (response.status === 'refused') {
                                    modalContent.innerHTML = `
                                        <p class="status-message error text-sm">😔 Malheureusement, il y a un problème avec votre inscription. Contactez l'administrateur.</p>
                                        <p class="text-gray-700 mt-2 text-sm">Envoyez un message via Instagram : <a href="<?php echo INSTAGRAM_LINK; ?>" class="text-blue-600 underline"><?php echo INSTAGRAM_LINK; ?></a></p>
                                    `;
                                } else {
                                    modalContent.innerHTML = `
                                        <p class="status-message info text-sm">ℹ️ Vous êtes déjà inscrit à la formation <strong><?php echo htmlspecialchars($course['title']); ?></strong>. Votre inscription est en attente de confirmation.</p>
                                    `;
                                }
                            } else {
                                // Show registration form
                                modalContent.innerHTML = `
                                    <form method="POST" action="" id="registrationForm">
                                        <div class="form-row mb-4">
                                            <div>
                                                <label for="name" class="block text-gray-700 text-sm">Nom</label>
                                                <input type="text" name="name" id="name" class="w-full p-2 border rounded text-sm" required>
                                            </div>
                                            <div>
                                                <label for="email" class="block text-gray-700 text-sm">Email</label>
                                                <input type="email" name="email" id="email" class="w-full p-2 border rounded text-sm" value="${email}" required>
                                            </div>
                                            <div>
                                                <label for="phone" class="block text-gray-700 text-sm">Numéro de téléphone</label>
                                                <input type="text" name="phone" id="phone" class="w-full p-2 border rounded text-sm" required>
                                            </div>
                                        </div>
                                        <div class="form-row mb-4">
                                            <div>
                                                <label for="wilaya" class="block text-gray-700 text-sm">Wilaya</label>
                                                <select name="wilaya" id="wilaya" class="w-full p-2 border rounded text-sm" required>
                                                    <option value="" disabled selected>Sélectionnez une wilaya</option>
                                                    <?php
                                                    $wilayas = [
                                                        'أدرار', 'الشلف', 'الأغواط', 'أم البواقي', 'باتنة', 'بجاية', 'بسكرة', 'بشار',
                                                        'البليدة', 'البويرة', 'تمنراست', 'تبسة', 'تلمسان', 'تيارت', 'تيزي وزو',
                                                        'الجزائر', 'الجلفة', 'جيجل', 'سطيف', 'سعيدة', 'سكيكدة', 'سيدي بلعباس',
                                                        'عنابة', 'قالمة', 'قسنطينة', 'المدية', 'مستغانم', 'المسيلة', 'معسكر',
                                                        'ورقلة', 'وهران', 'البيض', 'إليزي', 'برج بوعريريج', 'بومرداس', 'الطارف',
                                                        'تيندوف', 'تيسمسيلت', 'الوادي', 'خنشلة', 'سوق أهراس', 'تيبازة', 'ميلة',
                                                        'عين الدفلى', 'النعامة', 'عين تيموشنت', 'غرداية', 'غليزان', 'تيميمون',
                                                        'برج باجي مختار', 'أولاد جلال', 'بني عباس', 'عين صالح', 'عين قزام',
                                                        'توقرت', 'جانت', 'المغير', 'الحدائق'
                                                    ];
                                                    foreach ($wilayas as $wilaya) {
                                                        echo "<option value=\"" . htmlspecialchars($wilaya) . "\">" . htmlspecialchars($wilaya) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                        <button type="submit" name="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full text-sm">Confirmer l'achat</button>
                                    </form>
                                `;
                                attachRegistrationFormListener();
                            }
                        }
                    };
                    xhr.send(`email=${encodeURIComponent(email)}&course_id=${course_id}`);
                });
            }
        }

        // Client-side validation for registration form
        function attachRegistrationFormListener() {
            const registrationForm = document.getElementById('registrationForm');
            if (registrationForm) {
                registrationForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const name = document.getElementById('name').value.trim();
                    const email = document.getElementById('email').value.trim();
                    const phone = document.getElementById('phone').value.trim();
                    const wilaya = document.getElementById('wilaya').value;
                    const course_id = <?php echo $course['id']; ?>;

                    // Validate name
                    if (name.length < 2) {
                        alert('Le nom doit contenir au moins 2 caractères.');
                        return;
                    }

                    // Validate email
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        alert('Veuillez entrer un email valide.');
                        return;
                    }

                    // Validate phone (Algerian number)
                    const phoneRegex = /^(?:\+213|0)[5-7][0-9]{8}$/;
                    if (!phoneRegex.test(phone)) {
                        alert('Veuillez entrer un numéro de téléphone algérien valide (ex. +2136xxxxxxxx ou 06xxxxxxxx).');
                        return;
                    }

                    // Validate wilaya
                    if (!wilaya) {
                        alert('Veuillez sélectionner une wilaya.');
                        return;
                    }

                    // AJAX request to submit registration
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'register.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);
                            const modalContent = document.getElementById('modalContent');
                            if (response.error) {
                                modalContent.innerHTML = `<p class="status-message error text-sm">❌ ${response.error}</p>`;
                            } else {
                                modalContent.innerHTML = `
                                    <p class="status-message success text-sm">✅ Merci pour votre inscription à la formation <strong><?php echo htmlspecialchars($course['title']); ?></strong> !</p>
                                    <p class="text-gray-700 mt-2 text-sm">Payez le prix de la formation <strong><?php echo number_format((float)$course['price'], 2); ?> DZD</strong> dans le CCP : <strong><?php echo CCP_NUMBER; ?></strong>.</p>
                                    <p class="text-gray-700 mt-2 text-sm">Envoyez le reçu de paiement via Instagram à : <a href="<?php echo INSTAGRAM_LINK; ?>" class="text-blue-600 underline"><?php echo INSTAGRAM_LINK; ?></a>.</p>
                                    <p class="text-gray-700 mt-2 text-sm">Attendez la réponse de l'administrateur. Merci pour votre inscription !</p>
                                `;
                            }
                        }
                    };
                    xhr.send(`name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}&wilaya=${encodeURIComponent(wilaya)}&course_id=${course_id}`);
                });
            }
        }

        // Initial attachment of email form listener
        attachEmailFormListener();
    </script>
</body>
</html>