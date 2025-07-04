<?php
include 'koneksi.php'; // Pastikan file koneksi database Anda sudah benar

// Query untuk mengambil data dari tabel KRSMahasiswa saja
$sql = "SELECT nim, kd_mk, kd_ds, semester, nilai FROM KRSMahasiswa";
            
$result = $conn->query($sql);

$conn->close(); // Tutup koneksi setelah selesai mengambil data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Mengajar</title>
    <link rel="stylesheet" href="cssstyle.css">
</head>
<body>
    <header>
        <h1>Jadwal Mengajar</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="mahasiswa_list.php">Daftar Mahasiswa</a></li>
                <li><a href="dosen_list.php">Daftar Dosen</a></li>
                <li><a href="matakuliah_list.php">Daftar Matakuliah</a></li>
                <li><a href="jadwalmengajar_list.php">Jadwal Mengajar</a></li>
                <li><a href="krs_sederhana.php">Daftar KRS Mahasiswa (Sederhana)</a></li>
                <li><a href="krsmhs_list.php">Laporan KRS Mahasiswa (Lengkap)</a></li> 
                <li><a href="tambah_mahasiswa.php">Tambah Mahasiswa</a></li>
                <li><a href="tambah_dosen.php">Tambah Dosen</a></li>
                <li><a href="tambah_matakuliah.php">Tambah Matakuliah</a></li>
                <li><a href="tambah_jadwalmengajar.php">Tambah Jadwal Mengajar</a></li>
                <li><a href="tambah_krsmhs.php">Tambah KRS</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form action="tambah_matakuliah.php" method="post">
            <h2>Jadwal Mengajar</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table class='krsmhs-table'>";
            echo "<thead>";
            echo "<tr>
                    <th>NIM</th>
                    <th>Kode Mata Kuliah</th>
                    <th>Kode Dosen</th>
                    <th>Semester</th>
                    <th>Nilai</th>
                  </tr>";
            echo "</thead>";
            echo "<tbody>";
            // Output data setiap baris
            while($row = $result->fetch_assoc()) {
                // Nilai (Jika Kosong)
                $nilai_display = empty($row["nilai"]) ? "Belum Dinilai" : $row["nilai"];

                echo "<tr>";
                echo "<td>" . $row["nim"] . "</td>";
                echo "<td>" . $row["kd_mk"] . "</td>";
                echo "<td>" . $row["kd_ds"] . "</td>";
                echo "<td>" . $row["semester"] . "</td>";
                echo "<td>" . $nilai_display . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Tidak ada data KRS mahasiswa.</p>";
        }
        ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistem Akademik. All rights reserved.</p>
    </footer>
</body>
</html>