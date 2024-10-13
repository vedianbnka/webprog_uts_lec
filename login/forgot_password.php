<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes slideSide {
            0% {
            transform: translateX(-100px);
            opacity: 0;
            }

            100% {
            transform: translateX(0px);
            opacity: 1;
            }
        }

        .animasi {
            animation: slideSide 1s;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <?php session_start(); ?>
        <form action="proses_reset_pw.php" method="POST" class="p-5 border rounded bg-white shadow animasi">
            <h2 class="text-3xl font-bold text-center mb-4">Reset Password</h2>
            <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-4 text-green-600 bg-green-100 p-3 rounded">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-4 text-red-600 bg-red-100 p-3 rounded">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
            <div class="form-group">
                <label for="username">Email:</label>
                <input type="text" id="username" name="email" class="form-control" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password">Masukkan Password Baru:</label>
                <div class="input-group">
                <input type="password" id="password" name="password" class="form-control" required>
                <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePassword('password')">👁️</span>
                        </div>
                </div>

            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmation Password:</label>
                <div class="input-group">
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePassword('confirm_password')">👁️</span>
                        </div>
                        </div>
            </div>
            
            <button type="submit" name="login" class="btn btn-primary btn-block">Reset Password</button>
            <br>
            <a href="index.php">
            <button type="button" name="login" class="btn btn-primary btn-block">Back To Login</button>
            </a>
        </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function togglePassword(fieldID) {
        var field = document.getElementById(fieldID);
        if (field.type === "password") {
            field.type = "text";
        } else {
            field.type = "password";
        }
    }
</script>
</body>
</html>
