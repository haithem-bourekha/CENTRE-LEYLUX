<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formations</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles.css">
    <style>
        header {
            border-radius: 10px;
        }
        #diplomaText {
            font-size: 30px;
            direction: rtl;
            color: #dc2626; /* Ensure text color is visible */
        }
        #welcome {
            direction: rtl;
        }
        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 30;
            padding-top: 60px;
        }
        .mobile-menu.active {
            display: block;
        }
        .mobile-menu ul {
            list-style: none;
            padding: 0;
            text-align: center;
            background-color: #000;
        }
        .mobile-menu ul li {
            margin: 20px 0;
        }
        .mobile-menu ul li a {
            color: #fff;
            font-size: 1.5rem;
            text-decoration: none;
        }
        .mobile-menu ul li a:hover {
            color: #60a5fa;
        }
        .mobile-menu .search-container {
            padding: 0 20px;
            margin-bottom: 20px;
        }
        .mobile-menu .search-container input {
            width: 100%;
            padding: 10px 40px;
            border-radius: 8px;
            border: 1px solid #ccc;
            background-color: #fff;
            color: #000;
            font-size: 1rem;
        }
        .mobile-menu .search-container i {
            position: absolute;
            left: 30px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0; /* Remove default margin */
        }
        main {
            flex: 1 0 auto;
            margin-bottom: 2rem; /* Add space above footer */
        }
        footer {
            flex-shrink: 0;
            width: 100%;
        }
        /* Ensure diploma text container is visible */
        #diplomas .bg-white {
            position: relative; /* Change from absolute to relative for visibility */
            transform: none; /* Remove transform to avoid positioning issues */
            margin-left: auto; /* Align to right for RTL */
            margin-right: 0;
        }
    </style>
