<?php
    require '../db.php';
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password != $confirm_password) {
        header ("location:index.php?error=1");
        exit;
    }

    $hashPw = password_hash($password, PASSWORD_BCRYPT);
    
    $sql = "INSERT INTO user(nama,email,phone,password,role) VALUES (?,?,?,?,?)";

    $stmt = $db->prepare($sql);
    $data = [$nama, $email, $phone, $hashPw, 'user'];
    var_dump($data);
    $stmt->execute($data);

    header("location:../login/index.php");

