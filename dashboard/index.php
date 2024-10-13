<?php
session_start();
require_once '../db.php';

// Batasi jumlah event yang diambil, defaultnya 6 event
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 4;
$sql = "SELECT * FROM event_konser WHERE status_event = 'open' LIMIT :limit";
$stmt = $db->prepare($sql);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$resultEvents = $stmt;

// Ambil total jumlah event untuk menghitung apakah masih ada event lain yang belum ditampilkan
$sqlTotal = "SELECT COUNT(*) FROM event_konser WHERE status_event = 'open'";
$totalEvents = $db->query($sqlTotal)->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konserhub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../brand/icon.png" type="image/x-icon">

    <!-- Include Swiper.js CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <style>
        .swiper {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .swiper-pagination-bullet {
            background-color: #7B61FF;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #7B61FF;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-black">Konserhub</a>
            <ul class="flex space-x-6">
                <li><a href="#" class="text-black hover:text-[#7B61FF]">Home</a></li>
                <li><a href="events.php" class="text-black hover:text-[#7B61FF]">Events</a></li>
                <li><a href="profile.php" class="text-black hover:text-[#7B61FF]">Profile</a></li>
                <li><a href="../logout.php" class="text-black hover:text-[#7B61FF]">Logout</a></li>
            </ul>
        </div>
    </nav>

    <!-- Content Section with Carousel -->
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
            <div class="swiper mySwiper mt-6">
                <div class="swiper-wrapper">
                    <?php while($row = $resultEvents->fetch(PDO::FETCH_ASSOC)): ?>
                        <div class="swiper-slide">
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
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>

                <!-- Navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        <?php else: ?>
            <div class="text-center mt-5">
                <p class="text-gray-600">Tidak ada event konser yang terbuka saat ini.</p>
            </div>
        <?php endif; ?>

        <!-- Tombol See More -->
        <?php if ($limit < $totalEvents): ?>
            <div class="text-center mt-5 mb-6">
                <br>
                <a href="events.php?limit=<?= $limit + 6 ?>" class="mt-6 px-6 py-3 bg-[#7B61FF] text-white rounded-md shadow-lg hover:bg-[#6A52E0]">See More ></a>
                <br>
            </div>
        <?php endif; ?>
    </section>



    <!-- Initialize Swiper.js -->
    <script>
        const swiper = new Swiper('.mySwiper', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            breakpoints: {
                // when window width is >= 640px
                640: {
                    slidesPerView: 2,
                },
                // when window width is >= 1024px
                1024: {
                    slidesPerView: 3,
                },
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
    <footer class="bg-black py-8 mt-10">
        <div class="container mx-auto px-4 text-center">
            <div class="flex justify-center space-x-6 mb-4">
                <a href="https://instagram.com" target="_blank">
                    <img src="../brand/ig2.png" alt="Instagram" class="h-10 w-10 object-contain">
                </a>
                <a href="https://twitter.com" target="_blank">
                    <img src="../brand/x.png" alt="X (Twitter)" class="h-10 w-8 object-contain">
                </a>
            </div>
            <p class="text-white text-sm">&copy; 2024 Konserhub. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
