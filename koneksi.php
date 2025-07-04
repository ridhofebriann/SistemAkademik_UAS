<?php
$servername = "localhost"; // Ganti jika database Anda di server lain
$username = "root";      // Ganti dengan username database Anda
$password = "";          // Ganti dengan password database Anda (kosong jika tidak ada)
$dbname = "tugas_uas"; // Ganti dengan nama database yang Anda buat

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// echo "Koneksi berhasil!"; // Opsional: Hapus atau komen setelah testing
?>