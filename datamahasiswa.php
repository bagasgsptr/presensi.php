<?php
session_start();
include('koneksi.php'); // Memasukkan file koneksi ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$message = ""; // Variabel untuk pesan notifikasi

// Fungsi untuk menyimpan data mahasiswa ke database
if (isset($_POST['simpan'])) {
    if (isset($_SESSION['data_mahasiswa']) && count($_SESSION['data_mahasiswa']) > 0) {
        foreach ($_SESSION['data_mahasiswa'] as $mahasiswa) {
            $nama = $conn->real_escape_string($mahasiswa['nama']); // Mencegah SQL injection
            $nim = $conn->real_escape_string($mahasiswa['nim']); // Mencegah SQL injection

            // Menyimpan data ke database
            $sql = "INSERT INTO mahasiswa (nama, nim) VALUES ('$nama', '$nim')";
            if ($conn->query($sql) === TRUE) {
                $message = "Data mahasiswa berhasil disimpan.";
            } else {
                $message = "Error: " . $conn->error;
            }
        }
        // Setelah data disimpan, data tetap di session dan tidak dihapus
    }
}

// Hapus data mahasiswa jika tombol hapus ditekan
if (isset($_GET['hapus'])) {
    $index = (int) $_GET['hapus']; // Ambil index yang akan dihapus
    if (isset($_SESSION['data_mahasiswa'][$index])) {
        unset($_SESSION['data_mahasiswa'][$index]); // Hapus data mahasiswa
        $_SESSION['data_mahasiswa'] = array_values($_SESSION['data_mahasiswa']); // Reindex array
    }
    header("Location: datamahasiswa.php"); // Redirect untuk mencegah reload form
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="style-dashboard.css">
    <link rel="stylesheet" href="style-datamahasiswa.css">
    <style>
        #simpanBtn {
            background-color: #4CAF50; /* Warna hijau */
            color: white; /* Warna teks putih */
            padding: 10px 20px; /* Padding atas-bawah dan kiri-kanan */
            cursor: pointer; /* Menambahkan kursor pointer saat hover */
            font-size: 16px; /* Ukuran font */
            transition: background-color 0.3s ease; /* Efek transisi */
        }

        #simpanBtn:active {
            background-color: #3e8e41; /* Warna hijau lebih gelap saat tombol ditekan */
        }

        #message {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin: 10px 0;
            display: none;
            border-radius: 5px;
        }
    </style>
    <script>
        function showMessage(message) {
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = message;
            messageDiv.style.display = 'block';

            // Hilangkan pesan setelah 3 detik
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 3000);
        }
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
            <section class="section">
                <h2>Daftar Mahasiswa</h2>

                <!-- Div untuk pesan -->
                <div id="message"></div>

                <?php if (isset($_SESSION['data_mahasiswa']) && count($_SESSION['data_mahasiswa']) > 0): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['data_mahasiswa'] as $index => $mahasiswa): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($mahasiswa['nama']) ?></td>
                                    <td><?= htmlspecialchars($mahasiswa['nim']) ?></td>
                                    <td>
                                        <a href="datamahasiswa.php?hapus=<?= $index ?>" class="btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <form method="POST">
                        <button id="simpanBtn" type="submit" name="simpan">Simpan</button>
                    </form>
                <?php else: ?>
                    <p>Tidak ada data mahasiswa yang tersedia.</p>
                <?php endif; ?>
            </section>
        </div>
    </div>
    <!-- JavaScript untuk menampilkan pesan -->
    <script>
        <?php if (!empty($message)): ?>
        showMessage("<?= htmlspecialchars($message) ?>");
        <?php endif; ?>
    </script>
</body>
</html>
