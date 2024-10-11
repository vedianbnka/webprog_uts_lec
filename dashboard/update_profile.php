<?php
session_start();
require '../db.php';

// if (!isset($_SESSION['id'])) {
//     header('Location: index.php');
//     exit;
// }

$id_user = $_SESSION['id'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$new_password = $_POST['new_password'];
$old_password = $_POST['old_password'];

$sql = "SELECT password FROM user WHERE id_user = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$id_user]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found!";
    exit;
}

if (!password_verify($old_password, $user['password'])) {
    header('Location: profile.php?error=1');
    exit;
}

$hashed_new_password = $user['password']; 
if (!empty($new_password)) {
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
}

$update_query = "UPDATE user SET nama = ?, email = ?, phone = ?, password = ? WHERE id_user = ?";
$stmt = $db->prepare($update_query);
$update_status = $stmt->execute([$nama, $email, $phone, $hashed_new_password, $id_user]);

if ($update_status) {
    echo "Profile updated successfully!";
    header('Location: profile.php?success=1');
    exit;
} else {
    echo "Error updating profile.";
    exit;
}
?>
