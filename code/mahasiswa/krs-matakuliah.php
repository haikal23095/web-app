<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
}

include_once($_SERVER["DOCUMENT_ROOT"] . "../config.php");
include_once(BASEPATH .  "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'mahasiswa') {
    header("Location: ../loginpage.php");
    exit();
}

$semester = isset($_GET['semester']) ? (int)$_GET['semester'] : null;

if ($semester !== null) {
    $query = "SELECT m.*, k.Jadwal_Matakuliah, r.Nama_Ruangan FROM Matakuliah m
              LEFT JOIN Matakuliah_KRS k ON m.ID_Matakuliah = k.ID_Matakuliah
              LEFT JOIN Ruangan r ON k.ID_Ruangan = r.ID_Ruangan
              WHERE m.semester = ? ORDER BY m.Nama_Matakuliah";
} else {
    $query = "SELECT m.*, k.Jadwal_Matakuliah, r.Nama_Ruangan FROM Matakuliah m
              LEFT JOIN Matakuliah_KRS k ON m.ID_Matakuliah = k.ID_Matakuliah
              LEFT JOIN Ruangan r ON k.ID_Ruangan = r.ID_Ruangan
              ORDER BY m.Nama_Matakuliah";
}

$stmt = mysqli_prepare(DB, $query);
if ($semester !== null) {
    $stmt->bind_param("i", $semester);
}
$stmt->execute();
$result = $stmt->get_result();

$matakuliah = [];
while ($row = mysqli_fetch_assoc($result)) {
    $matakuliah[$row['Semester_Matakuliah']][] = $row; 
}

$stmt->close();


// echo "<pre>";
// print_r($matakuliah);
// echo "</pre>";
// exit();

?>

<!DOCTYPE html>
<html lang="id">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/krs-matakuliah.css">
    
</head>

</head>
<body>
<body>
    <div class="container">
        <!-- Hamburger Menu -->
        <button class="hamburger">☰</button>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-section">
                <div class="avatar"></div>
                <p>Admin - <?= $_SESSION['user']['Username']  ?></p>
            </div>
            <nav class="menu">
            <ul>
                    <a href="index.php"><li><img src="../assets/icon-sidebar/mahasiswa/dashboard.png" alt=""><span>Dashboard</span></li></a>
                    <a href="panduan_mahasiswa.php"><li><img src="../assets/icon-sidebar/mahasiswa/panduan.png" alt=""><span>Panduan</span></li></a>
                    <a href="profile-page.php"><li><img src="../assets/icon-sidebar/mahasiswa/profile.png" alt=""><span>Profile</span></li></a>
                    <a href="informasi-matakuliah.php"><li><img src="../assets/icon-sidebar/mahasiswa/matakuliah.png" alt=""><span>Matakuliah</span></li></a>
                    <a href="krs-tambah.php"><li><img src="../assets/icon-sidebar/mahasiswa/krs.png" alt=""><span>KRS</span></li></a>
                    <a href="khs_mahasiswa.php"><li><img src="../assets/icon-sidebar/mahasiswa/khs.png" alt=""><span>KHS</span></li></a>
                    <a href="transkrip_nilai.php"><li><img src="../assets/icon-sidebar/mahasiswa/transkip.png" alt=""><span>Transkrip Nilai</span></li>
                    <a href="pengajuan_judul_skripsi.php"><li><img src="../assets/icon-sidebar/mahasiswa/skripsi.png" alt=""><span>Pengajuan Judul Skripsi</span></li></a>
                    <a href="informasi_akademik_mahasiswa.php"><li><img src="../assets/icon-sidebar/mahasiswa/akademik.png" alt=""><span>Akademik</span></li></a>
                    <a href="pembayaran.php"><li><img src="../assets/icon-sidebar/admin/kelola ukt.png" alt=""><span>pembayaran ukt</span></li></a>
                    <a href="ubah-password.php"><li><img src="../assets/icon-sidebar/mahasiswa/password.png" alt=""><span>Ubah Password</span></li></a>
                    <a href="index_faq_mahasiswa.php"><li><img src="../assets/icon-sidebar/mahasiswa/faq.png" alt=""><span>FAQ</span></li></a>
                </ul>
            </nav>
        </aside>
        <div class="main-content">
  <!-- Header -->
  <div class="header">
    <h1>KARTU RENCANA STUDI</h1>
    <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')" >Log Out</a>
  </div>
    <button class="btn-submit" onclick="window.location.href='krs-tambah.php'">KEMBALI</button>
  <!-- Keterangan -->
  <div class="description">
        <p>
            <strong>Keterangan</strong>
            <span class="arrow">▶</span>
        </p>
        <p>
        Silakan pilih salah satu mata kuliah yang tersedia, lalu tekan tombol 'Tambahkan' untuk menambahkannya ke KRS Anda
        </p>
    </div>


    <div class="semester-links">
    <ul>
        <?php for ($i = 1; $i <= 8; $i++): ?>
            <li>
                <a href="#" data-semester="<?= $i ?>" class="semester-link">Paket Semester <?= $i ?></a>
                <div class="table-container" id="semester-<?= $i ?>" style="display: none;">
                </div>
                
    <table>
        <thead>
            <tr>
                <th>Pilih</th>
                <th>Kode</th>
                <th>Matakuliah</th>
                <th>SKS</th>
                <th>Dosen</th>
                <th>Jadwal</th>
                <th>Ruangan</th>
            </tr>
        </thead>
        <tbody>
            <form action="krs-proses.php" method="POST">
            <?php if (isset($matakuliah[$i]) && !empty($matakuliah[$i])): ?>
                <?php foreach ($matakuliah[$i] as $mk): ?>
                    <tr>
                        <td><input type="checkbox" name="matakuliah[]" value="<?= htmlspecialchars($mk['ID_Matakuliah'] ?? '') ?>"></td>
                        <td><?= htmlspecialchars($mk['Kode_Matakuliah'] ?? '') ?></td>
                        <td><?= htmlspecialchars($mk['Nama_Matakuliah'] ?? '') ?></td>
                        <td><?= htmlspecialchars($mk['SKS_Matakuliah'] ?? '') ?></td>
                        <td><?= htmlspecialchars($mk['Nama_Dosen'] ?? '') ?></td>
                        <td><?= htmlspecialchars($mk['Jadwal_Matakuliah'] ?? '') ?></td>
                        <td><?= htmlspecialchars($mk['Nama_Ruangan'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Tidak ada mata kuliah di semester ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <button type="submit" class="btn-submit">Tambahkan ke KRS</button>
</form>
            </li>
        <?php endfor; ?>
    </ul>
</div>

    <script src="../js/krs-matakuliah.js"></script>
</body>
</html>