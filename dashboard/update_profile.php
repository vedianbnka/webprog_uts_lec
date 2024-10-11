<?php
session_start();
require '../db.php'; // Pastikan file ini berisi koneksi ke database

$nama = $_POST['nama'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$new_password = $_POST['new_password'];
$old_password = $_POST['old_password'];

$id_user = $_SESSION['id_user'];

$query = "SELECT password FROM user WHERE id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$stmt->bind_result($hashed_password);
$stmt->fetch();
$stmt->close();

if (password_verify($old_password, $hashed_password)) {
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    $update_query = "UPDATE user SET nama = ?, email = ?, phone = ?, password = ? WHERE id_user = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssi", $nama, $email, $phone, $hashed_new_password, $id_user);

    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Old password is incorrect!";
}

$conn->close();
?>