</head>
<body class="bg-gray-50">
    <main>
        <!-- Header -->
        <header class="bg-transparent text-black py-4 sticky top-0 z-20 backdrop-blur-md">
            <div class="container mx-auto flex items-center justify-between px-4">
                <div class="flex flex-col items-center">
                    <div class="flex items-center">
                        <img src="Uploads/logo5.png" alt="Logo" class="h-14 w-14 mr-3">
                        <h1 class="text-2xl font-bold">CENTRE LEYLUX DE FORMATION ET LANGUES</h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <nav class="hidden md:flex space-x-4">
                        <a href="#welcome" class="hover:text-gray-800">الصفحة الرئيسية</a>
                        <a href="#courses" class="hover:text-gray-800">الدورات التدريبية</a>
                        <a href="#diplomas" class="hover:text-gray-800">الشهادات</a>
                        <a href="#contact" class="hover:text-gray-800">اتصل بنا</a>
                    </nav>
                    <div class="relative md:block hidden">
                        <input type="text" id="courseSearch" class="course-search p-2 pl-10 border rounded-lg w-64" placeholder="Rechercher une formation...">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <button class="md:hidden text-black focus:outline-none z-30" id="menu-toggle">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
            <div class="mobile-menu" id="mobile-menu">
                <div class="search-container relative">
                    <input type="text" id="mobileCourseSearch" class="course-search" placeholder="Rechercher une formation...">
                    <i class="fas fa-search"></i>
                </div>
                <ul>
                    <li><a href="#welcome">الصفحة الرئيسية</a></li>
                    <li><a href="#courses">الدورات التدريبية</a></li>
                    <li><a href="#diplomas">الشهادات</a></li>
                    <li><a href="#contact">اتصل بنا</a></li>
                </ul>
            </div>
        </header>

        <!-- Section 1: Welcome with Background Video -->
        <section id="welcome" class="h-screen relative bg-gray-900">
            <div class="absolute inset-0 overflow-hidden">
                <video autoplay muted loop class="w-full h-full object-cover video-bg">
                    <source src="Uploads/section1.mp4" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
                <div class="absolute inset-0 bg-black opacity-50"></div>
            </div>
            <div class="container mx-auto px-4 flex flex-col md:flex-row items-center relative z-10 h-full">
                <div class="md:w-1/2 mb-8 md:mb-0 text-white flex flex-col justify-center">
                    <h2 class="text-4xl font-bold mb-4">مركز ليلُكس للتكوين والتعليم واللغات هو مركز احترافي للتعلم والتطوير، يقدّم برامج متميزة في مجالات متعددة، تجمع بين الجانب النظري والتطبيقي، بهدف تأهيل المتدربين واكتساب مهارات جديدة تفتح آفاق النجاح والتميز</p>
                    <a href="#courses" class="inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">عرض الدورات التدريبية</a>
                </div>
                <div class="md:w-1/2"></div>
            </div>
        </section>

        <!-- Section 2: Course Cards (Horizontal Row) -->
        <section id="courses" class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">دوراتنا التدريبية</h2>
                <div class="relative">
                    <div class="flex flex-row gap-6 overflow-x-auto pb-6 snap-x snap-mandatory" id="courseContainer">
                        <?php
                        $result = $conn->query("SELECT * FROM courses");
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $title = htmlspecialchars($row['title']);
                                $price = htmlspecialchars($row['price']);
                                $id = (int)$row['id'];
                                $photo = !empty($row['photo']) ? 'Uploads/' . htmlspecialchars($row['photo']) : 'Uploads/course1.jpg';
                        ?>
                            <div class="card flex-shrink-0 snap-center" role="article" aria-label="Carte : <?php echo $title; ?>">
                                <div class="hero" style="background-image: url('<?php echo $photo; ?>');"></div>
                                <div class="info" id="cardInfo-<?php echo $id; ?>">
                                    <div class="badge" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M16 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z"></path>
                                            <path d="M6 20c0-2.21 1.79-4 4-4h4c2.21 0 4 1.79 4 4"></path>
                                        </svg>
                                    </div>
                                    <div class="title-wrap">
                                        <div class="title"><?php echo $title; ?></div>
                                        <p class="text-blue-600 font-semibold"><?php echo number_format((float)$price, 0, ',', ' '); ?> DZD</p>
                                    </div>
                                    <button class="cta" id="openCard-<?php echo $id; ?>" aria-label="Voir la formation">
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <?php
                            }
                        } else {
                            echo '<p class="text-center text-gray-500 w-full">Aucune formation disponible pour le moment.</p>';
                        }
                        ?>
                    </div>
                    <!-- Pagination Controls -->
                    <div class="pagination flex justify-center items-center gap-2 mt-4" id="pagination">
                        <button class="pagination-arrow" data-direction="left" aria-label="Previous">&lt;</button>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            for ($i = 0; $i < $result->num_rows; $i++) {
                                $activeClass = $i === 0 ? 'active' : '';
                                echo "<span class='pagination-dot $activeClass' data-index='$i'></span>";
                            }
                        }
                        ?>
                        <button class="pagination-arrow" data-direction="right" aria-label="Next">&gt;</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 3: Diplomas -->
        <section id="diplomas" class="py-16 bg-gray-50 relative">
            <div class="container mx-auto px-4 flex flex-col md:flex-row items-start">
                <div class="w-full md:w-1/2 mb-8 md:mb-0 relative">
                    <img src="Uploads/diploma.jpg" alt="Diplôme" class="w-full h-auto object-cover">
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center"></div>
                </div>
                <div class="w-full md:w-1/2 md:pl-8">
                    <div class="bg-white text-red-600 p-4 md:p-6 rounded-lg shadow-lg">
                        <p id="diplomaText" class="mb-4 text-xl md:text-2xl lg:text-3xl"></p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contact" class="bg-black text-white py-4">
        <div class="container mx-auto px-4 text-center">
            <nav class="mb-2">
                 <a href="#welcome" class="hover:text-gray-800">الصفحة الرئيسية</a>
                 <a href="#courses" class="hover:text-gray-800">الدورات التدريبية</a>
                 <a href="#diplomas" class="hover:text-gray-800">الشهادات</a>
                 <a href="#contact" class="hover:text-gray-800">اتصل بنا</a>
            </nav>
            <div class="mb-2 flex justify-center space-x-4">
                <div class="mb-2 flex justify-center space-x-4">
    <a href="https://www.instagram.com/centre_leylux_de_formation?igsh=Z2x6YjgzbHEzbTE2" aria-label="Suivez-nous sur Instagram">
        <i class="fab fa-instagram"></i>
    </a>
    <a href="https://wa.me/+213662636315" aria-label="Contactez-nous sur WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    <a href="mailto:Leilabenarfa12@gmail.com" aria-label="Envoyer un email à contact@formations.com">
        <i class="fas fa-envelope"></i>
    </a>
</div>
            </div>
            <p class="text-sm" style="direction: rtl;">مركز LEYLUX هو فضاء للتكوين والتطوير الذاتي، نقدمو دورات احترافية في مختلف المجالات التعليمية واللغات، حضورياً أو عن بعد، بشهادات معترف بها من الدولة 🇩🇿. هدفنا نرافقوك خطوة بخطوة باش تطور مهاراتك وتفتح آفاق جديدة في حياتك المهنية 🌟</p>
            <p class="text-sm flex items-center justify-center">
    <i class="fas fa-map-marker-alt mr-1"></i>
    CENTRE LEYLUX DE FORMATION ET LANGUES à Batna
