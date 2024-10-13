<?php
session_start();
require '../db.php';

$id_user = $_SESSION['id_user'];

// Fetch user data
$sql = "SELECT nama, email, phone FROM user WHERE id_user = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$id_user]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konserhub | Profile</title>
    <link rel="icon" href="../brand/icon.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideIn {
            0% {
                transform: translateX(-100px);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animasi {
            animation: slideIn 1s;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-gradient-to-b from-[#7B61FF] to-[#6A52E0]">
    <div class="p-8 bg-white rounded-lg shadow-lg animasi max-w-lg w-full">
        <h2 class="text-3xl font-bold text-[#7B61FF] mb-6">Edit Profile</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="mb-4 text-red-600 bg-red-100 p-3 rounded">
                Password lama yang dimasukkan salah!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="mb-4 text-green-600 bg-green-100 p-3 rounded">
                Data berhasil diupdate!
            </div>
        <?php endif; ?>

        <form action="update_profile.php" method="POST">
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold">Name:</label>
                <input type="text" name="nama" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-[#7B61FF]" value="<?= htmlspecialchars($user['nama']); ?>" required>
            </div>
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold">Email:</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-[#7B61FF]" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold">Phone:</label>
                <input type="text" name="phone" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-[#7B61FF]" value="<?= htmlspecialchars($user['phone']); ?>" required>
            </div>
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold">New Password:</label>
                <div class="relative">
                    <input type="password" name="new_password" id="new_password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-[#7B61FF]">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePassword('new_password')">👁️</span>
                </div>
            </div>
            <div class="mb-5">
                <label class="block text-gray-700 font-semibold">Confirm by Old Password:</label>
                <div class="relative">
                    <input type="password" name="old_password" id="old_password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-[#7B61FF]" required>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer" onclick="togglePassword('old_password')">👁️</span>
                </div>
            </div>
            <div class="flex justify-between mt-5">
                <a href="index.php" class="bg-green-500 text-white px-5 py-2 rounded hover:bg-green-600">Back</a>
                <button type="submit" class="bg-[#7B61FF] text-white px-5 py-2 rounded hover:bg-[#6A52E0]">Update</button>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
