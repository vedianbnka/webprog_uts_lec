<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Event-mu</title>
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

setInterval(checkSession, 1);
    </script>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
        }
        img {
            width: 20%;
        }
    </style>

</head>
<body>
    <a href="../user/regis.php" class="btn btn-primary">Register Event</a>
    <a href="../logout.php" class="btn btn-danger">Log Out</a>

    <div class="table-responsive">
        <table id="tabell" class="display w-100">
            <thead>
                <tr>
                    <th>Nama Event</th>
                    <th>FOTO</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "../db.php";
                $sql = "SELECT * FROM event_konser";
                $hasil = $db->query($sql);

                while ($row = $hasil->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama_event']) ?></td>
                        <td><img class="img-fluid" src="../upload/<?= htmlspecialchars($row['banner_event']) ?>" alt=""></td>
                        <td>
                            <a href="regis_proses.php?id_event=<?= htmlspecialchars($row['id_event']) ?>">Register</a>
                            <a href="detail_event.php?id_event=<?= htmlspecialchars($row['id_event']) ?>">Detail</a>
                            <a href="delete_event.php?id_event=<?= htmlspecialchars($row['id_event']) ?>">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tabell').DataTable();
        });
    </script>
</body>
</html>
