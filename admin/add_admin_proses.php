<?php
    session_start();

    if (!isset($_SESSION["role"]) && $_SESSION["role"] != "admin") {
        header('Location: ../dashboard/index.php');
        exit();
    }

    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        require_once'../db.php';

        $nama = $_POST['nama'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password != $confirm_password) {
        header ("location:index.php?error=1");
        exit;
    }else {
        $sql = "INSERT INTO user(nama,email,phone,password,role) VALUES (?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $data = [$nama, $email, $phone, password_hash($password, PASSWORD_BCRYPT), 'admin'];
        $stmt->execute($data);
        header( 'location:../admin/index.php');
    }
    }
