<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
<body>
    <a href="../admin/add_event.php">Add Event</a>
    <a href="../admin/add_admin.php">Tambah Admin Baru</a>
    <a href="../admin/view_user.php">View User</a>
    <a href="../logout.php">Log Out</a>

    <div class="table-responsive">
        <table id="tabell" class="display w-100">
            <thead>
                <tr>
                    <th>Nama Event</th>
                    <th>FOTO</th>
                    <th>STATUS EVENT</th>
                    <th>PARTISIPAN</th>
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
                    <td><?= $row['nama_event'] ?></td>
                    <td><img class="img-fluid" src="../upload/<?= $row['banner_event'] ?>" alt=""></td>
                    <td>
                        <form method="post" action="update_status.php?id_event=<?= $row['id_event'] ?>">
                        <select class="status-dropdown" name="status" onchange="this.form.submit()"> 
                            <option value="open" <?= $row['status_event'] == 'open' ? 'selected' : '' ?>>Active</option>
                            <option value="closed" <?= $row['status_event'] == 'closed' ? 'selected' : '' ?>>Closed</option>
                            <option value="canceled" <?= $row['status_event'] == 'canceled' ? 'selected' : '' ?>>Canceled</option>
                        </select></form>
                    </td>
                    <td>
                        <?php
                        $sqll = "SELECT * FROM tiket WHERE id_event = $row[id_event]";
                        $result = $db->query($sqll);
                        $kuota = 0;
                        $jumlah_sold = 0;
                        while ($roww = $result->fetch(PDO::FETCH_ASSOC)) {
                            $jumlah_sold += $roww['jumlah_sold'];
                            $kuota += $roww['kuota'];
                        }

                        echo $jumlah_sold . " / " . $kuota;
                        ?>
                    </td>
                    <td>
                        <a href="edit_event.php?id_event=<?= $row['id_event'] ?>">Edit</a>
                        <a href="detail_event.php?id_event=<?= $row['id_event'] ?>">Detail Event</a>
                        <a href="delete_event.php?id_event=<?= $row['id_event'] ?>">Delete</a>
                        <a href="list_peserta.php?id_event=<?= $row['id_event'] ?>">List Peserta</a>
                    </td>
                </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabell').DataTable(); 
        });
    </script>
    
</body>
</html>