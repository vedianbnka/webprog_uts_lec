<?php
session_start();

// Cek apakah username ada dalam sesi
if (isset($_SESSION['nama'])) {
    echo json_encode(['status' => 'active']);
} else {
    echo json_encode(['status' => 'inactive']);
}
?>