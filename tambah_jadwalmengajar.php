<?php
include 'koneksi.php'; // Pastikan file koneksi database Anda sudah benar

$message = ""; // Variabel untuk menyimpan pesan sukses/error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kd_mk = $_POST['kd_mk'];
    $kd_ds = $_POST['kd_ds'];
    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $ruang = $_POST['ruang'];

    // Cek apakah kombinasi Kode MK, Kode Dosen, Hari, dan Jam sudah ada (Primary Key gabungan)
    $check_sql = "SELECT COUNT(*) FROM JadwalMengajar WHERE kd_mk = ? AND kd_ds = ? AND hari = ? AND jam = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ssss", $kd_mk, $kd_ds, $hari, $jam);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        $message = "<script>alert('Error: Jadwal mengajar untuk mata kuliah ini dengan dosen yang sama pada hari dan jam tersebut sudah ada.');</script>";
    } else {
        $sql = "INSERT INTO JadwalMengajar (kd_mk, kd_ds, hari, jam, ruang) VALUES (?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $kd_mk, $kd_ds, $hari, $jam, $ruang); 

            if ($stmt->execute()) {
                $message = "<script>alert('Data jadwal mengajar berhasil ditambahkan.'); window.location.href='jadwalmengajar_list.php';</script>";
            } else {
                $message = "<script>alert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            $message = "<script>alert('Error menyiapkan statement: " . $conn->error . "');</script>";
        }
    }
    // Tutup koneksi setelah semua operasi database selesai untuk permintaan ini
    if (isset($conn) && $conn->ping()) {
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Mengajar</title>
    <link rel="stylesheet" href="cssstyle.css">
</head>
<body>
    <header>
        <h1>Tambah Jadwal Mengajar</h1>
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
        <form action="tambah_jadwalmengajar.php" method="post">
            <h2>Tambah Jadwal Mengajar Baru</h2>
            <div class="form-row">
                <div class="form-group">
                    <label for="kd_mk">Mata Kuliah (Kode MK - Nama MK)</label>
                    <select required id="kd_mk" name="kd_mk">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        <?php
                        // Ambil kembali koneksi jika sudah ditutup sebelumnya atau belum dibuat
                        if (!isset($conn) || !$conn->ping()) {
                            include 'koneksi.php';
                        }
                        // Query untuk mengisi dropdown Mata Kuliah
                        $sql_mk = "SELECT kd_mk, nama FROM MataKuliah ORDER BY nama";
                        $result_mk = $conn->query($sql_mk);

                        if ($result_mk && $result_mk->num_rows > 0) {
                            while($row_mk = $result_mk->fetch_assoc()) {
                                echo "<option value='" . $row_mk["kd_mk"] . "'>" . $row_mk["kd_mk"] . " - " . $row_mk["nama"] . "</option>";
                            }
                        } else if ($conn->error) {
                            echo "<option value=''>Error fetching Mata Kuliah: " . $conn->error . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kd_ds">Dosen Pengajar (Kode Dosen - Nama Dosen)</label>
                    <select required id="kd_ds" name="kd_ds">
                        <option value="">-- Pilih Dosen Pengajar --</option>
                        <?php
                        if (!isset($conn) || !$conn->ping()) {
                            include 'koneksi.php';
                        }
                        // Query untuk mengisi dropdown Dosen
                        $sql_ds = "SELECT kd_ds, nama FROM Dosen ORDER BY nama";
                        $result_ds = $conn->query($sql_ds);

                        if ($result_ds && $result_ds->num_rows > 0) {
                            while($row_ds = $result_ds->fetch_assoc()) {
                                echo "<option value='" . $row_ds["kd_ds"] . "'>" . $row_ds["kd_ds"] . " - " . $row_ds["nama"] . "</option>";
                            }
                        } else if ($conn->error) {
                            echo "<option value=''>Error fetching Dosen: " . $conn->error . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="hari">Hari</label>
                    <select id="hari" name="hari" required>
                        <option value="">-- Pilih Hari --</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jam">Jam</label>
                    <input type="time" id="jam" name="jam" required>
                </div>
            </div>

            <div class="form-group">
                <label for="ruang">Ruang</label>
                <input type="text" id="ruang" name="ruang" required placeholder="Masukkan Ruang Kelas (misal: A101)">
            </div>
            
            <input type="submit" value="Tambah Jadwal Mengajar">
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistem Akademik. All rights reserved.</p>
    </footer>

    <?php echo $message; // Menampilkan pesan alert ?>
</body>
</html>