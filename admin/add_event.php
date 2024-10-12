<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
<body class="d-flex align-items-center justify-content-center bg-light">
        <form action="add_event_proses.php" method="POST" class="p-5 border rounded bg-white shadow animasi" enctype="multipart/form-data">
            
            <h2 class="text-center">Add Event</h2><?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <div class="alert alert-danger" role="alert">
                    File type not supported
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="nama_event">Nama Event</label>
                <input type="text" id="nama_event" name="nama_event" class="form-control" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="nama_event">Waktu</label>
                <input type="time" id="waktu" name="waktu" class="form-control" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="nama_event">Lokasi</label>
                <input type="text" id="lokasi" name="lokasi" class="form-control" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="nama_event">Deskripsi</label>
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" required autocomplete="off">
            </div>

            <div class="form-group">
    <label for="tipe_tiket">Tipe Tiket</label>
    
    <!-- VVIP -->
    <div class="form-check">
        <input type="checkbox" id="vvip" name="tipe_tiket[]" value="vvip" class="form-check-input" onchange="toggleFields('vvip')">
        <label for="vvip" class="form-check-label">VVIP</label>
    </div>
    <div id="vvip-fields" class="d-none">
        <div class="form-group">
            <label for="vvip-harga">Harga VVIP</label>
            <input type="text" id="vvip-harga" name="vvip_harga" class="form-control">
        </div>
        <div class="form-group">
            <label for="vvip-kuota">Kuota Tiket VVIP</label>
            <input type="number" id="vvip-kuota" name="vvip_kuota" class="form-control">
        </div>
        <div class="form-group">
            <label for="vvip-benefit">Benefit VVIP</label>
            <input type="text" id="vvip-benefit" name="vvip_benefit" class="form-control">
        </div>
    </div>
    
    <!-- VIP -->
    <div class="form-check">
        <input type="checkbox" id="vip" name="tipe_tiket[]" value="vip" class="form-check-input" onchange="toggleFields('vip')">
        <label for="vip" class="form-check-label">VIP</label>
    </div>
    <div id="vip-fields" class="d-none">
        <div class="form-group">
            <label for="vip-harga">Harga VIP</label>
            <input type="text" id="vip-harga" name="vip_harga" class="form-control">
        </div>
        <div class="form-group">
            <label for="vip-kuota">Kuota Tiket VIP</label>
            <input type="number" id="vip-kuota" name="vip_kuota" class="form-control">
        </div>
        <div class="form-group">
            <label for="vip-benefit">Benefit VIP</label>
            <input type="text" id="vip-benefit" name="vip_benefit" class="form-control">
        </div>
    </div>
    
    <!-- CAT 1 -->
    <div class="form-check">
        <input type="checkbox" id="cat1" name="tipe_tiket[]" value="cat1" class="form-check-input" onchange="toggleFields('cat1')">
        <label for="cat1" class="form-check-label">CAT 1</label>
    </div>
    <div id="cat1-fields" class="d-none">
        <div class="form-group">
            <label for="cat1-harga">Harga CAT 1</label>
            <input type="text" id="cat1-harga" name="cat1_harga" class="form-control">
        </div>
        <div class="form-group">
            <label for="cat1-kuota">Kuota Tiket CAT 1</label>
            <input type="number" id="cat1-kuota" name="cat1_kuota" class="form-control">
        </div>
        <div class="form-group">
            <label for="cat1-benefit">Benefit CAT 1</label>
            <input type="text" id="cat1-benefit" name="cat1_benefit" class="form-control">
        </div>
    </div>
    
    <!-- CAT 2 -->
    <div class="form-check">
        <input type="checkbox" id="cat2" name="tipe_tiket[]" value="cat2" class="form-check-input" onchange="toggleFields('cat2')">
        <label for="cat2" class="form-check-label">CAT 2</label>
    </div>
    <div id="cat2-fields" class="d-none">
        <div class="form-group">
            <label for="cat2-harga">Harga CAT 2</label>
            <input type="text" id="cat2-harga" name="cat2_harga" class="form-control">
        </div>
        <div class="form-group">
            <label for="cat2-kuota">Kuota Tiket CAT 2</label>
            <input type="number" id="cat2-kuota" name="cat2_kuota" class="form-control">
        </div>
        <div class="form-group">
            <label for="cat2-benefit">Benefit CAT 2</label>
            <input type="text" id="cat2-benefit" name="cat2_benefit" class="form-control">
        </div>
    </div>
    
    <div class="form-check">
        <input type="checkbox" id="cat3" name="tipe_tiket[]" value="cat3" class="form-check-input" onchange="toggleFields('cat3')">
        <label for="cat3" class="form-check-label">CAT 3</label>
    </div>
    <div id="cat3-fields" class="d-none">
        <div class="form-group">
            <label for="cat3-harga">Harga CAT 3</label>
            <input type="text" id="cat3-harga" name="cat3_harga" class="form-control">
        </div>
        <div class="form-group">
            <label for="cat3-kuota">Kuota Tiket CAT 3</label>
            <input type="number" id="cat3-kuota" name="cat3_kuota" class="form-control">
        </div>
        <div class="form-group">
            <label for="cat3-benefit">Benefit CAT 3</label>
            <input type="text" id="cat3-benefit" name="cat3_benefit" class="form-control">
        </div>
    </div>
</div>

            <div class="form-group">
                <label for="banner_event">Banner Event</label>
                <input type="file" id="banner_event" name="banner_event" class="form-control" required>
            </div>

            <button type="submit" name="add_event" class="btn btn-primary btn-block">Add Event</button>
           
            
        </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function toggleFields(ticketType) {
        const fields = document.getElementById(ticketType + '-fields');
        if (document.getElementById(ticketType).checked) {
            fields.classList.remove('d-none');
        } else {
            fields.classList.add('d-none');
        }
    }
</script>
    
</body>
</html>
