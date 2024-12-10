<?php
$servername = "localhost"; // Nama server MySQL
$username = "root"; // Nama pengguna MySQL
$password = ""; // Password MySQL (sesuaikan)
$dbname = "sistem_absensi"; // Nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
