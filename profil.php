<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Cek apakah pengguna adalah admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php"); // Redirect jika bukan admin
    exit;
}

$username = $_SESSION['username'];

// Mengatur nama menjadi "Bagas"
$nama = "Bagas Gusti Saputro"; // Nama hardcoded menjadi Bagas untuk profil admin

// Foto profil
$foto_profil = isset($_SESSION['user_data']['foto_profil']) ? $_SESSION['user_data']['foto_profil'] : 'img/1.jpeg'; // Default foto jika tidak ada
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin</title>
    <link rel="stylesheet" href="style-dashboard.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .wrapper {
            display: flex;
            width: 100%;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #2d3e50;
            color: #fff;
            padding: 20px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar nav ul {
            list-style: none;
            padding: 0;
        }

        .sidebar nav ul li {
            margin: 10px 0;
        }

        .sidebar nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            display: block;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .sidebar nav ul li a:hover {
            background-color: #495f73;
            transform: translateX(5px); /* Efek lembut geser kanan */
        }

        /* Main content */
        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px; /* Ganti posisi konten utama agar tidak tertutup sidebar */
            margin-left: -20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            margin-right: -180px;
        }

        .profile-container {
            text-align: center;
            max-width: 500px;
            margin: 0 auto;
            margin-left: ; /* Geser sedikit ke kiri */
        }

                    .profile-container img {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                object-fit: cover;
                margin-bottom: 20px;
                margin-right: -180px; /* Geser ke kiri */
            }


        .profile-container h3 {
            font-size: 24px;
            margin: 10px 0;
            margin-right: -180px; /* Geser nama ke kiri */
        }


        .profile-container p {
            font-size: 18px;
            color: #555;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #aaa;
            margin-right: -180px;
        }
    </style>
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
                <h1>Profil Admin</h1>
            </header>

            <section class="profile-container">
                <!-- Menampilkan Foto Profil -->
                <img src="<?= htmlspecialchars($foto_profil) ?>" alt="Foto Profil">

                <!-- Menampilkan Nama -->
                <h3><?= htmlspecialchars($nama) ?></h3>
            </section>

            <footer>
                <p>&copy; 2024 Dashboard Sistem</p>
            </footer>
        </div>
    </div>
</body>
</html>
