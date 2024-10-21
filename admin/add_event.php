<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Admin Dashboard - Konserhub</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" href="icon.png" type="image/x-icon"/>
        <link
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
            rel="stylesheet"/>
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

            function toggleFields(ticketType) {
                const fields = document.getElementById(ticketType + "-fields");
                if (document.getElementById(ticketType).checked) {
                    fields
                        .classList
                        .remove("d-none");
                } else {
                    fields
                        .classList
                        .add("d-none");
                }
            }
        </script>
    </head>
    <body class="bg-gray-100">
        <div class="flex">
            <aside class="w-64 bg-[#7B61FF] h-screen p-4">
                <h2 class="text-2xl font-bold text-white mb-6">Konserhub Admin</h2>
                <nav>
                    <ul class="space-y-4">
                        <li>
                            <a
                                href="index.php"
                                class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Dashboard</a >
                        </li>
                        <li>
                            <a
                                href="add_event.php"
                                class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Events</a >
                        </li>
                        <li>
                            <a
                                href="index.php"
                                class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Participants</a >
                        </li>
                        <li>
                            <a
                                href="view_user.php"
                                class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">User Management</a >
                        </li>
                        <li>
                            <a
                                href="../admin/add_admin.php"
                                class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Add Admin</a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Settings</a >
                        </li>
                        <li>
                            <a href="#" class="block text-white py-2 px-4 rounded hover:bg-[#6A52E0]">Logout</a >
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex-1">
                <!-- Header -->
                <header class="bg-white shadow p-4 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-black">Add Event</h2>
                    <div class="text-gray-700">Welcome, Admin</div>
                </header>

                <!-- Add Event Form -->
                <form
                    action="add_event_proses.php"
                    method="POST"
                    class="p-5 border rounded bg-white shadow animasi"
                    enctype="multipart/form-data">
                    <h1 class="text-center">Add Event</h1>
                    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                    <div class="alert alert-danger" role="alert">
                        File type not supported
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="nama_event">Nama Event</label>
                        <input
                            type="text"
                            id="nama_event"
                            name="nama_event"
                            class="form-control"
                            required="required"
                            autocomplete="off"/>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input
                            type="date"
                            id="tanggal"
                            name="tanggal"
                            class="form-control"
                            required="required"
                            autocomplete="off"/>
                    </div>

                    <div class="form-group">
                        <label for="waktu">Waktu</label>
                        <input
                            type="time"
                            id="waktu"
                            name="waktu"
                            class="form-control"
                            required="required"
                            autocomplete="off"/>
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input
                            type="text"
                            id="lokasi"
                            name="lokasi"
                            class="form-control"
                            required="required"
                            autocomplete="off"/>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input
                            type="text"
                            id="deskripsi"
                            name="deskripsi"
                            class="form-control"
                            required="required"
                            autocomplete="off"/>
                    </div>

                    <div class="form-group">
                        <label for="tipe_tiket">Tipe Tiket</label>

                        <!-- VVIP -->
                        <div class="form-check">
                            <input
                                type="checkbox"
                                id="vvip"
                                name="tipe_tiket[]"
                                value="vvip"
                                class="form-check-input"
                                onchange="toggleFields('vvip')"/>
                            <label for="vvip" class="form-check-label">VVIP</label>
                        </div>
                        <div id="vvip-fields" class="d-none">
                            <div class="form-group">
                                <label for="vvip-harga">Harga VVIP</label>
                                <input type="text" id="vvip-harga" name="vvip_harga" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="vvip-kuota">Kuota Tiket VVIP</label>
                                <input type="number" id="vvip-kuota" name="vvip_kuota" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="vvip-benefit">Benefit VVIP</label>
                                <input type="text" id="vvip-benefit" name="vvip_benefit" class="form-control"/>
                            </div>
                        </div>

                        <!-- VIP -->
                        <div class="form-check">
                            <input
                                type="checkbox"
                                id="vip"
                                name="tipe_tiket[]"
                                value="vip"
                                class="form-check-input"
                                onchange="toggleFields('vip')"/>
                            <label for="vip" class="form-check-label">VIP</label>
                        </div>
                        <div id="vip-fields" class="d-none">
                            <div class="form-group">
                                <label for="vip-harga">Harga VIP</label>
                                <input type="text" id="vip-harga" name="vip_harga" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="vip-kuota">Kuota Tiket VIP</label>
                                <input type="number" id="vip-kuota" name="vip_kuota" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="vip-benefit">Benefit VIP</label>
                                <input type="text" id="vip-benefit" name="vip_benefit" class="form-control"/>
                            </div>
                        </div>

                        <!-- CAT 1 -->
                        <div class="form-check">
                            <input
                                type="checkbox"
                                id="cat1"
                                name="tipe_tiket[]"
                                value="cat1"
                                class="form-check-input"
                                onchange="toggleFields('cat1')"/>
                            <label for="cat1" class="form-check-label">CAT 1</label>
                        </div>
                        <div id="cat1-fields" class="d-none">
                            <div class="form-group">
                                <label for="cat1-harga">Harga CAT 1</label>
                                <input type="text" id="cat1-harga" name="cat1_harga" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="cat1-kuota">Kuota Tiket CAT 1</label>
                                <input type="number" id="cat1-kuota" name="cat1_kuota" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="cat1-benefit">Benefit CAT 1</label>
                                <input type="text" id="cat1-benefit" name="cat1_benefit" class="form-control"/>
                            </div>
                        </div>

                        <!-- CAT 2 -->
                        <div class="form-check">
                            <input
                                type="checkbox"
                                id="cat2"
                                name="tipe_tiket[]"
                                value="cat2"
                                class="form-check-input"
                                onchange="toggleFields('cat2')"/>
                            <label for="cat2" class="form-check-label">CAT 2</label>
                        </div>
                        <div id="cat2-fields" class="d-none">
                            <div class="form-group">
                                <label for="cat2-harga">Harga CAT 2</label>
                                <input type="text" id="cat2-harga" name="cat2_harga" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="cat2-kuota">Kuota Tiket CAT 2</label>
                                <input type="number" id="cat2-kuota" name="cat2_kuota" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="cat2-benefit">Benefit CAT 2</label>
                                <input type="text" id="cat2-benefit" name="cat2_benefit" class="form-control"/>
                            </div>
                        </div>

                        <!-- CAT 3 -->
                        <div class="form-check">
                            <input
                                type="checkbox"
                                id="cat3"
                                name="tipe_tiket[]"
                                value="cat3"
                                class="form-check-input"
                                onchange="toggleFields('cat3')"/>
                            <label for="cat3" class="form-check-label">CAT 3</label>
                        </div>
                        <div id="cat3-fields" class="d-none">
                            <div class="form-group">
                                <label for="cat3-harga">Harga CAT 3</label>
                                <input type="text" id="cat3-harga" name="cat3_harga" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="cat3-kuota">Kuota Tiket CAT 3</label>
                                <input type="number" id="cat3-kuota" name="cat3_kuota" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="cat3-benefit">Benefit CAT 3</label>
                                <input type="text" id="cat3-benefit" name="cat3_benefit" class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="banner_event">Banner Event</label>
                        <input
                            type="file"
                            id="banner_event"
                            name="banner_event"
                            class="form-control"
                            required="required"/>
                    </div>

                    <button type="submit" name="add_event" class="bg-purple-500 text-white font-bold py-2 px-4 rounded">
                        Add Event
                    </button>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>