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

$nim = get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['NIM'];
$semester_dipilih = isset($_POST['semester']) ? intval($_POST['semester']) : null;

$data_khs = [];
if ($nim && $semester_dipilih && $semester_dipilih >= 1 && $semester_dipilih <= 8) {
    // Query yang benar
    $sql_khs = "SELECT Matakuliah.Semester_Matakuliah, Matakuliah.Kode_Matakuliah, Matakuliah.Nama_Matakuliah, Matakuliah.SKS_Matakuliah, KHS_Detail.Nilai
                FROM Matakuliah
                JOIN Transkip_nilai ON Transkip_nilai.ID_Matakuliah = Matakuliah.ID_Matakuliah  
                JOIN KHS_Detail ON KHS_Detail.ID_Matakuliah = Matakuliah.ID_Matakuliah
                WHERE Transkip_nilai.NIM = ? AND Matakuliah.Semester_Matakuliah = ?";
    
    $stmt_khs = $DB->prepare($sql_khs);
    $stmt_khs->bind_param("si", $nim, $semester_dipilih); // Bind parameter dengan benar
    $stmt_khs->execute();
    $result_khs = $stmt_khs->get_result();
    $data_khs = $result_khs->fetch_all(MYSQLI_ASSOC);
    $stmt_khs->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="../css/khs_mahasiswa.css">
</head>
<body>
    <div class="container">
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
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>Kartu Hasil Studi</h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')" >Log Out</a>
            </header>
            <section class="welcome-message">
                <p>
                Kartu Hasil Studi merupakan fasilitas yang dapat digunakan 
                untuk melihat hasil studi mahasiswa persemester. 
                Selain dapat dilihat secara online, hasil studi ini juga dapat dicetak.
                </p>
            </section>

            <div class="content-grid">
                <!-- Form Pilih Semester -->
                <div class="user-profile-khs">
                    <form id="semesterForm" action="" method="POST">
                        <table>
                            <tr>
                                <td><label for="semester">Semester</label></td>
                                <td>
                                    <select id="semester" name="semester">
                                        <option value="">Pilih</option>
                                        <?php for ($i = 1; $i <8; $i++) : ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <button type="submit" id=lihatButton class="khs">Lihat</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <div class="content-grid">
                <!-- Profil Mahasiswa -->
                <div class="user-profile-khs-nilai">
                    <table>
                        <tr>
                            <td>NIM</td>
                            <td>: <?= get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['NIM'] ; ?></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>: <?= get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['Nama_Mahasiswa']; ?></td>
                        </tr>
                        <tr>
                            <td>Program Studi</td>
                            <td>: <?= get_prodi_from_ID_Prodi(get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['ID_Prodi'])['Nama_Prodi']; ?></td>
                        </tr>
                        <tr>
                            <td>Semester</td>
                            <td>: </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="table-khs" id="table-khs" style="display: none;">
                <!-- Tabel KHS -->
                <table border="2">
                    <tr>
                        <th>NO</th>
                        <th>KODE</th>
                        <th>MATA KULIAH</th>
                        <th>SKS</th>
                        <th>NILAI</th>
                    </tr>
                    <?php if (!empty($data_khs)) : ?>
                        <?php $no = 1; foreach ($data_khs as $khs) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($khs['Kode_Matakuliah']); ?></td>
                                <td><?= htmlspecialchars($khs['Nama_Matakuliah']); ?></td>
                                <td><?= htmlspecialchars($khs['SKS_Matakuliah']); ?></td>
                                <td><?= htmlspecialchars($khs['Nilai']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Tidak ada data untuk semester ini.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
            <a href="cetak_khs.php"><button class="cetak">Cetak</button></a>
        </main>
    </div>

    <script src="../js/khs_mahasiswa.js"></script>
</body>
</html>