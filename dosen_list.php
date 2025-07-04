<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dosen</title>
    <link rel="stylesheet" href="cssstyle.css">
</head>
<body>
    <header>
        <h1>Daftar Dosen</h1>
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
        <form actDaftar Dosenion="tambah_matakuliah.php" method="post">
            <h2>Daftar Dosen</h2>
            
        <?php
        // Query untuk mengambil data dosen. Contoh menggunakan UPPER().
        $sql = "SELECT kd_ds, UPPER(nama) AS nama_dosen_kapital FROM Dosen";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><th>Kode Dosen</th><th>Nama Dosen (Kapital)</th></tr></thead>"; // Sesuaikan header tabel
            echo "<tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["kd_ds"]. "</td>";
                echo "<td>" . $row["nama_dosen_kapital"]. "</td>"; // Sesuaikan nama kolom yang ditampilkan
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Tidak ada data dosen.</p>";
        }
        $conn->close();
        ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistem Informasi Akademik</p>
    </footer>
</body>
</html>