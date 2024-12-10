<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "sistem_absensi";

// Buat koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $database);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$message = "";

// Tangkap aksi hapus
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $delete_query = "DELETE FROM absen WHERE id = $id";
    if (mysqli_query($conn, $delete_query)) {
        $message = "Data berhasil dihapus!";
    } else {
        $message = "Gagal menghapus data: " . mysqli_error($conn);
    }
}

// Tangkap data dari form absen.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $nim = $_POST['nim'] ?? '';
    $keterangan = $_POST['keterangan'] ?? 'Hadir';

    // Validasi input
    if (!empty($nama) && !empty($nim)) {
        $tanggal = date('Y-m-d');

        // Simpan data ke tabel `absen`
        $query = "INSERT INTO absen (nama, nim, tanggal, keterangan) VALUES ('$nama', '$nim', '$tanggal', '$keterangan')";
        if (mysqli_query($conn, $query)) {
            $message = "Absensi berhasil disimpan!";
        } else {
            $message = "Gagal menyimpan absensi: " . mysqli_error($conn);
        }
    } else {
        $message = "Nama dan NIM wajib diisi!";
    }
}

// Ambil semua data absensi untuk ditampilkan
$result = mysqli_query($conn, "SELECT * FROM absen ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen Hari Ini</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Styles tetap sama */
        body { font-family: 'Roboto', sans-serif; margin: 0; padding: 0; background: #f4f4f9; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .wrapper { background: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 20px 30px; width: 100%; max-width: 600px; text-align: center; }
        header h1 { margin: 0; font-size: 24px; color: #444; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; }
        th { background: #f4f4f9; }
        .message { margin: 10px 0; padding: 10px; background: #e7f3e7; color: #3c763d; border: 1px solid #d6e9c6; border-radius: 5px; }
        a { text-decoration: none; color: #4CAF50; margin-top: 20px; display: inline-block; }
        .delete-btn { color: red; cursor: pointer; }
    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Data Absensi Hari Ini</h1>
        </header>
        <?php if (!empty($message)) : ?>
    <div class="message" id="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<script>
    <?php if (!empty($message)) : ?>
        // Menunggu 3 detik setelah elemen muncul
        setTimeout(function() {
            var messageElement = document.getElementById('message');
            messageElement.style.display = 'none';  // Menyembunyikan pesan setelah 3 detik
        }, 3000); // 3000ms = 3 detik
    <?php endif; ?>
</script>

<style>
    .message {
        display: block; /* Pastikan elemen muncul */
        transition: opacity 0.5s ease-out; /* Efek transisi */
    }
</style>

        
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['nim']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td><?= htmlspecialchars($row['keterangan']) ?></td>
                            <td>
                                <a href="?hapus=<?= htmlspecialchars($row['id']) ?>" class="delete-btn" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada data absensi.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="">Kembali ke Halaman Dashboard</a>
    </div>
</body>
</html>

<?php
// Tutup koneksi
mysqli_close($conn);
?>
