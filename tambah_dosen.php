<?php
include 'koneksi.php'; // Pastikan file koneksi database Anda sudah benar

$message = ""; // Variabel untuk menyimpan pesan sukses/error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kd_ds = $_POST['kd_ds'];
    $nama = $_POST['nama'];
    // Hapus baris berikut karena kolom 'jk' dan 'tgl_lahir' tidak ada di tabel Dosen:
    // $jk = $_POST['jk']; 
    // $tgl_lahir = $_POST['tgl_lahir'];

    // KOREKSI: Sesuaikan query SQL hanya dengan kolom yang ada di tabel Dosen
    $sql = "INSERT INTO Dosen (kd_ds, nama) VALUES (?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // KOREKSI: Sesuaikan parameter bind_param hanya dengan variabel yang digunakan
        $stmt->bind_param("ss", $kd_ds, $nama); 

        if ($stmt->execute()) {
            $message = "<script>alert('Data dosen berhasil ditambahkan.'); window.location.href='dosen_list.php';</script>";
        } else {
            $message = "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        $message = "<script>alert('Error menyiapkan statement: " . $conn->error . "');</script>";
    }
    // Pastikan koneksi ditutup hanya jika sudah dibuka dan tidak ada error fatal sebelumnya
    if (isset($conn) && $conn->ping()) {
        $conn->close();
    }
}
echo $message; // Tampilkan pesan alert jika ada
?>
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dosen</title>
    <link rel="stylesheet" href="cssstyle.css">
</head>
<body>
    <header>
        <h1>Tambah Dosen</h1>
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
        <form action="tambah_dosen.php" method="post">
            <h2>Tambah Dosen Baru</h2>
            <div class="form-row">
                <div class="form-group">
                    <label for="kd_ds">Kode Dosen</label>
                    <input type="text" id="kd_ds" name="kd_ds" required placeholder="Masukkan Kode Dosen (misal: DS001)">
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" required placeholder="Masukkan Nama Lengkap Dosen">
                </div>
            </div>
            
                
            </div>
            
            <input type="submit" value="Tambah Dosen">
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistem Akademik. All rights reserved.</p>
    </footer>

    <?php echo $message; // Menampilkan pesan alert ?>
</body>
</html>