<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Mengecek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $jurusan = $_POST['jurusan'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];

    // Menyimpan data ke dalam session
    if (!isset($_SESSION['data_mahasiswa'])) {
        $_SESSION['data_mahasiswa'] = [];
    }

    // Menambahkan data mahasiswa ke dalam array sesi
    $_SESSION['data_mahasiswa'][] = [
        'nama' => $nama,
        'nim' => $nim,
        'jurusan' => $jurusan,
        'tgl_lahir' => $tgl_lahir,
        'alamat' => $alamat,
        'email' => $email,
        'telepon' => $telepon
    ];

    // Redirect ke halaman data mahasiswa setelah menyimpan data
    header("Location: datamahasiswa.php");
    exit;
}
?>
