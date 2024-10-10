<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
    <form action="proses.php" method="POST" class="p-6 bg-white border rounded-lg shadow-lg w-full max-w-sm animasi">
        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
            <div class="mb-4 text-red-600 bg-red-100 p-3 rounded">
                Password dan confirm password yang anda input tidak sama
            </div>
        <?php endif; ?>
        <h2 class="text-2xl font-bold text-center mb-4">Sign Up</h2>
        <div class="mb-4">
            <label for="nama" class="block text-gray-700">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" autocomplete="off" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" autocomplete="off" required>
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-gray-700">Phone</label>
            <input type="text" name="phone" id="phone" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" autocomplete="off" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>
        <div class="mb-4">
            <label for="confirm_password" class="block text-gray-700">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
        </div>
        <input type="submit" value="Sign Up" cursor="pointer" class="w-full px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
    </form>
</body>
</html>
