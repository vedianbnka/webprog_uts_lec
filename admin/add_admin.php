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
    </script>
  </head>
  <body class="bg-gray-100">
    <div class="flex">
      <aside class="w-64 bg-[#7B61FF] h-screen p-4">
      <img src="../brand/logo_white.png" alt="Website Logo" class="img-fluid">
        <nav>
          <ul class="space-y-4">
            <li>
              <a
                href="index.php"
                class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]"
                >Dashboard</a
              >
            </li>
            <li>
              <a
                href="add_event.html"
                class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]"
                >Add Events</a
              >
            </li>
            <li>
              <a
                href="view_user.php"
                class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]"
                >User Management</a
              >
            </li>
            <li><a href="add_admin.php" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Admin</a></li>
            <li>
              <a
                href="#"
                class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]"
                >Settings</a
              >
            </li>
            <li>
              <a
                href="../logout.php"
                class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]"
                >Logout</a
              >
            </li>
          </ul>
        </nav>
      </aside>

      <!-- Main Content -->
      <div class="flex-1">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
          <h2 class="text-2xl font-bold text-black">Add Admin</h2>
          </header>

        <!-- Content -->
        <main class="p-6 bg-gray-100">
          <!-- Add Admin Form -->
          <section class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h3 class="text-xl font-semibold text-black mb-4">Register New Admin</h3>

            <form action="add_admin_proses.php" method="POST" class="space-y-4">
              <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
              <div class="alert alert-danger text-red-500" role="alert">
                Password dan confirm password yang anda input tidak sama
              </div>
              <?php endif; ?>

              <div>
                <label for="nama" class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7B61FF]">
              </div>

              <div>
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7B61FF]">
              </div>

              <div>
                <label for="phone" class="block text-gray-700 font-bold mb-2">Phone</label>
                <input type="text" name="phone" id="phone" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7B61FF]">
              </div>

              <div>
                <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7B61FF]">
              </div>

              <div>
                <label for="confirm_password" class="block text-gray-700 font-bold mb-2">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#7B61FF]">
              </div>

              <div>
                <input type="submit" value="Sign Up" class="w-full bg-[#7B61FF] text-white font-bold py-2 px-4 rounded hover:bg-[#6A52E0]">
              </div>
            </form>
          </section>
        </main>

        <footer class="bg-black py-4 mt-8">
          <div class="text-center text-white">
            © 2024 Konserhub Admin. All rights reserved.
          </div>
        </footer>
      </div>
    </div>
  </body>
</html>
