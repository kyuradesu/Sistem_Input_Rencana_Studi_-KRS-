<?php
$host = 'localhost';  // ganti dengan host Anda
$username = 'root';   // ganti dengan username database Anda
$password = '';       // ganti dengan password database Anda
$dbname = 'bengkel_coding'; // nama database

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
