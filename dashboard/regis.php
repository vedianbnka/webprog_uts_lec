<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Form Registrasi Tiket</h1>
        <form action="regis_proses.php" method="POST">
            <div class="mb-3">
                <label for="id_user" class="form-label">ID User</label>
                <input type="text" class="form-control" id="id_user" name="id_user" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="id_event" class="form-label">Pilih Event</label>
                <select class="form-select" id="id_event" name="id_event" required>
                    <?php
                    require_once "../db.php";
                    $sql = "SELECT * FROM event_konser WHERE status_event = 'open'";
                    $result = $db->query($sql);

                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($row['id_event']) . "'>" . htmlspecialchars($row['nama_event']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="jenis_tiket" class="form-label">Jenis Tiket</label>
                <select class="form-select" id="jenis_tiket" name="jenis_tiket" required>
                    <option value="regular">Regular</option>
                    <option value="VIP">VIP</option>
                    <option value="meet_and_greet">Meet & Greet</option>
                    <!-- Tambahkan jenis tiket lainnya jika perlu -->
                </select>
            </div>
            <div class="mb-3">
                <label for="jumlah_tiket" class="form-label">Jumlah Tiket</label>
                <input type="number" class="form-control" id="jumlah_tiket" name="jumlah_tiket" required min="1">
            </div>
            <button type="submit" class="btn btn-primary">Daftar Tiket</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
