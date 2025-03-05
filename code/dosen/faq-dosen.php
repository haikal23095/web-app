<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
}

include_once($_SERVER["DOCUMENT_ROOT"] . "../config.php");
include_once(BASEPATH .  "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'dosen') {
    header("Location: ../loginpage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="../css/faq-dosen.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-section">
                <div class="avatar"></div>
                <p>Dosen - <?= $_SESSION['user']['Username']  ?></p>
            </div>
            <nav class="menu">
                <ul>
                    <a href="index.php"><li><img src="../assets/icon-sidebar/mahasiswa/dashboard.png" alt=""><span>Dashboard</span></li></a>
                    <a href="panduan-dosen.php"><li><img src="../assets/icon-sidebar/mahasiswa/panduan.png" alt=""><span>Panduan</span></li></a>
                    <a href="profile-dosen.php"><li><img src="../assets/icon-sidebar/mahasiswa/profile.png" alt=""><span>Profile</span></li></a>
                    <a href="mabing.php"><li><img src="../assets/icon-sidebar/dosen/mahasiswa bimbingan.png" alt=""><span>Mahasiswa</span></li></a>
                    <a href="val-krs-dosen.php"><li><img src="../assets/icon-sidebar/dosen/validasi krs.png" alt=""><span>Mahasiswa Perwalian</span></li></a>
                    <a href="val-skripsi-dosen.php"><li><img src="../assets/icon-sidebar/dosen/val Judul Skripsi.png" alt=""><span>Mahasiswa Bimbingan</span></li></a>
                    <a href="dosen-akademik.php"><li><img src="../assets/icon-sidebar/mahasiswa/akademik.png" alt=""><span>Akademik</span></li></a>
                    <a href="input-nilai.php"><li><img src="../assets/icon-sidebar/dosen/input-nilai.png" alt=""><span>Input Nilai</span></li></a>
                    <a href="ubah-password-dosen.php"><li><img src="../assets/icon-sidebar/mahasiswa/password.png" alt=""><span>Ubah Password</span></li></a>
                    <a href="faq-dosen.php"><li><img src="../assets/icon-sidebar/mahasiswa/faq.png" alt=""><span>FAQ</span></li></a>
                </ul>
            </nav>
        </aside>

        <!-- Main Content --> 
        <main class="main-content">
            <header class="header">
                <h1 id="header1">FAQ Dosen</h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')"><button class="logout-btn">Log Out</button></a>  
            </header>
            <section class="header-section">
                <h2>Universitas Trunojoyo Madura</h2>
                <p>Frequently Asked Questions mahasiswa adalah pertanyaan-pertanyaan yang sering kami tanyakan mengenai informasi yang ada di Universitas Trunojoyo Madura.</p>
            </section>
            <section class="form-section">
                <h3>Silahkan mengajukan pertanyaan yang belum ditanyakan</h3>
                <textarea placeholder="Tulis pertanyaan Anda..."></textarea>
                <button id="button">Kirim</button>
            </section>

            <section class="announcement-section">
                <h3>Pengumuman</h3>
                <div class="announcement-cards">
                    <div class="card">Informasi mahasiswa<br><small>belum ada informasi untuk kategori ini</small></div>
                    <div class="card">Informasi mahasiswa<br><small>belum ada informasi untuk kategori ini</small></div>
                    <div class="card">Informasi mahasiswa<br><small>belum ada informasi untuk kategori ini</small></div>
                    <div class="card">Informasi mahasiswa<br><small>belum ada informasi untuk kategori ini</small></div>
                </div>
            </section>
        </main>
    </div>

    <script src="js/script_faq_mahasiswa.js"></script>
</body>
</html>
