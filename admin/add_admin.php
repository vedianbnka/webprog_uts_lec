    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
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
      }Z
    }
  };
  xhr.send();
}

setInterval(checkSession, 1);
    </script>
    </head>
    <body>
        <form action="add_admin_proses.php" method="POST">
        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <div class="alert alert-danger" role="alert">
                    Password dan confirm password yang anda input tidak sama
                </div>
            <?php endif; ?>
            <label for="nama">Nama Lengkap</label><br>
            <input type="text" name="nama" id="nama"><br>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email"><br>
            <label for="phone">Phone</label><br>
            <input type="text" name="phone" id="phone"><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password"><br>
            <label for="confirm_password">Confirm Password</label><br>
            <input type="password" name="confirm_password" id="confirm_password"><br>
            <input type="submit" value="Sign Up">
            </form>
    </body>
    </html>