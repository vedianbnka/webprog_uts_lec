<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        <form action="proses.php" method="POST" class="p-5 border rounded bg-white shadow animasi">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    Email atau password salah!
                </div>
            <?php endif; ?>
            <h2 class="text-center">Login</h2>
            <div class="form-group">
                <label for="username">Email:</label>
                <input type="email" id="username" name="email" class="form-control" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="password">Password:</label><br>  
                <div class="input-group">
                <input type="password" id="password" name="password" class="form-control" required>
                <div class="input-group-append">
                            <span class="input-group-text" onclick="togglePassword('password')">👁️</span>
                        </div>
                        </div>
            </div>
            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
            <br>
            <a href="../signup/index.php">
            <button type="button" name="signup" class="btn btn-primary btn-block">Sign Up</button>
            </a>
            <div class="text-center mt-3">
                <a href="forgot_password.php">Forgot Password?</a>
            </div>
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
