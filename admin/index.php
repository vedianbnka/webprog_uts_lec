<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <script>
        function checkSession() {
  // Kirim permintaan AJAX ke check_session.php
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "../check_session.php", true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      if (response.status === "inactive") {
        // Jika sesi tidak aktif, redirect ke halaman login
        window.location.href = "../login/index.php";
      }
    }
  };
  xhr.send();
}

setInterval(checkSession, 1000);
    </script>
</head>
<body>
    <a href="../admin/add_event.php">Add Event</a>
    <a href="../admin/add_admin.php">Tambah Admin Baru</a>
    <a href="../logout.php">Log Out</a>

    <?php
        require_once "../db.php";
    ?>
</body>
</html>