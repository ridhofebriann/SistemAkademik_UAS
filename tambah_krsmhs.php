<?php
include 'koneksi.php'; // Pastikan file koneksi database Anda sudah benar

$message = ""; // Variabel untuk menyimpan pesan sukses/error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $kd_mk = $_POST['kd_mk'];
    $kd_ds = $_POST['kd_ds'];
    $semester = $_POST['semester'];
    $nilai = isset($_POST['nilai']) && $_POST['nilai'] !== '' ? $_POST['nilai'] : NULL; // Nilai bisa NULL jika tidak diisi

    // Cek apakah kombinasi NIM, Kode MK, Kode Dosen sudah ada (Primary Key gabungan)
    $check_sql = "SELECT COUNT(*) FROM KRSMahasiswa WHERE nim = ? AND kd_mk = ? AND kd_ds = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("sss", $nim, $kd_mk, $kd_ds);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        $message = "<script>alert('Error: Mahasiswa sudah terdaftar pada mata kuliah ini dengan dosen yang sama.');</script>";
    } else {
        $sql = "INSERT INTO KRSMahasiswa (nim, kd_mk, kd_ds, semester, nilai) VALUES (?, ?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $nim, $kd_mk, $kd_ds, $semester, $nilai);

            if ($stmt->execute()) {
                $message = "<script>alert('Data KRS mahasiswa berhasil ditambahkan.'); window.location.href='krsmhs_list.php';</script>";
            } else {
                $message = "<script>alert('Error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            $message = "<script>alert('Error menyiapkan statement: " . $conn->error . "');</script>";
        }
    }
    // Penting: Tutup koneksi hanya jika koneksi masih aktif
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
    <title>Tambah KRS Mahasiswa</title>
    <link rel="stylesheet" href="cssstyle.css"> </head>
<body>
    <header>
        <h1>Tambah KRS Mahasiswa</h1>
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

    <main> <form action="tambah_krsmhs.php" method="post"> <h2>Tambah Data KRS Mahasiswa</h2>
            <div class="form-row">
                <div class="form-group">
                    <label for="nim">Mahasiswa (NIM - Nama)</label>
                    <select required id="nim" name="nim">
                        <option value="">-- Pilih Mahasiswa --</option>
                        <?php
                        // Ambil kembali koneksi jika sudah ditutup sebelumnya atau belum dibuat
                        if (!isset($conn) || !$conn->ping()) {
                            include 'koneksi.php';
                        }

                        // Query untuk mengisi dropdown Mahasiswa
                        $sql_mhs = "SELECT nim, nama FROM Mahasiswa ORDER BY nama";
                        $result_mhs = $conn->query($sql_mhs);

                        if ($result_mhs && $result_mhs->num_rows > 0) {
                            while($row_mhs = $result_mhs->fetch_assoc()) {
                                echo "<option value='" . $row_mhs["nim"] . "'>" . $row_mhs["nim"] . " - " . $row_mhs["nama"] . "</option>";
                            }
                        } else if ($conn->error) {
                            echo "<option value=''>Error fetching Mahasiswa: " . $conn->error . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="kd_mk">Mata Kuliah (Kode MK - Nama MK)</label>
                    <select required id="kd_mk" name="kd_mk">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        <?php
                        if (!isset($conn) || !$conn->ping()) {
                            include 'koneksi.php';
                        }
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
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="kd_ds">Dosen Pengajar (Kode Dosen - Nama Dosen)</label>
                    <select required id="kd_ds" name="kd_ds">
                        <option value="">-- Pilih Dosen Pengajar --</option>
                        <?php
                        if (!isset($conn) || !$conn->ping()) {
                            include 'koneksi.php';
                        }
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
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input required placeholder="Masukkan Semester (misal: 1, 2, 3)" type="number" id="semester" name="semester" min="1">
                </div>
            </div>

            <div class="form-group">
                <label for="nilai">Nilai (Opsional)</label>
                <input placeholder="Masukkan Nilai (misal: A, B, C) atau biarkan kosong" type="text" id="nilai" name="nilai">
            </div>

            <input type="submit" value="Tambah KRS">
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistem Akademik. All rights reserved.</p>
    </footer>

    <?php echo $message; // Menampilkan pesan alert ?>
</body>
</html>