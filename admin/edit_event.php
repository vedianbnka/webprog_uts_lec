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
      }Z
    }
  };
  xhr.send();
}

setInterval(checkSession, 1);
    </script>
</head>
<?php
    require_once "../db.php";

    $sql = "SELECT * FROM event_konser WHERE id_event = " . $_GET['id_event'];
    $event = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
?>
<body class="d-flex align-items-center justify-content-center bg-light">
        <form action="edit_event_proses.php?id_event=<?= $event['id_event'] ?>" method="POST" class="p-5 border rounded bg-white shadow animasi" enctype="multipart/form-data">
            
            <h2 class="text-center">Edit Event</h2>
            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <div class="alert alert-danger" role="alert">
                    File type not supported
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="nama_event">Nama Event</label>
                <input type="text" id="nama_event" name="nama_event" class="form-control" value="<?= $event['nama_event'] ?>" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?= $event['tanggal'] ?>" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="nama_event">Waktu</label>
                <input type="time" id="waktu" name="waktu" class="form-control" value="<?= $event['waktu'] ?>" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="nama_event">Lokasi</label>
                <input type="text" id="lokasi" name="lokasi" class="form-control" value="<?= $event['lokasi'] ?>" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="nama_event">Deskripsi</label>
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?= $event['deskripsi'] ?>" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="jumlah_max_partisipan">Jumlah Max Partisipan</label>
                <input type="number" id="jumlah_max_partisipan" name="jumlah_max_partisipan" class="form-control" value="<?= $event['jumlah_max_partisipan'] ?>" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="banner_event">Banner Event</label>
                <input type="file" id="banner_event" name="banner_event" class="form-control" required>
            </div>

            <button type="submit" name="add_event" class="btn btn-primary btn-block">Edit Event</button>
           
            
        </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>
