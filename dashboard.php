<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : ''; // Ambil role pengguna
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style-dashboard.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Menu</h2>
            <nav>
        <ul>
            <li><a href="dashboard.php" id="dashboardBtn">Dashboard</a></li>
            <?php if ($role !== 'user') { ?>
                <li><a href="profil.php" id="profilBtn">Profil</a></li>
                <li><a href="form_input_data.php" id="inputDataBtn">Input Data</a></li>
                <li><a href="datamahasiswa.php" id="dataMahasiswaBtn">Data Mahasiswa</a></li>
                <li><a href="absen_hari_ini.php" id="absenHariIniBtn">Absen Hari Ini</a></li>
                <li><a href="logout.php" id="absenHariIniBtn">Logout</a></li>
            <?php } else { ?>
                <li><a href="absen.php" id="absenBtn">Absen</a></li>
                <li><a href="logout.php" id="absenHariIniBtn">Logout</a></li>
            <?php } ?>
            
        </ul>

            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Selamat datang, <?= htmlspecialchars($username) ?>!</h1>
            </header>

            <div class="welcome-message">
                <p>Ini adalah dashboard Anda.</p>
            </div>
            
            <footer>
                <p>&copy; 2024 Dashboard Sistem</p>
            </footer>
        </div>
    </div>
</body>
</html>
