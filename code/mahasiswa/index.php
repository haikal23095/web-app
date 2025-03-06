<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: /loginpage.php");
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH .  "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'mahasiswa') {
    header("Location: /loginpage.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="/css/index-mahasiswa.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-section">
                <a href="profile-page.php"><div class="avatar"></div></a>
                <p>Mahasiswa - <?= $_SESSION['user']['Username']  ?></p>
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
                    <a href="pembayaran.php"><li><img src="../assets/icon-sidebar/admin/kelola ukt.png" alt=""><span>Pembayaran UKT</span></li></a>
                    <a href="ubah-password.php"><li><img src="../assets/icon-sidebar/mahasiswa/password.png" alt=""><span>Ubah Password</span></li></a>
                    <a href="index_faq_mahasiswa.php"><li><img src="../assets/icon-sidebar/mahasiswa/faq.png" alt=""><span>FAQ</span></li></a>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>Selamat Datang <?= $_SESSION['user']['Nama_User'] ?></h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')"><button class="logout-btn">Log Out</button></a>  
            </header>
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

    <script src="../js/index-mahasiswa.js"></script>
</body>
</htm