<?php
session_start();
require '../db.php';

// // Check if user is logged in
// if (!isset($_SESSION['id'])) {
//     header('Location: index.php'); // Redirect to login if not logged in
//     exit;
// }

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
    <title>My Profile</title>
    <link rel="icon" href="../brand/icon.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-lg mx-auto mt-10 p-5 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-5">Edit Profile</h2>

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
            <div class="mb-4">
                <label class="block text-gray-700">Name:</label>
                <input type="text" name="nama" class="w-full px-3 py-2 border rounded" value="<?= htmlspecialchars($user['nama']); ?>" autocomplete="off" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email:</label>
                <input type="email" name="email" class="w-full px-3 py-2 border rounded" value="<?= htmlspecialchars($user['email']); ?>" autocomplete="off" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Phone:</label>
                <input type="text" name="phone" class="w-full px-3 py-2 border rounded" value="<?= htmlspecialchars($user['phone']); ?>" autocomplete="off" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">New Password:</label>
                <div class="relative">
                    <input type="password" name="new_password" id="new_password" class="w-full px-3 py-2 border rounded">
                    <button type="button" class="absolute right-2 top-2" onclick="togglePassword('new_password')">👁️</button>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Confirm by Old Password:</label>
                <div class="relative">
                    <input type="password" name="old_password" id="old_password" class="w-full px-3 py-2 border rounded" required>
                    <button type="button" class="absolute right-2 top-2" onclick="togglePassword('old_password')">👁️</button>
                </div>
            </div>
            <div class="text-right flex justify-end gap-2">
                <a href="index.php" class="bg-gray-300 text-black px-4 py-2 rounded">Back</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
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
