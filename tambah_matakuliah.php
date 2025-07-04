<?php
include 'koneksi.php'; // Pastikan file koneksi database Anda sudah benar

$message = ""; // Variabel untuk menyimpan pesan sukses/error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kd_mk = $_POST['kd_mk'];
    $nama = $_POST['nama'];
    $sks = $_POST['sks'];

    $sql = "INSERT INTO MataKuliah (kd_mk, nama, sks) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssi", $kd_mk, $nama, $sks); // 'ssi' karena kd_mk dan nama string, sks integer

        if ($stmt->execute()) {
            $message = "<script>alert('Data mata kuliah berhasil ditambahkan.'); window.location.href='matakuliah_list.php';</script>";
        } else {
            $message = "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        $message = "<script>alert('Error menyiapkan statement: " . $conn->error . "');</script>";
    }
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
    <title>Tambah Mata Kuliah</title>
    <link rel="stylesheet" href="cssstyle.css">
</head>
<body>
    <header>
        <h1>Tambah Mata Kuliah</h1>
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
            <h2>Tambah Mata Kuliah Baru</h2>
            <div class="form-row">
                <div class="form-group">
                    <label for="kd_mk">Kode Mata Kuliah</label>
                    <input type="text" id="kd_mk" name="kd_mk" required placeholder="Masukkan Kode Mata Kuliah (misal: MK001)">
                </div>
                <div class="form-group">
                    <label for="nama">Nama Mata Kuliah</label>
                    <input type="text" id="nama" name="nama" required placeholder="Masukkan Nama Mata Kuliah">
                </div>
            </div>
            
            <div class="form-group">
                <label for="sks">Jumlah SKS</label>
                <input type="number" id="sks" name="sks" required min="1" placeholder="Masukkan Jumlah SKS (misal: 3)">
            </div>
            
            <input type="submit" value="Tambah Mata Kuliah">
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistem Akademik. All rights reserved.</p>
    </footer>

    <?php echo $message; // Menampilkan pesan alert ?>
</body>
</html>