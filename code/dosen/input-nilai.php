<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: /loginpage.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'dosen') {
    header("Location: /loginpage.php");
    exit();
}

$jumlah_matkul_diampu = 0;
$id_user = $_SESSION['user']['ID_User'];
$nip = get_data_dosen($id_user)['NIP'];
$jumlah_matkul_diampu = get_matakuliah_diampu($nip)->num_rows;

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/input-nilai.css">
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
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>INPUT NILAI</h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')"><button class="logout-btn">Log Out</button></a>  
            </div>

            <!-- Keterangan -->
            <div class="keterangan">
                <p>
                    <strong>Keterangan</strong>
                    <span class="arrow">▶</span>
                </p>
                <p>
                    Matakuliah yang diampu oleh Dosen akan ditampilkan Dalam menu sivitas, dan untuk menilai mahasiswa
                </p>
            </div>
            <!-- Form Ubah Password -->
            <div class="matakuliah-diampu">
                <h2>Matakuliah yang ditambahkan admin</h2>
                <?php if ($jumlah_matkul_diampu == 0){
                    echo "<p>Belum ada matakuliah yang diampu</p>";
                } else { ?>
                    <?php
                    $matakuliah_diampu = get_matakuliah_diampu($nip);
                    while ($row = $matakuliah_diampu->fetch_assoc()) {
                        echo "<div class='list-matakuliah'>
                                <wrapper>
                                    <h3>".$row['Nama_Matakuliah_KRS']."</h3>
                                    <h3>".$row['Nama_Ruangan']."</h3>;
                                    <span class='arrow'>Lihat Mahasiswa ▶</span>
                                </wrapper>
                                <h3 class='bobot-sks'>".$row['Bobot_SKS']." SKS </h3>";
                        echo "</div>";                                
                        }
                            ?>
                <?php } ?>
                
            </div>
        </div>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>