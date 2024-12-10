<?php
session_start();

// Contoh autentikasi pengguna
$username = $_POST['username'];
$password = $_POST['password'];

// Misalnya data login disimpan dalam array (contoh sederhana)
$users = [
    'admin' => ['password' => '123', 'role' => 'admin'],
    'user' => ['password' => '123', 'role' => 'user']
];

// Cek jika username dan password sesuai
if (isset($users[$username]) && $users[$username]['password'] === $password) {
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $users[$username]['role'];  // Menyimpan role pengguna
    header("Location: dashboard.php");
    exit;
} else {
    echo "Username atau password salah!";
}
?>
