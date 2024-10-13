<?php
session_start();
require_once '../db.php';

$sql = "SELECT * FROM event_konser WHERE status_event = 'open'";
$resultEvents = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konserhub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../brand/icon.png" type="image/x-icon">
    <style>
        img {
            width: 100%;
            height: auto;
        }

        .slideshow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 60vh; /* Adjust the height as needed */
            overflow: hidden;
            z-index: -1; /* Places the slideshow behind the content */
        }

        .slideshow img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            position: absolute;
            transition: opacity 1s ease-in-out;
        }

        .slideshow img.active {
            opacity: 1;
        }
    </style>
    <script>
        function checkSession() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../check_session.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === "inactive") {
                        window.location.href = "../login/index.php";
                    }
                }
            };
            xhr.send();
        }
        setInterval(checkSession, 1);

        //slideshow
        let currentSlide = 0;

        function showSlides() {
            const slides = document.querySelectorAll('.slideshow img');
            slides.forEach((slide, index) => {
                slide.classList.remove('active');
                if (index === currentSlide) {
                    slide.classList.add('active');
                }
            });
            currentSlide = (currentSlide + 1) % slides.length;
        }

        document.addEventListener('DOMContentLoaded', () => {
            showSlides();
            setInterval(showSlides, 5000); // Change slide every 5 seconds
        });
    </script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
         <a href="#" class="text-2xl font-bold text-black">Konserhub</a>
            <ul class="flex space-x-6">
                <li><a href="index.php" class="text-black hover:text-[#7B61FF]">Home</a></li>
                <li><a href="events.php" class="text-black hover:text-[#7B61FF]">Events</a></li>
                <li><a href="profile.php" class="text-black hover:text-[#7B61FF]">Profile</a></li>
                <li><a href="../logout.php" class="text-black hover:text-[#7B61FF]">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="slideshow">        
        <img src="slide/slide1.jpg" alt="Slide 1">
        <img src="slide/slide2.jpg" alt="Slide 2">
        <img src="slide/slide3.jpg" alt="Slide 3">
        <img src="slide/slide4.jpg" alt="Slide 3">
        <img src="slide/slide5.jpg" alt="Slide 3">
    </div><br><br>

    <!-- Content Section -->
    <section class="bg-transparent py-20 relative">
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl font-bold text-white">
                Find concerts happening near you
            </h1>
        </div>
    </section>

    <!-- Content Section -->
    <section class="container mx-auto mt-10 p-5 bg-white rounded shadow">
        <h1 class="text-center text-3xl font-bold mb-5">Available events</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-4 text-green-600 bg-green-100 p-3 rounded">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-4 text-red-600 bg-red-100 p-3 rounded">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if ($resultEvents->rowCount() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <?php while($row = $resultEvents->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="flex border border-gray-300 rounded-lg overflow-hidden shadow-md hover:shadow-lg">
                    <div class="w-1/3">
                        <?php if ($row['banner_event']): ?>
                            <img src="../upload/<?= htmlspecialchars($row['banner_event']) ?>" alt="banner_event">
                        <?php else: ?>
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">No banner</div>
                        <?php endif; ?>
                    </div>
                    <div class="w-2/3 p-4 flex flex-col justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-[#7B61FF]"><?= htmlspecialchars($row['nama_event']) ?></h2>
                            <p class="text-gray-700"><strong>Tanggal:</strong> <?= htmlspecialchars($row['tanggal']) ?></p>
                            <p class="text-gray-700"><strong>Waktu:</strong> <?= htmlspecialchars($row['waktu']) ?></p>
                            <p class="text-gray-700"><strong>Lokasi:</strong> <?= htmlspecialchars($row['lokasi']) ?></p>
                            <p class="text-gray-700"><strong>Deskripsi:</strong> <?= htmlspecialchars($row['deskripsi']) ?></p>
                            <p class="text-gray-700"><strong>Partisipan:</strong> 
                                <?php
                                    $sqlTickets = "SELECT * FROM tiket WHERE id_event = :id_event";
                                    $stmtTickets = $db->prepare($sqlTickets);
                                    $stmtTickets->bindParam(':id_event', $row['id_event'], PDO::PARAM_INT);
                                    $stmtTickets->execute();

                                    $kuota = 0;
                                    $jumlah_sold = 0;

                                    while ($ticket = $stmtTickets->fetch(PDO::FETCH_ASSOC)) {
                                        $jumlah_sold += $ticket['jumlah_sold'];
                                        $kuota += $ticket['kuota'];
                                    }

                                    echo $jumlah_sold . " / " . $kuota;
                                ?>
                            </p>
                        </div>
                        <div class="mt-4">
                            <a href="regis.php?id_event=<?= htmlspecialchars($row['id_event']) ?>" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Register</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center mt-5">
                <p class="text-gray-600">Tidak ada event konser yang terbuka saat ini.</p>
            </div>
        <?php endif; ?>
    </section>


    <!-- Footer -->
<footer class="bg-black py-8 mt-10">
    <div class="container mx-auto px-4 text-center">
        <div class="flex justify-center space-x-6 mb-4">
            <a href="https://instagram.com" target="_blank">
                <img src="../brand/ig2.png" alt="Instagram" class="h-10 w-10 object-contain">
            </a>
            <a href="https://twitter.com" target="_blank">
                <img src="../brand/x.png" alt="X (Twitter)" class="h-10 w-8 object-contain">
            </a>
            <a href="https://tiktok.com" target="_blank">
                <img src="../brand/tiktok3.png" alt="TikTok" class="h-10 w-10 object-contain">
            </a>
        </div>
        <p class="text-white">© 2024 Konserhub. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
