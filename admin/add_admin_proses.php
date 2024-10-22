<?php
    session_start();

    if (!isset($_SESSION["role"]) && $_SESSION["role"] != "admin") {
        header('Location: ../dashboard/index.php');
        exit();
    }

    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        require_once '../db.php';

        $nama = $_POST['nama'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    $sql = "SELECT * FROM admin WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $_SESSION["error"]="Email yang anda input sudah terdaftar";
        header ("location: add_admin.php");
        exit;
    }

    if ($password != $confirm_password) {
        $_SESSION["error"]="Password dan confirm password yang anda input tidak sama";
        header ("location: add_admin.php");
        exit;
    }else {
        $sql = "INSERT INTO admin(nama,email,phone,password,role) VALUES (?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $data = [$nama, $email, $phone, password_hash($password, PASSWORD_BCRYPT), 'admin'];
        $stmt->execute($data);
        $_SESSION["success"]="Admin baru telah ditambahkan";
        header( 'location: list_admin.php');
    }
    }
