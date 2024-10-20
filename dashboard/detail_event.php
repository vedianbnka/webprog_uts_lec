<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    </script>
</head>
<body>
    <?php
        require_once ("../db.php");

        $sql = "SELECT * FROM event_konser WHERE id_event = ?";
        $statement = $db->prepare($sql);
        $statement->execute([$_GET['id_event']]);
        $event = $statement->fetch();
    ?>
    <h1><?php echo $event['nama_event']; ?></h1>
    <img src="../upload/<?php echo $event['banner_event']; ?>" alt="">
    <h3>📅 : <?php echo $event['tanggal']; ?></h3>
    <h3>⏰ : <?php echo $event['waktu']; ?></h3>
    <h3>📍 : <?php echo $event['lokasi']; ?></h3>

    <p>
        <?php echo $event['deskripsi']; ?>
    </p>



</body>
</html>