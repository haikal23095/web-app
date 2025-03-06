<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: /loginpage.php");
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH .  "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'dosen') {
    header("Location: /loginpage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="/css/index-dosen.css">
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
            <!-- Header -->
            <div class="header">
                <h1>Selamat Datang <?= $_SESSION['user']['Nama_User'] ?></h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')"><button class="logout-btn">Log Out</button></a>  
            </div>
            <section class="welcome-message">
                <p>
                    Selamat Datang di Portal Akademik Universitas Trunojoyo Madura. 
                    Portal Akademik adalah sistem yang memungkinkan para civitas akademika Universitas Trunojoyo Madura 
                    untuk menerima informasi dengan lebih cepat melalui Internet. Sistem ini dihadirkan untuk memberi 
                    kemudahan setiap civitas akademika untuk melakukan aktivitas-aktivitas akademik dan proses belajar mengajar.
                    Selamat menggunakan fasilitas ini.
                </p>
            </section>

            <div class="content-grid">
                <!-- Kotak Pesan -->
                <div class="kotak-pesan">
                    <h2>Kotak Pesan</h2>
                    <p>Anda tidak memiliki pesan terbaru</p>
                    <button>Kotak Masuk</button>
                </div>

                <!-- Pengumuman -->
                <div class="pengumuman">
                    <h2>Pengumuman</h2>
                    <ul>
                        <li>Informasi Akademik belum ada informasi untuk kategori ini</li>
                        <li>Informasi Akademik belum ada informasi untuk kategori ini</li>
                        <li>Informasi Akademik belum ada informasi untuk kategori ini</li>
                    </ul>
                </div>

                <!-- Diskusi Terbaru -->
                <div class="diskusi-terbaru">
                    <h2>Diskusi Terbaru</h2>
                    <ul>
                        <li>Kritik dan saran SIAKAD UTM: kartu rencana studi tidak dapat dicetak</li>
                        <li>Kritik dan saran SIAKAD UTM: proses validasi terlalu lama</li>
                        <li>Kritik dan saran SIAKAD UTM: lebih baik ada fitur notifikasi</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
    <script src="../js/index-admin.js"></script>
</body>
</htm