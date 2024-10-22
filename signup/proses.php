<?php
session_start();
require '../db.php';
$nama = $_POST['nama'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

if ($password != $confirm_password) {
    header("location:index.php?error=1");
    exit;
}

$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    header("location:index.php?error=2");
    exit;
}

$sql = "SELECT * FROM admin WHERE email = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$email]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin) {
    header("location:index.php?error=2");
    exit;
}

$hashPw = password_hash($password, PASSWORD_BCRYPT);
$sql = "INSERT INTO user(nama,email,phone,password,role) VALUES (?,?,?,?,?)";
$stmt = $db->prepare($sql);
$data = [$nama, $email, $phone, $hashPw, 'user'];
$stmt->execute($data);

$_SESSION['success'] = "Registrasi berhasil. Silahkan Login!";
header("location:../login/index.php");