</p>
            <p class="text-sm">© Copyright CENTRE LEYLUX DE FORMATION ET LANGUES 2025</p>
        </div>
    </footer>

    <script>
        // Menu Mobile Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });

        // Close mobile menu when a link is clicked
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        });

        // Course Card Click Handlers
        document.querySelectorAll('[id^="openCard-"]').forEach(button => {
            button.addEventListener('click', function (e) {
                e.stopPropagation();
                const id = this.id.split('-')[1];
                window.location.href = `details.php?id=${id}`;
            });
        });

        document.querySelectorAll('[id^="cardInfo-"]').forEach(card => {
            card.addEventListener('click', function () {
                const id = this.id.split('-')[1];
                window.location.href = `details.php?id=${id}`;
            });
        });

        // Pagination Logic
        const container = document.getElementById('courseContainer');
        const dots = document.querySelectorAll('.pagination-dot');
        const arrows = document.querySelectorAll('.pagination-arrow');

        let scrollPosition = 0;
        const cardWidth = 360; // Width of each card (adjust if different)
        const containerWidth = container.offsetWidth;
        const maxScroll = container.scrollWidth - containerWidth;

        arrows.forEach(arrow => {
            arrow.addEventListener('click', () => {
                const direction = arrow.getAttribute('data-direction');
                if (direction === 'left' && scrollPosition > 0) {
                    scrollPosition -= cardWidth;
                } else if (direction === 'right' && scrollPosition < maxScroll) {
                    scrollPosition += cardWidth;
                }
                container.scrollTo({ left: scrollPosition, behavior: 'smooth' });

                // Update active dot
                const activeIndex = Math.round(scrollPosition / cardWidth);
                dots.forEach(dot => dot.classList.remove('active'));
                if (activeIndex < dots.length) {
                    dots[activeIndex].classList.add('active');
                }
            });
        });

        // Sync dot with scroll
        container.addEventListener('scroll', () => {
            scrollPosition = container.scrollLeft;
            const activeIndex = Math.round(scrollPosition / cardWidth);
            dots.forEach(dot => dot.classList.remove('active'));
            if (activeIndex < dots.length) {
                dots[activeIndex].classList.add('active');
            }
        });

        // Search Bar Filtering for both desktop and mobile
        document.querySelectorAll('.course-search').forEach(input => {
            input.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const cards = document.querySelectorAll('#courseContainer .card');
                let visibleCards = 0;

                cards.forEach(card => {
                    const title = card.querySelector('.title').textContent.toLowerCase();
                    if (title.includes(searchTerm)) {
                        card.style.display = '';
                        visibleCards++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Update pagination visibility
                const pagination = document.getElementById('pagination');
                if (visibleCards === 0) {
                    pagination.style.display = 'none';
                    const noResults = document.querySelector('#courseContainer .text-center.text-gray-500');
                    if (!noResults) {
                        document.querySelector('#courseContainer').innerHTML += '<p class="text-center text-gray-500 w-full">Aucune formation trouvée.</p>';
                    }
                } else {
                    pagination.style.display = 'flex';
                    const noResults = document.querySelector('#courseContainer .text-center.text-gray-500');
                    if (noResults) noResults.remove();
                }
            });
        });

        // Typing Effect for Diploma Text
        const diplomaTextElement = document.getElementById('diplomaText');
        const textToType = 'شهادات مركز Leylux لا تُعادل شهادات الدولة، وبالتالي لا يمكن استعمالها في الوظائف العمومية أو المسابقات الرسمية، لكنها صالحة ومعترف بها في القطاع الخاص، وتُعتبر موثوقة لأنها صادرة عن مؤسسة قانونية ومسجّلة رسميًا لدى الجهات المختصة.';
        let currentIndex = 0;

        function typeText() {
            if (currentIndex < textToType.length) {
                diplomaTextElement.textContent += textToType.charAt(currentIndex);
                currentIndex++;
                setTimeout(typeText, 50); // Adjust speed (50ms per character)
            }
        }

        // Trigger typing effect immediately as a fallback, and use observer as secondary
        typeText(); // Start typing immediately
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && currentIndex === 0) {
                    typeText();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(document.getElementById('diplomas'));
    </script>
</body>
</html>