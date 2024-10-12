<?php 
    session_start();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Password yang anda masukkan tidak cocok";
        header ('Location: ../Log_in_page/forgot_password.php');
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $dsn = 'mysql:host=localhost;dbname=web_konser';
    $kunci = new PDO($dsn, 'root', '');

    $sql = "SELECT * FROM user WHERE email = ? ";
    $stmt = $kunci->prepare($sql);
    $data = [$email];
    $stmt->execute($data);
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   var_dump($row);
    if (!$row) {
        $_SESSION['error'] = "Account anda belum terdaftar";
        header ('Location: forgot_password.php');
        exit;
    }

    $sql = "UPDATE user SET password = ? WHERE email = ? ";
    $stmt = $kunci->prepare($sql);
    $data = [$hashed_password, $email];
    $stmt->execute($data);
    $_SESSION['success'] = "Password anda berhasil diubah";
    header ('Location: ../login/index.php');