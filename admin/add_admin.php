<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - Konserhub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="icon.png" type="image/x-icon">
    <script>
      function checkSession() {
        // Kirim permintaan AJAX ke check_session.php
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../check_session_admin.php", true);
        xhr.onload = function () {
          if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === "inactive") {
              window.location.href = "../login/index.php";
            }
          }
        };
        xhr.send();
      }

      setInterval(checkSession, 1);

      function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
  </head>
  <body class="bg-gray-100">
    <div>
        <header class="bg-[#7B61FF] text-white flex justify-between items-center p-4">
            <div class="flex items-center space-x-4">
                <img src="../brand/logo_white.png" alt="Website Logo" class="h-12 w-auto">
            </div>
            <button id="navigasi" class="bg-[#7B61FF] text-white p-2 rounded-md focus:outline-none lg:hidden" onclick="toggleMenu()">☰</button>
        </header>

        <nav class="bg-[#7B61FF] hidden lg:flex lg:flex-row items-center justify-center w-full py-4" id="mobile-menu">
            <ul class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-8">
                <li><a href="index.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Dashboard</a></li>
                <li><a href="add_event.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Events</a></li>
                <li><a href="view_user.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">User Management</a></li>
                <li><a href="list_admin.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">List Admin</a></li>
                <li><a href="../logout.php" class="text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Logout</a></li>
            </ul>
        </nav>

        <main class="flex-1 p-4">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-black">Add Admin</h2>
        </header>

        <!-- Content -->

        <form action="add_admin_proses.php" method="POST" class="space-y-3 bg-white p-4 rounded-lg shadow-md max-w-md mx-auto mt-7">
        <h3 class="text-xl font-semibold text-black mb-4">Register New Admin</h3>
        <?php session_start(); if (isset($_SESSION['success'])): ?>
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

        <div>
          <label for="nama" class="block text-gray-700 font-semibold mb-1">Nama Lengkap</label>
          <input type="text" name="nama" id="nama" autocomplete="off" class="w-full px-3 py-1.5 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#7B61FF] focus:border-transparent">
        </div>

        <div>
          <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
          <input type="email" name="email" id="email" autocomplete="off" class="w-full px-3 py-1.5 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#7B61FF] focus:border-transparent">
        </div>

        <div>
          <label for="phone" class="block text-gray-700 font-semibold mb-1">Phone</label>
          <input type="text" name="phone" id="phone" autocomplete="off" class="w-full px-3 py-1.5 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#7B61FF] focus:border-transparent">
        </div>

        <div>
          <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
          <input type="password" name="password" id="password" autocomplete="off" class="w-full px-3 py-1.5 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#7B61FF] focus:border-transparent">
        </div>

        <div>
          <label for="confirm_password" class="block text-gray-700 font-semibold mb-1">Confirm Password</label>
          <input type="password" name="confirm_password" id="confirm_password" autocomplete="off" class="w-full px-3 py-1.5 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#7B61FF] focus:border-transparent">
        </div>

        <div>
          <input type="submit" value="Sign Up" class="w-full bg-[#7B61FF] text-white font-semibold py-2 rounded hover:bg-[#6A52E0] focus:outline-none focus:ring-2 focus:ring-[#7B61FF] focus:ring-offset-2 cursor-pointer">
        </div>
      </form>

      </div>
    </div>

    <footer class="bg-gray-900 bg-opacity-80 text-white py-8">
    <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 px-4 md:px-8">
        <!-- About Company Section -->
        <div class="flex flex-col">
            <h4 class="font-semibold text-lg mb-4">About Company</h4>
            <p class="text-sm">2-c-20, Kansua, Kota Rajasthan-324004</p>
            <div class="flex space-x-4 mt-4">
                <!-- Social Media Icons -->
                <a href="#"><img src="../brand/ig2.png" alt="Instagram" class="w-6 h-6"></a>
                <a href="#"><img src="../brand/tiktokWhite.png" alt="TikTok" class="w-6 h-6"></a>
                <a href="#"><img src="../brand/x.png" alt="WhatsApp" class="w-6 h-6"></a>
            </div>
        </div>

        <!-- Service Section -->
        <div class="flex flex-col">
            <h4 class="font-semibold text-lg mb-4">Service</h4>
            <ul class="text-sm space-y-2">
                <li><a href="add_event.php" class="hover:text-blue-300">Add Event</a></li>
                <li><a href="list_peserta.php" class="hover:text-blue-300">User Management</a></li>
                <li><a href="add_admin.php" class="hover:text-blue-300">Add Admin</a></li>
            </ul>
        </div>

        <!-- Useful Links Section -->
        <div class="flex flex-col">
            <h4 class="font-semibold text-lg mb-4">Useful Links</h4>
            <ul class="text-sm space-y-2">
                <li><a href="#" class="hover:text-blue-300">About Us</a></li>
                <li><a href="#" class="hover:text-blue-300">Team</a></li>
                <li><a href="#" class="hover:text-blue-300">Portfolio</a></li>
                <li><a href="#" class="hover:text-blue-300">Services</a></li>
                <li><a href="#" class="hover:text-blue-300">Contact Us</a></li>
            </ul>
        </div>

        <!-- Contact Us Section -->
        <div class="flex flex-col">
            <h4 class="font-semibold text-lg mb-4">Contact Us</h4>
            <a class="hover:text-blue-300">+021-5993693  <br> +62-354168293</a>
        </div>
    </div>

    <div class="border-t border-gray-600 mt-8 pt-4 text-center">
        <p class="text-sm">&copy;2024 Konserhub. All rights reserved.</p>
    </div>
</footer>
  </body>
</html>
