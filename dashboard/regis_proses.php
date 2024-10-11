<?php
session_start();
require_once '../db.php'; // Adjust the path if necessary

// Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: ../login/index.php');
//     exit();
// }

if (isset($_POST['id_event'])) {
    $id_event = (int)$_POST['id_event'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $jumlah_tiket = (int)$_POST['jumlah_tiket'];

    // Validate the input
    if ($jumlah_tiket <= 0 || $jumlah_tiket > 5) {
        $_SESSION['error'] = 'You can only buy between 1 and 5 tickets.';
        header('Location: regis.php?id_event=' . $id_event);
        exit();
    }

    // Check if the email is already registered in the user table
    $sql_check_email = "SELECT * FROM user WHERE email = :email";
    $stmt_check = $db->prepare($sql_check_email);
    $stmt_check->execute(['email' => $email]);

    if ($stmt_check->rowCount() === 0) {
        $_SESSION['error'] = 'The email is not registered in the system. Please check your email.';
        header('Location: regis.php?id_event=' . $id_event);
        exit();
    }

    // Fetch the event details
    $sql = "SELECT jumlah_partisipan, jumlah_max_partisipan, status_event FROM event_konser WHERE id_event = :id_event";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id_event' => $id_event]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event || $event['status_event'] != 'open') {
        $_SESSION['error'] = 'Event is closed for registration.';
        header('Location: index.php');
        exit();
    }

    // Check if there are enough tickets available
    if ($jumlah_tiket > ($event['jumlah_max_partisipan'] - $event['jumlah_partisipan'])) {
        $_SESSION['error'] = 'Not enough tickets available.';
        header('Location: regis.php?id_event=' . $id_event);
        exit();
    }

    // Register the user for the event and update the participant count
    $new_participant_count = $event['jumlah_partisipan'] + $jumlah_tiket;
    $sql_update = "UPDATE event_konser SET jumlah_partisipan = :jumlah_partisipan WHERE id_event = :id_event";
    $stmt_update = $db->prepare($sql_update);
    $stmt_update->execute([
        'jumlah_partisipan' => $new_participant_count,
        'id_event' => $id_event
    ]);

    // Registration success
    $_SESSION['success'] = 'Successfully registered with ' . $jumlah_tiket . ' tickets!';
    header('Location: index.php');
    exit();
} else {
    // No event ID provided
    header('Location: index.php');
    exit();
}
