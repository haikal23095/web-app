<?php 
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "../config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

// Pastikan hanya admin yang bisa mengakses
if ($_SESSION['Level'] != 'admin') {
    header("Location: ../loginpage.php");
    exit();
}

// Ambil data admin dari database
$username = $_SESSION['user']['Username'];
$query = "SELECT * FROM User WHERE Username = ?";
$stmt = mysqli_prepare(DB, $query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// Tutup koneksi
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile_admin.css">
    
</head>
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
        <div class="main-content">
    <div class="header">
        <h1>PROFILE ADMIN</h1>
        <a href="../logout.php" class="logout">Log Out</a>
    </div>

    <div class="biodata-admin">

    <!-- Biodata Table -->
    <div class="biodata-table">
        <h2>data <span class="arrow">▶</span></h2>
        <table>
            <tr><td>Nama</td><td>: <?= htmlspecialchars($userData['Nama_User']); ?></td><td></td></tr>
            <tr><td>Jenis Kelamin</td><td>: <?= htmlspecialchars($userData['Level'] == 'admin' ? 'perempuan' : '-'); ?></td><td></td></tr>
            <tr><td>Agama</td><td>: islam</td><td></td></tr>
            <tr><td>Alamat</td><td>: jl telang indah</td><td></td></tr>
            <tr><td>No. Telp / Hp</td><td>: <?= htmlspecialchars($userData['No_Hp']); ?></td><td></td></tr>
            <tr><td>Warga Negara</td><td>: indonesia</td><td></td></tr>
            <tr><td>Email</td><td>: <?= htmlspecialchars($userData['Username']); ?>@trunojoyo.ac.id</td><td></td></tr>
        </table>
    </div>
</div>

<script src="../js/script.js"></script>
</body>
</html>
