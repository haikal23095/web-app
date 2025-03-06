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

$user_id = $_SESSION['user']['ID_User']; // Sesuaikan dengan kolom ID_User di sesi
$sql = "SELECT m.NIM, m.Nama_Mahasiswa, m.Semester_Mahasiswa, 
               p.Nama_Prodi, 
               mp.semester AS Semester_Perwalian, 
               d.Nama_Dosen, 
               (SELECT ROUND(AVG(n.SKS_Transkrip), 2) 
                FROM Transkip_nilai n 
                WHERE n.NIM = m.NIM) AS IPK
        FROM Mahasiswa m
        LEFT JOIN Prodi p ON m.ID_Prodi = p.ID_Prodi
        LEFT JOIN Mahasiswa_Perwalian mp ON m.NIM = mp.NIM
        LEFT JOIN Dosen d ON mp.NIP = d.NIP
        WHERE m.ID_User = ?";


$stmt = mysqli_prepare(DB, $sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

$max_sks = 15;

// Logika penentuan maksimum SKS berdasarkan IPK
$ipk = $student['IPK'] ?? 0; // Nilai IPK, default 0 jika tidak ada
if ($ipk >= 3.50) {
    $max_sks = 24;
} elseif ($ipk >= 3.00) {
    $max_sks = 22;
} elseif ($ipk >= 2.50) {
    $max_sks = 20;
} elseif ($ipk >= 2.00) {
    $max_sks = 18;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/krs.css">
    
</head>
<body>
    <div class="container">
        <!-- Hamburger Menu -->
        <button class="hamburger">☰</button>
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-section">
                <div class="avatar"></div>
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
        <div class="main-content">
            <div class="header">
                <h1>KARTU RENCANA STUDI</h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')"><button class="logout-btn">Log Out</button></a>  
            </div>
            <div class="info-section">
            <div class="description">
            <p>
                <strong>Keterangan</strong>
                <span class="arrow">▶</span>
            </p>
            <p>
                Kartu Rencana Studi merupakan fasilitas pengisian KRS secara online. Fasilitas KRS Online ini hanya dapat digunakan pada saat masa KRS atau masa revisi KRS. Mahasiswa dapat memilih matakuliah yang ingin diambil sesuai dengan jatah sks yang dimiliki dan matakuliah yang ditawarkan. Setelah melakukan pengisian KRS, mahasiswa dapat mencetak KRS tersebut agar dapat ditandatangani oleh dosen pembimbingnya masing-masing.
            </p>
        </div>
                <div class="warning">
                    <img src="../assets/img/warning.png" alt="Warning">
                    <span>Bukan Periode KRS</span>
                </div>
            </div>
            <div class="student-info">
                <table>
                    <tr>
                        <td>NIM</td>
                        <td>: <?= $student['NIM'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: <?= $student['Nama_Mahasiswa'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>IPK</td>
                        <td>: <?= $student['IPK'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>Maksimum SKS</td>
                        <td>: <?= $max_sks ?> </td> <!-- SKS dihitung berdasarkan IPK -->
                    </tr>
                    <tr>
                        <td>Program Studi</td>
                        <td>: <?= $student['Nama_Prodi'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>: Gasal 2024/2025</td>
                    </tr>
                    <tr>
                        <td>Dosen Wali</td>
                        <td>: <?= $student['Nama_Dosen'] ?? '-' ?></td>
                    </tr>
                </table>
</div>


            <div class="course-list">
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Mata Kuliah</th>
                            <th>Kelas</th>
                            <th>SKS</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" style="text-align: center;">(Tidak ada data matakuliah)</td>
                        </tr>
                    </tbody>
                </table>
                <button class="print-button" onclick="window.location.href='cetak_krs.php';">Cetak</button>
            </div>
        </div>
    </div>
    <script src="../js/index-admin.js"></script>
</body>
</html>
