<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../brand/icon.png" type="image/x-icon">

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
<body class="relative min-h-screen bg-gray-900 flex items-center justify-center">
    <video
      autoplay
      loop
      muted
      class="absolute top-0 left-0 w-full h-full object-cover -z-10"
    >
      <source src="../login/videobg/sample2.mp4" type="video/mp4" />
      Your browser does not support the video tag.
    </video>

    <div class="absolute top-6 left-10">
        <img src="../brand/logo_white.png" alt="Website Logo" class="h-12 w-auto">
    </div>

    <form action="proses.php" method="POST" class="p-4 bg-opacity-80 border rounded-lg bg-white shadow-lg animasi max-w-sm w-full h-auto">
        <h2 class="text-2xl font-bold text-center mb-4 text-[#7B61FF]">Sign Up</h2>
        
        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
            <div class="mb-3 text-red-600 bg-red-100 p-2 rounded">
                Password dan konfirmasi password tidak sama.
            </div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] == 2): ?>
            <div class="mb-3 text-red-600 bg-red-100 p-2 rounded">
                Email sudah terdaftar, silakan login.
            </div>
        <?php endif; ?>
        
        <div class="mb-2">
            <label for="nama" class="block mb-1 text-gray-700 text-sm">Full Name:</label>
            <input type="text" name="nama" id="nama" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#7B61FF]" autocomplete="off" required>
        </div>
        <div class="mb-2">
            <label for="email" class="block mb-1 text-gray-700 text-sm">Email:</label>
            <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#7B61FF]" autocomplete="off" required>
        </div>
        <div class="mb-2">
            <label for="phone" class="block mb-1 text-gray-700 text-sm">Phone Number:</label>
            <input type="text" name="phone" id="phone" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#7B61FF]" autocomplete="off" required>
        </div>
        <div class="mb-2">
            <label for="password" class="block mb-1 text-gray-700 text-sm">Password:</label>
            <div class="relative">
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#7B61FF]" required>
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePassword('password')">👁️</span>
            </div>
        </div>
        <div class="mb-2">
            <label for="confirm_password" class="block mb-1 text-gray-700 text-sm">Confirmation Password:</label>
            <div class="relative">
                <input type="password" name="confirm_password" id="confirm_password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-[#7B61FF]" required>
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePassword('confirm_password')">👁️</span>
            </div>
        </div>
        
        <button type="submit" class="w-full px-3 py-2 text-white bg-[#7B61FF] rounded hover:bg-[#6A52E0] focus:outline-none focus:bg-[#6A52E0]">Sign Up</button>
        <br>
        <a href="../login/index.php">
            <button type="button" class="w-full mt-2 px-3 py-2 text-white bg-green-500 rounded hover:bg-green-600 focus:outline-none focus:bg-green-600">Back to Login</button>
        </a>
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
