<?php
    session_start();
    $email = $_POST['email'];
    $pass = $_POST['password'];

    require_once '../db.php';

    $sql = "SELECT * FROM user WHERE email = ? ";
    $stmt = $db->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $sqll = "SELECT * FROM admin WHERE email = ? ";
    $stmtt = $db->prepare($sqll);
    $stmtt->execute([$email]);
    $roww = $stmtt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($pass, $row['password'])) {
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['role'] = $row['role'];
        header ('Location: ../dashboard/index.php');
        exit;
    } else if($roww && password_verify($pass, $roww['password'])) {
        $_SESSION['nama'] = $roww['nama'];
        $_SESSION['email'] = $roww['email'];
        $_SESSION['id_user'] = $roww['id_user'];
        $_SESSION['role'] = $roww['role'];
        header ('Location: ../admin/index.php');
        exit;
    }else {
        $_SESSION['error'] = "Password atau email anda salah";
        header ('Location: index.php');
        exit;
    }
?>