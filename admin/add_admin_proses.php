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
        $_SESSION["success"]="Password Tidak Match";
        header ("location: add_admin.php");
        exit;
    }else {
        $sql = "INSERT INTO admin(nama,email,phone,password,role) VALUES (?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $data = [$nama, $email, $phone, password_hash($password, PASSWORD_BCRYPT), 'admin'];
        $stmt->execute($data);
        header( 'location:../admin/index.php');
    }
    }
