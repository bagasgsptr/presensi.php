<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "sistem_absensi";

// Buat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SESSION['role'] !== 'user') {
    header("Location: dashboard.php");
    exit;
}

$username = $_SESSION['username'];

$message = ''; // Menambahkan variabel untuk pesan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $nim = $_POST['nim'] ?? '';
    $keterangan = $_POST['keterangan'] ?? 'Hadir';

    // Validasi input
    if (empty($nama) || empty($nim)) {
        $message = "Nama dan NIM harus diisi!";
    } else {
        // Simpan data ke database
        $tanggal = date('Y-m-d');
        $query = "INSERT INTO absen (username, nama, nim, tanggal, keterangan) 
                  VALUES ('$username', '$nama', '$nim', '$tanggal', '$keterangan')";
        if (mysqli_query($conn, $query)) {
            $message = "Absensi berhasil dicatat!";
        } else {
            $message = "Gagal mencatat absensi: " . mysqli_error($conn);
        }
    }
}


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absen</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .wrapper {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
            color: #444;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-size: 16px;
            font-weight: 700;
            color: #444;
            margin-bottom: 5px;
            display: block;
            text-align: left;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        button, .back-button {
            display: block;
            width: 100%;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            margin-bottom: 10px;
        }
        button {
            background: #4CAF50;
            color: #fff;
            border: none;
        }
        button:hover {
            background: #45a049;
        }
        .message {
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 20px;
    border-radius: 5px;
    color: #fff;
    font-weight: bold;
    opacity: 0; /* Mulai dengan opacity 0 (tidak terlihat) */
    visibility: hidden; /* Menyembunyikan elemen pada awalnya */
    transition: opacity 1s ease-out, visibility 0s 1s; /* Efek transisi untuk opacity dan visibility */
}

.success {
    background: #4CAF50;
}

.error {
    background: #f44336;
}


    </style>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>Absen Dulu Gaesss</h1>
        </header>

        <form method="POST">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" placeholder="Masukkan nama" required>

            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim" placeholder="Masukkan NIM" required>

            <label for="keterangan">Keterangan:</label>
            <select name="keterangan" id="keterangan">
                <option value="Hadir">Hadir</option>
                <option value="Sakit">Sakit</option>
                <option value="Izin">Izin</option>
            </select>
            <button type="submit">Simpan</button>
        </form>


        <?php if ($message): ?>
            <div class="message <?php echo $message === 'Absensi berhasil dicatat!' ? 'success' : 'error'; ?>" id="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <script>
        // Menghapus pesan setelah 3 detik
        <?php if ($message): ?>
    // Menampilkan pesan dengan efek fade-in
    document.getElementById('message').style.visibility = 'visible';
    document.getElementById('message').style.opacity = '1';

    // Menghilangkan pesan setelah 3 detik dengan efek fade-out
    setTimeout(function() {
        var messageElement = document.getElementById('message');
        messageElement.style.opacity = '0'; // Mengubah opacity menjadi 0 (transparan)
        messageElement.style.visibility = 'hidden'; // Menyembunyikan elemen setelah transisi
    }, 3000); // Pesan akan hilang setelah 3 detik
<?php endif; ?>

    </script>

        <a href="dashboard.php" >Kembali ke Dashboard</a>
    </div>

    </script>
</body>
</html>
