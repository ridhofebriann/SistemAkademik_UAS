<?php
include 'koneksi.php'; // Pastikan file koneksi.php Anda sudah benar

// --- DEBUGGING: BARIS INI BISA DIHAPUS NANTI JIKA SUDAH BERHASIL ---
// echo "<pre>";
// echo $sql;
// echo "</pre>";
// die();
// --- AKHIR DEBUGGING ---

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan KRS Mahasiswa Lengkap</title>
    <link rel="stylesheet" href="cssstyle.css">
</head>
<body>
    <header>
        <h1>Laporan KRS Mahasiswa</h1>
    </header>
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
    </nav>

    <main>
        <h2>Laporan KRS Mahasiswa Lengkap</h2>
        <table class="krsmhs-table">
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Info Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Dosen Pengajar (Nama Asli)</th>
                    <th>Info Jadwal</th>
                    <th>Ruang</th>
                    <th>Semester</th>
                    <th>Nilai (Jika Kosong)</th>
                    <th>Umur Mahasiswa (Hari)</th>
                    <th>Total SKS Mhs</th>
                    <th>Dosen Pengajar (UDF)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mendapatkan data KRS lengkap menggunakan JOIN, fungsi bawaan SQL, dan UDF
                $sql = "SELECT
                            m.nim,
                            m.nama AS nama_mahasiswa,
                            CONCAT(UPPER(mk.nama), ' (', mk.sks, ' SKS)') AS info_mata_kuliah, /* CONCAT & UPPER */
                            mk.sks,
                            d.nama AS nama_dosen,
                            CONCAT(jm.hari, ', Pukul ', jm.jam) AS info_jadwal, /* CONCAT */
                            jm.ruang,
                            krs.semester,
                            IFNULL(krs.nilai, 'Belum Dinilai') AS nilai_ifnull, /* IFNULL */
                            DATEDIFF(NOW(), m.tgl_lahir) AS umur_hari, /* DATEDIFF & NOW */
                            HITUNG_SKS_TOTAL_MAHASISWA(m.nim) AS total_sks_mahasiswa, /* Panggilan UDF 1 */
                            FORMAT_NAMA_DOSEN(d.nama) AS dosen_dengan_gelar /* Panggilan UDF 2 */
                        FROM
                            KRSMahasiswa krs
                        JOIN
                            Mahasiswa m ON krs.nim = m.nim
                        JOIN
                            JadwalMengajar jm ON krs.kd_mk = jm.kd_mk AND krs.kd_ds = jm.kd_ds /* JOIN */
                        JOIN
                            MataKuliah mk ON jm.kd_mk = mk.kd_mk
                        JOIN
                            Dosen d ON jm.kd_ds = d.kd_ds
                        ORDER BY m.nim, krs.semester, jm.hari";

                $result = $conn->query($sql);

                if (!$result) {
                    echo "<tr><td colspan='12'>Error dalam query: " . $conn->error . "</td></tr>";
                } elseif ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["nim"] . "</td>";
                        echo "<td>" . $row["nama_mahasiswa"] . "</td>";
                        echo "<td>" . $row["info_mata_kuliah"] . "</td>";
                        echo "<td>" . $row["sks"] . "</td>";
                        echo "<td>" . $row["nama_dosen"] . "</td>";
                        echo "<td>" . $row["info_jadwal"] . "</td>";
                        echo "<td>" . $row["ruang"] . "</td>";
                        echo "<td>" . $row["semester"] . "</td>";
                        echo "<td>" . $row["nilai_ifnull"] . "</td>";
                        echo "<td>" . $row["umur_hari"] . " hari</td>";
                        echo "<td>" . $row["total_sks_mahasiswa"] . "</td>";
                        echo "<td>" . $row["dosen_dengan_gelar"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>Tidak ada data KRS ditemukan.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistem Akademik. All rights reserved.</p>
    </footer>
</body>
</html>