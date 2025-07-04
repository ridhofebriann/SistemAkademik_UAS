<?php
include 'koneksi.php';
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
        // Query untuk mengambil data jadwal mengajar dengan JOIN
        $sql = "
            SELECT
                jm.kd_mk,
                mk.nama AS nama_matakuliah,
                jm.kd_ds,
                d.nama AS nama_dosen,
                jm.hari,
                jm.jam,
                jm.ruang
            FROM
                JadwalMengajar jm
            JOIN
                MataKuliah mk ON jm.kd_mk = mk.kd_mk
            JOIN
                Dosen d ON jm.kd_ds = d.kd_ds
            ORDER BY jm.hari, jm.jam;
        ";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><th>Kode MK</th><th>Nama Mata Kuliah</th><th>Kode Dosen</th><th>Nama Dosen</th><th>Hari</th><th>Jam</th><th>Ruang</th></tr></thead>";
            echo "<tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["kd_mk"]. "</td>";
                echo "<td>" . $row["nama_matakuliah"]. "</td>";
                echo "<td>" . $row["kd_ds"]. "</td>";
                echo "<td>" . $row["nama_dosen"]. "</td>";
                echo "<td>" . $row["hari"]. "</td>";
                echo "<td>" . $row["jam"]. "</td>";
                echo "<td>" . $row["ruang"]. "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Tidak ada data jadwal mengajar.</p>";
        }
        $conn->close();
        ?>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistem Informasi Akademik</p>
    </footer>
</body>
</html>