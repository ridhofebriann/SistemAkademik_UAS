<?php
include 'koneksi.php'; // Pastikan file koneksi database Anda sudah benar

$message = ""; // Variabel untuk menyimpan pesan sukses/error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $jk = $_POST['jk']; 
    $kota = $_POST['kota'];

    // Query INSERT yang sudah disesuaikan dengan penambahan kolom 'kota'
    $sql = "INSERT INTO Mahasiswa (nim, nama, tgl_lahir, jk, kota) VALUES (?, ?, ?, ?, ?)";
    
    // Periksa apakah query berhasil disiapkan
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter: 'sssss' karena sekarang ada 5 string (NIM, Nama, Tgl_Lahir, JK, Kota)
        $stmt->bind_param("sssss", $nim, $nama, $tgl_lahir, $jk, $kota); 

        // Eksekusi statement
        if ($stmt->execute()) {
            $message = "<script>alert('Data mahasiswa berhasil ditambahkan.'); window.location.href='mahasiswa_list.php';</script>";
        } else {
            $message = "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        $message = "<script>alert('Error menyiapkan statement: " . $conn->error . "');</script>";
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
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="cssstyle.css">
</head>
<body>
    <header>
        <h1>Tambah Mahasiswa</h1>
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
        <form action="tambah_mahasiswa.php" method="post">
            <h2>Tambah Mahasiswa Baru</h2>
            <div class="form-row">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" id="nim" name="nim" required placeholder="Masukkan NIM">
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" required placeholder="Masukkan Nama Lengkap">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <input type="date" id="tgl_lahir" name="tgl_lahir" required placeholder="Pilih Tanggal Lahir">
                </div>
                <div class="form-group">
                    <label for="jk">Jenis Kelamin</label>
                    <select id="jk" name="jk" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="kota">Kota</label>
                <input type="text" id="kota" name="kota" required placeholder="Masukkan Kota Asal">
            </div>

            <input type="submit" value="Tambah Mahasiswa">
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sistem Akademik. All rights reserved.</p>
    </footer>

    <?php echo $message; // Menampilkan pesan alert ?>
</body>
</html>