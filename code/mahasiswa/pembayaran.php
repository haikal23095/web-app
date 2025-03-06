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
    exit();
}

// Periksa apakah username tersedia
if (!isset($_SESSION['user']['Username'])) {
    echo "Session data for username is not set!";
    exit();
}

$username = $_SESSION['user']['Username'];

// Query untuk mendapatkan NIM berdasarkan username
// Query untuk mendapatkan data UKT berdasarkan NIM
$query = "
    SELECT m.NIM, m.Nama_Mahasiswa, ukt.Golongan_UKT, ukt.Besaran_Ukt
    FROM Mahasiswa AS m
    JOIN UKT_Mahasiswa AS ukt ON m.NIM = ukt.NIM
    JOIN User AS u ON m.ID_User = u.ID_User
    WHERE u.Username = ?
";

// Prepared statement untuk keamanan
$stmt = mysqli_prepare(DB, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $nim = $data['NIM'];
    $nama = $data['Nama_Mahasiswa'];
    $golongan_ukt = $data['Golongan_UKT'];
    $total_tagihan = $data['Besaran_Ukt']; // Total Tagihan
} else {
    echo "Data UKT mahasiswa tidak ditemukan!";
    exit();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/pembayaran.css">
    <script 
        type="text/javascript" 
        src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="Mid-client-zoidq1yBQOVEN1yG">
    </script>
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
                <div class="header">
                    <h1>PEMBAYARAN UKT</h1>
                    <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')" >Log Out</a>
                </div>

                <div class="info-section">
                    <div class="keterangan">
                        <strong>keterangan</strong>
                        <p>Mahasiswa diwajibkan membayar Uang Kuliah Tunggal (UKT) setiap semester. Pembayaran ini merupakan syarat agar mahasiswa dapat melanjutkan proses akademik, termasuk mengakses menu pengambilan mata kuliah.</p>
                    </div>
                </div>
                <div class="student-info">
                    <table>
                        <tr>
                            <td>NIM</td>
                            <td>: <?= $nim; ?></td>
                            <td>Total Tagihan</td>
                            <td>: <strong> <?= $total_tagihan; ?> </strong></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>: <?= $nama; ?></td>
                            <td>Status Pembayaran</td>
                        <td>: <span style="color: red; font-weight: bold;"> belum dibayar </span></td>

                        </tr>
                        <tr>
                            <td>Golongan Ukt</td>
                            <td>: <?= $golongan_ukt; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="info-section pembayaran">
                    <h2>pembayaran</h2>
                    <p>
                        Halo <?= $nama; ?> Berdasarkan data yang tercatat di sistem, Anda memiliki tagihan UKT sebesar <?= $total_tagihan; ?> yang perlu dilunasi untuk semester ini. Pembayaran dapat dilakukan melalui berbagai metode yang telah disediakan, seperti transfer bank atau pembayaran online. Segera selesaikan pembayaran sebelum batas akhir agar proses registrasi mata kuliah dan kegiatan akademik Anda tidak terganggu. Jika Anda membutuhkan bantuan, jangan ragu untuk menghubungi pihak administrasi kampus. Terima kasih!
                    </p>
                    <form method="POST" action="proses_pembayaran.php">
                <!-- Input hidden untuk data transaksi -->
                <input type="hidden" name="order_id" value="ORDER-<?= time(); ?>">
                <input type="hidden" name="amount" value="<?= $total_tagihan; ?>">
                <button type="submit" class="payment-button">Lanjutkan Pembayaran</button>
            </form>
                </div>
            </div>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>