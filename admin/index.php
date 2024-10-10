<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <a href="../admin/add_event.php">Add Event</a>
    <a href="../admin/add_admin.php">Tambah Admin Baru</a>
    <a href="../logout.php">Log Out</a>

    <div class="table-responsive">
         <table id="tabell" class="display w-100">
         <thead>
            <tr>
                <th>Nma Event</th>
                <th>FOTO</th>
                <th>ACTION</th>
            </tr>
            </thead><tbody>
    <?php
        require_once "../db.php";

        $sql = "SELECT * FROM event_konser";
        $hasil = $db->query($sql);

        while ($row= $hasil->fetch(PDO::FETCH_ASSOC)) {
        ?>
            
            <tr>
                <td><?= $row['nama_event'] ?></td>
                <td><img class="img-fluid" src="../upload/<?= $row['banner_event'] ?>" alt=""></td>
                <td>
                    <a href="edit_event.php?id_event=<?= $row['id_event'] ?>">Edit</a>
                    <a href="detail_event.php?id_event=<?= $row['id_event'] ?>">Detail</a>
                    <a href="delete_event.php?id_event=<?= $row['id_event'] ?>">Delete</a>
                </td>
            </tr>
        
        <?php
        }
    ?></tbody></table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.5/datatables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tabell').DataTable({
            });
        });
    </script>
</body>
</html>