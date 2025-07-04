<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa</title>
    <link rel="stylesheet" href="cssstyle.css">
</head>
<body>
    <header>
        <h1>Daftar Mahasiswa</h1>
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
            <h2>Daftar Mahasiswa</h2>
        <?php
        // Contoh penggunaan fungsi SQL bawaan: CONCAT dan IFNULL
        $sql = "SELECT nim, CONCAT(nama, ' (', IFNULL(kota, 'N/A'), ')') AS nama_kota, jk, tgl_lahir, kd_ds FROM Mahasiswa";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><th>NIM</th><th>Nama (Kota)</th><th>JK</th><th>Tgl Lahir</th><th>Kode Dosen </th></tr></thead>";
            echo "<tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nim"]. "</td>";
                echo "<td>" . $row["nama_kota"]. "</td>";
                echo "<td>" . $row["jk"]. "</td>";
                echo "<td>" . $row["tgl_lahir"]. "</td>";
                echo "<td>" . $row["kd_ds"]. "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Tidak ada data mahasiswa.</p>";
        }
        $conn->close();
        ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistem Informasi Akademik</p>
    </footer>
</body>
</html>