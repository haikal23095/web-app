<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH .  "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'admin') {
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
    <link rel="stylesheet" href="../css/index-admin.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
        <a href="profile_admin.php">
            <div class="profile-section" >
                <div class="avatar"></div>
                <p>Admin - <?= $_SESSION['user']['Username']  ?></p>
            </div>
            <nav class="menu">
                <ul>
                    <a href="../admin/index.php"><li><img src="../assets/icon-sidebar/mahasiswa/dashboard.png" alt="../admin/index.php"><span>Dashboard</span></li></a>
                    <a href="../admin/index_kelolaakunawal.php"><li><img src="../assets/icon-sidebar/admin/profil pengguna.png" alt="../admin/index.php"><span>Kelola Akun</span></li></a>
                    <a href="../admin/index_kalender.php"><li><img src="../assets/icon-sidebar/admin/kalender akademik.png" alt="kalender akademik"><span>Kelola Kalender Akademik</span></li></a>
                    <a href="../admin/index_krsawal.php"><li><img src="../assets/icon-sidebar/admin/krs.png" alt="../admin/index.php"><span>Kelola KRS</span></li></a>
                    <a href="../admin/index_jadwalkrs.php"><li><img src="../assets/icon-sidebar/admin/krs.png" alt="../admin/index.php"><span>Kelola Jadwal KRS</span></li></a>
                    <a href="../admin/index_kelola_pengumuman.php"><li><img src="../assets/icon-sidebar/admin/krs.png" alt="../admin/index.php"><span>Kelola Pengumuman</span></li></a>
                    <a href="../admin/index_kelola_diskusi.php"><li><img src="../assets/icon-sidebar/admin/krs.png" alt="../admin/index.php"><span>Kelola Diskusi</span></li></a>                    
                    <a href="../admin/index_kelola_khs.php"><li><img src="../assets/icon-sidebar/mahasiswa/khs.png" alt="../admin/index.php"><span>Kelola KHS</span></li></a>
                    <a href="../admin/kelola_ukt.php"><li><img src="../assets/icon-sidebar/admin/kelola ukt.png" alt="../admin/index.php"><span>Kelola UKT</span></li></a>
                    <a href="../admin/kelola-matkul.php"><li><img src="../assets/icon-sidebar/admin/info matakuliah.png" alt="../admin/index.php"><span>Kelola Informasi Matakuliah</span></li></a>
                    <a href="../admin/index_informasiakademik.php"><li><img src="../assets/icon-sidebar/admin/info akademik.png" alt="../admin/index.php"><span>Kelola Informasi Akademik</span></li></a>
                    <a href="../admin/index_kelola_faq.php"><li><img src="../assets/icon-sidebar/mahasiswa/faq.png" alt="../admin/index.php"><span>Kelola FAQ</span></li></a>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>Selamat Datang <?= $_SESSION['user']['Nama_User'] ?></h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')" >Log Out</a>  
            </header>
            <div class="title-dashboard">
                <!-- Kotak Pesan -->
                <div class="kotak-pesan" onclick="window.location.href='../admin/admin-pesan-masuk.php'">
                        <img src="../assets/img/Amplop.png" alt="Amplop">
                        <h3>Kelola Kotak Masuk Pesan</h3>
                </div>
                <div class="kotak-pesan" onclick="window.location.href='../admin/admin-pesan-terkirim.php'">
                        <img src="../assets/img/Amplop.png" alt="Amplop">
                        <h3>Kelola Kotak Terkirim Pesan</h3>
                </div>
                <h4 class="dashboard-title">Dashboard</h4>
            </div>
            <div class="content-grid">
                <!-- Pengumuman -->
                <div class="column-grid">
                    <h2>Kelola Akun</h2>
                    <img src="../assets/img/Settings.png" alt="sttings-icon" class="icon-settings">
                </div>
                <!-- Diskusi Terbaru -->
                <div class="column-grid">
                    <h2>Kelola Kalender Akademik</h2>
                    <img src="../assets/img/Settings.png" alt="sttings-icon" class="icon-settings">
                </div>
            </div>

            <div class="content-grid">
                <!-- Pengumuman -->
                <div class="column-grid">
                    <h2>Kelola Pengumuman</h2>
                    <img src="../assets/img/Settings.png" alt="sttings-icon" class="icon-settings">
                </div>
                <!-- Diskusi Terbaru -->
                <div class="column-grid">
                    <h2>Kelola Diskusi</h2>
                    <img src="../assets/img/Settings.png" alt="sttings-icon" class="icon-settings">
                </div>
            </div>

            <div class="content-grid">
                <!-- Pengumuman -->
                <div class="column-grid">
                    <h2>Kelola Pesan Selamat Datang</h2>
                    <img src="../assets/img/Settings.png" alt="sttings-icon" class="icon-settings">
                </div>
                <!-- Diskusi Terbaru -->
                <div class="column-grid">
                    <h2>Kelola Jadwal KRS</h2>
                    <img src="../assets/img/Settings.png" alt="sttings-icon" class="icon-settings">
                </div>
            </div>

            <div class="content-grid">
                <!-- Pengumuman -->
                <div class="column-grid">
                    <h2>Kelola Akun Pengguna</h2>
                    <img src="../assets/img/Settings.png" alt="sttings-icon" class="icon-settings">
                </div>
                <!-- Diskusi Terbaru -->
                <div class="column-grid">
                    <h2>Profile</h2>
                    <img src="../assets/img/Settings.png" alt="sttings-icon" class="icon-settings">
                </div>
            </div>
        </main>
    </div>

    <script src="../js/index-admin.js"></script>
</body>
</html>