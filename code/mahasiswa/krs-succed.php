<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "../config.php");
include_once(BASEPATH .  "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'mahasiswa') {
    header("Location: ../loginpage.php");
    exit();
}

// Ambil data dari session
$krs_success = $_SESSION['krs_success'] ?? [];
$krs_failure = $_SESSION['krs_failure'] ?? [];

// Bersihkan data session setelah diambil
unset($_SESSION['krs_success']);
unset($_SESSION['krs_failure']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM - Hasil KRS</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/krs-succed.css">
</head>
<body>
    <div class="container">
        <!-- Hamburger Menu -->
        <button class="hamburger">☰</button>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-section">
                <div class="avatar"></div>
                <p>Mahasiswa - <?= htmlspecialchars($_SESSION['user']['Username']) ?></p>
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
                    <a href="ubah-password.php"><li><img src="../assets/icon-sidebar/mahasiswa/password.png" alt=""><span>Ubah Password</span></li></a>
                    <a href="index_faq_mahasiswa.php"><li><img src="../assets/icon-sidebar/mahasiswa/faq.png" alt=""><span>FAQ</span></li></a>
                </ul>
            </nav>
        </aside>

        <div class="result-container">
            <!-- Header -->
            <div class="header">
                <h1>HASIL PENGISIAN KRS</h1>
                <a href="../logout.php" class="logout">Log Out</a>
            </div>

            <!-- Kotak Berhasil Diambil -->
            <div class="result-section success">
                <h3>Matakuliah yang berhasil diambil:</h3>
                <ul>
                    <?php if (!empty($krs_success)): ?>
                        <?php foreach ($krs_success as $success): ?>
                            <li><?= htmlspecialchars($success) ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- <li>Tidak ada matakuliah yang berhasil diambil.</li> -->
                        <li>Pemrograman Dasar A berhasil diambil.</li>
                        <!-- <li>Fisika Dasar A berhasil diambil.</li>
                        <li>Matematika Dasar A berhasil diambil.</li> -->
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Kotak Tidak Berhasil Diambil -->
            <div class="result-section failure">
                <h3>Matakuliah yang tidak berhasil diambil:</h3>
                <ul>
                    <li> Pengantar Teknologi Informasi A bentrok dengan Pemrograman Dasar A </li>
                </ul>
            </div>

            <!-- Tombol Navigasi -->
            <div class="button-group">
                <button class="btn-back" onclick="window.location.href='krs-tambah.php';">
                    Lihat KRS
                </button>
            </div>
        </div>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>