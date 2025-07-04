<?php
include 'koneksi.php'; // Pastikan Anda menyertakan file koneksi database

$nim_lama = '1823456'; // NIM mahasiswa yang SULIT DIUBAH
$nim_baru_yang_diinginkan = '1812345'; // <--- GANTI DENGAN NIM BARU YANG ANDA INGINKAN
$nama_baru = 'Ridho'; // Nama baru yang ingin Anda tetapkan

// Prepared statement untuk keamanan
$stmt = $conn->prepare("UPDATE Mahasiswa SET nim = ?, nama = ? WHERE nim = ?");
$stmt->bind_param("sss", $nim_baru_yang_diinginkan, $nama_baru, $nim_lama);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "Data mahasiswa dengan NIM lama " . $nim_lama . " berhasil diubah menjadi NIM " . $nim_baru_yang_diinginkan . " dan nama " . $nama_baru . ".";
    } else {
        echo "Tidak ada mahasiswa dengan NIM " . $nim_lama . " ditemukan, atau data sudah sama.";
    }
    echo "<br><a href='mahasiswa_list.php'>Kembali ke Daftar Mahasiswa</a>";
    echo "<br><a href='krsmhs_list.php'>Lihat Laporan KRS Mahasiswa</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>