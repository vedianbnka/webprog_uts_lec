<?php
    session_start();

    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        header('Location: ../admin/index.php');
        exit();
    }else{
        header('Location: dashboard/index.php');
        exit();
    }
