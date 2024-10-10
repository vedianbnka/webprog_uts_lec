<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <form action="proses.php" method="POST" class="p-10 bg-white border rounded-lg shadow-lg animasi">
        <?php if (isset($_GET['error'])): ?>
            <div class="mb-4 text-red-600 bg-red-100 p-3 rounded">
                Email atau password salah!
            </div>
        <?php endif; ?>
        <h2 class="text-2xl font-bold text-center mb-4">Login</h2>
        <div class="mb-4">
            <label for="username" class="block mb-1 text-gray-700">Email:</label>
            <input type="email" id="username" name="email" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required autocomplete="off">
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-1 text-gray-700">Password:</label>
            <div class="relative">
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePassword('password')">👁️</span>
            </div>
        </div>
        <button type="submit" name="login" class="w-full px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Login</button>
        <br>
        <a href="../signup/index.php">
            <button type="button" name="signup" class="w-full mt-3 px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600 focus:outline-none focus:bg-green-600">Sign Up</button>
        </a>
        <div class="mt-3 text-center">
            <a href="forgot_password.php" class="text-blue-500 hover:underline">Forgot Password?</a>
        </div>
    </form>

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
