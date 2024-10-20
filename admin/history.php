<?php
session_start();
?>
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
    <?php if (isset($_SESSION['success'])): ?>
        
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
    <?php
        require_once '../db.php';

        $id_user = $_GET['id_user'];
        $sql = "SELECT * FROM user WHERE id_user = ?";
        $statement = $db->prepare($sql);
        $statement->execute([$id_user]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
    ?>
    <h1>List History Partisipan <?php echo $user['nama']; ?></h1>
    <a href="excel_history.php?id_user=<?= $id_user ?>">Download Excel</a>
    <div class="table-responsive">
        <table id="tabell" class="display w-100">
            <thead>
                <tr>
                    <th>Nama Event</th>
                    <th>Tanggal Register</th>
                    <th>Tipe Tiket</th>
                    <th>Jumlah Pembelian Tiket</th>
                    <th>No. tiket</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM list_partisipan_event AS p JOIN event_konser AS e ON p.id_event = e.id_event WHERE p.id_user = ? AND p.status = 'approved'";
                    $statement = $db->prepare($sql);
                    $statement->execute([$id_user]);
                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?= $row['nama_event'] ?></td>
                    <td><?= $row['tanggal_register'] ?></td>
                    <td><?= $row['tipe_tiket'] ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td><?= $row['no_tiket'] ?></td>
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
