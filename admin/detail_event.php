<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../brand/icon.png" type="image/x-icon">

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

        function goBack() {
            window.history.back();
        }
    </script>

    <style>
        @keyframes slideSide {
            0% {
                transform: translateX(-100px);
                opacity: 0;
            }
            100% {
                transform: translateX(0px);
                opacity: 1;
            }
        }

        .animasi {
            animation: slideSide 1s;
        }
    </style>
</head>
<body class="relative min-h-screen bg-white-900 flex items-center justify-center">

    <div class="absolute top-6 left-10">
        <img src="../brand/logo1.png" alt="Website Logo" class="h-7 w-auto">
    </div>

    <div class="p-4 bg-opacity-90 border rounded-lg bg-white shadow-xl animasi max-w-md w-full mx-4">
        <?php
            require_once ("../db.php");

            $sql = "SELECT * FROM event_konser WHERE id_event = ?";
            $statement = $db->prepare($sql);
            $statement->execute([$_GET['id_event']]);
            $event = $statement->fetch();
        ?>
        <h1 class="text-2xl font-semibold text-[#7B61FF] mb-4 text-center"><?php echo $event['nama_event']; ?></h1>
        <img src="../upload/<?php echo $event['banner_event']; ?>" alt="Event Banner" class="w-full h-64 object-cover rounded-lg mb-4 shadow-md">
        
        <div class="grid grid-cols-1 gap-2 md:grid-cols-3 mb-4">
            <div class="flex items-center text-gray-700">
                <span class="text-lg">📅 :</span>
                <span class="ml-2 text-sm"><?php echo $event['tanggal']; ?></span>
            </div>
            <div class="flex items-center text-gray-700">
                <span class="text-lg">⏰ :</span>
                <span class="ml-2 text-sm"><?php echo $event['waktu']; ?></span>
            </div>
            <div class="flex items-center text-gray-700">
                <span class="text-lg">📍 :</span>
                <span class="ml-2 text-sm"><?php echo $event['lokasi']; ?></span>
            </div>
        </div>

        <p class="text-gray-800 text-justify leading-relaxed mb-4">
            <?php echo nl2br($event['deskripsi']); ?>
        </p>

        <div class="flex justify-center">
            <button 
                onclick="goBack()" 
                class="px-4 py-2 bg-[#7B61FF] text-white rounded-md hover:bg-[#6a51e2] transition duration-200 ease-in-out"
            >
                Back
            </button>
        </div>
    </div>
</body>
</html>
