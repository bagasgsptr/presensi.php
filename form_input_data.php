<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Cek apakah pengguna memiliki hak akses admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php"); // Redirect ke dashboard jika bukan admin
    exit;
}

// Proses jika pengguna memiliki hak akses untuk input data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simpan data mahasiswa ke session atau database
    $mahasiswa = [
        'nama' => $_POST['nama'],
        'nim' => $_POST['nim']
    ];

    // Simpan data mahasiswa ke session
    $_SESSION['data_mahasiswa'][] = $mahasiswa;
    echo "Data berhasil disimpan!";
    exit; // Tidak perlu redirect
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Mahasiswa</title>
    <link rel="stylesheet" href="style-dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inputMahasiswaForm').submit(function(e) {
                e.preventDefault(); // Mencegah form untuk reload halaman
                var nama = $('#nama').val();
                var nim = $('#nim').val();

                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    type: 'POST',
                    url: 'form_input_data.php',
                    data: { nama: nama, nim: nim },
                    success: function(response) {
                        // Tampilkan pesan sukses dan reset form
                        alert('Data berhasil disimpan!');
                        $('#nama').val('');
                        $('#nim').val('');
                    },
                    error: function() {
                        alert('Gagal mengirim data.');
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Menu</h2>
            <nav>
                <ul>
                    <li><a href="dashboard.php" id="dashboardBtn">Dashboard</a></li>
                    <li><a href="profil.php" id="profilBtn">Profil</a></li>
                    <li><a href="form_input_data.php" id="inputMahasiswaBtn">Input Data</a></li>
                    <li><a href="datamahasiswa.php" id="dataMahasiswaBtn">Data Mahasiswa</a></li>
                    <li><a href="absen_hari_ini.php" id="absenHariIniBtn">Absen Hari Ini</a></li>
                    <li><a href="logout.php" id="absenHariIniBtn">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Form Input Data Mahasiswa</h1>
            </header>

            <section class="section">
                <form id="inputMahasiswaForm">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" required><br><br>

                    <label for="nim">NIM:</label>
                    <input type="text" id="nim" name="nim" required><br><br>

                    <button type="submit">Simpan</button>
                </form>
            </section>

            <footer>
                <p>&copy; 2024 Dashboard Sistem</p>
            </footer>
        </div>
    </div>
</body>
</html>
