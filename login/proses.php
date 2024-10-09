<?php
    session_start();
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $dsn = 'mysql:host=localhost;dbname=web_konser';
    $kunci = new PDO($dsn, 'root', '');

    $sql = "SELECT * FROM user WHERE email = ? ";
    $stmt = $kunci->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $dsnn = 'mysql:host=localhost;dbname=web_konser';
    $kuncii = new PDO($dsn, 'root', '');

    $sqll = "SELECT * FROM admin WHERE email = ? ";
    $stmtt = $kuncii->prepare($sqll);
    $stmtt->execute([$email]);
    $roww = $stmtt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($pass, $row['password'])) {
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id_user'];
        $_SESSION['role'] = $row['role'];
        header ('Location: ../dashboard/index.php');
        exit;
    } else if($roww && password_verify($pass, $roww['password'])) {
        $_SESSION['nama'] = $roww['nama'];
        $_SESSION['email'] = $roww['email'];
        $_SESSION['id'] = $roww['id_user'];
        $_SESSION['role'] = $roww['role'];
        header ('Location: ../admin/index.php');
        exit;
    }else {
        header ('Location: index.php?error=1');
        exit;
    }

