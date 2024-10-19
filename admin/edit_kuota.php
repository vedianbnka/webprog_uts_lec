<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
    <script>
        function checkSession() {
  // Kirim permintaan AJAX ke check_session.php
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "../check_session_admin.php", true);
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
<?php
    require_once "../db.php";
    $id_event = $_GET['id_event'];
    $sql = "SELECT * FROM event_konser WHERE id_event = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id_event]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<body class="d-flex align-items-center vh-100 justify-content-center bg-light">
        <form action="edit_kuota_proses.php?id_event=<?= $event['id_event'] ?>" method="POST" class="p-5 border rounded bg-white shadow animasi" enctype="multipart/form-data">
            
            <h2 class="text-center">Edit Kuota</h2>
           
            <div class="form-group">
                <label for="nama_event">Nama Event</label>
                <input type="text" id="nama_event" name="nama_event" class="form-control" value="<?= $event['nama_event'] ?>" readonly autocomplete="off">
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= $event['tanggal'] ?>" readonly autocomplete="off">
            </div>

            <?php
                $sql = "SELECT * FROM tiket WHERE id_event = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$event['id_event']]);
                $tiket = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($tiket as $tiket) {
                    if ($tiket['tipe_tiket'] == 'VVIP') {
            ?>
            <div class="form-group">
                <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                <input type="number" id="kuota" name="kuota_VVIP" class="form-control" value="<?= $tiket['kuota'] ?>" required autocomplete="off">            </div>
            <?php
                }
                if ($tiket['tipe_tiket'] == 'VIP') {
            ?>
            <div class="form-group">
                <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                <input type="number" id="kuota" name="kuota_VIP" class="form-control" value="<?= $tiket['kuota'] ?>" required autocomplete="off">            </div>
            <?php
                }
                if ($tiket['tipe_tiket'] == 'CAT 1') {
            ?>
            <div class="form-group">
                <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                <input type="number" id="kuota" name="kuota_CAT1" class="form-control" value="<?= $tiket['kuota'] ?>" required autocomplete="off">            </div>
            <?php
                }
                if ($tiket['tipe_tiket'] == 'CAT 2') {
            ?>
            <div class="form-group">
                <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                <input type="number" id="kuota" name="kuota_CAT2" class="form-control" value="<?= $tiket['kuota'] ?>" required autocomplete="off">            </div>
            <?php
                }
                if ($tiket['tipe_tiket'] == 'CAT 3') {
            ?>
            <div class="form-group">
                <label for="tipe_tiket"><?= $tiket['tipe_tiket'] ?></label>
                <input type="number" id="kuota" name="kuota_CAT3" class="form-control" value="<?= $tiket['kuota'] ?>" required autocomplete="off">            </div>
            <?php
                }}
            ?>
            <button type="submit" name="add_event" class="btn btn-primary btn-block">Submit</button>
           
            
        </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>
