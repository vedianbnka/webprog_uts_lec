<?php
session_start();
require_once '../db.php'; // Adjust the path if necessary

// // Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: ../login/index.php');
//     exit();
// }

// Check if event ID is provided
if (!isset($_GET['id_event'])) {
    $_SESSION['error'] = 'No event selected.';
    header('Location: index.php');
    exit();
}

$id_event = (int)$_GET['id_event'];

// Fetch event details
$sql = "SELECT nama_event, jumlah_partisipan, jumlah_max_partisipan, status_event FROM event_konser WHERE id_event = :id_event";
$stmt = $db->prepare($sql);
$stmt->execute(['id_event' => $id_event]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    $_SESSION['error'] = 'Event not found.';
    header('Location: index.php');
    exit();
}

// Display form only if event is open and has available slots
if ($event['status_event'] != 'open' || $event['jumlah_partisipan'] >= $event['jumlah_max_partisipan']) {
    $_SESSION['error'] = 'Event is full or closed for registration.';
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Event: <?= htmlspecialchars($event['nama_event']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Register for Event: <?= htmlspecialchars($event['nama_event']) ?></h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="regis_proses.php" method="POST">
        <input type="hidden" name="id_event" value="<?= $id_event ?>">

        <div class="mb-3">
            <label for="email" class="form-label">Email (must be registered)</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>

        <div class="mb-3">
            <label for="jumlah_tiket" class="form-label">Jumlah Tiket (max 5)</label>
            <input type="number" class="form-control" id="jumlah_tiket" name="jumlah_tiket" min="1" max="5" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
