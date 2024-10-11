<?php
session_start();
require_once '../db.php'; // Adjust the path if necessary

// Fetch all events from the event_konser table
$sql = "SELECT id_event, nama_event, tanggal, waktu, lokasi, deskripsi, jumlah_partisipan, jumlah_max_partisipan, banner_event, status_event FROM event_konser WHERE status_event = 'open'";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Event Konser</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Daftar Event Konser</h1>

        <!-- Profile link -->
        <div class="text-end mb-3">
            <a href="profile.php" class="btn btn-info">My Profile</a>
        </div>

        <!-- Display success or error message -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if ($result->rowCount() > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Event</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Lokasi</th>
                            <th>Deskripsi</th>
                            <th>Partisipan</th>
                            <th>Banner</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_event']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td><?= htmlspecialchars($row['waktu']) ?></td>
                            <td><?= htmlspecialchars($row['lokasi']) ?></td>
                            <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                            <td><?= htmlspecialchars($row['jumlah_partisipan']) . "/" . htmlspecialchars($row['jumlah_max_partisipan']) ?></td>
                            <td>
                                <?php if ($row['banner_event']): ?>
                                    <img src="../upload/<?= htmlspecialchars($row['banner_event']) ?>" alt="Banner" class="img-fluid" style="max-width: 100px;">
                                <?php else: ?>
                                    No banner
                                <?php endif; ?>
                            </td>
                            <td><?= ucfirst(htmlspecialchars($row['status_event'])) ?></td>
                            <td>
                                <a href="regis.php?id_event=<?= htmlspecialchars($row['id_event']) ?>" class="btn btn-success">Register</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Tidak ada event konser yang terbuka saat ini.
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap 5 JS and Popper.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
