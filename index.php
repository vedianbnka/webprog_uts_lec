<?php
    if (!isset($_SESSION["id"])) {
        header('Location: login/index.php');
    }