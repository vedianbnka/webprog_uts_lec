<?php 
    session_start();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "TRUE";
        header ('Location: ../Log_in_page/forgot_password.php?error=1');
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $dsn = 'mysql:host=localhost;dbname=web_konser';
    $kunci = new PDO($dsn, 'root', '');

    $sql = "SELECT * FROM user WHERE email = ? ";
    $stmt = $kunci->prepare($sql);
    $data = [$email];
    $stmt->execute($data);
   
    if ($stmt->rowCount() == 0) {
        $_SESSION['error'] = "TRUE";
        header ('Location: forgot_password.php?error=2');
        exit;
    }

    $sql = "UPDATE user SET password = ? WHERE email = ? ";
    $stmt = $kunci->prepare($sql);
    $data = [$hashed_password, $email];
    $stmt->execute($data);
    header ('Location: ../Log_in_page/index.php');