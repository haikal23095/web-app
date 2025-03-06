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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="/css/profile-page.css">
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
                <h2>BIODATA MAHASISWA</h2>   
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')" >Log Out</a>
            </header>
            <div class="block-data">
                <div class="data-left">
                    <img src="../assets/img/blank-profile.png" alt="blank-profile">
                    <input type="file" id="file-input">
                    <label for="file-input">Choose</label>
                    <div class="data-utama">
                        <h4>Data Utama &#9655</h4>
                        <?php $data_mahasiswa = get_mahasiswa_from_id_user($_SESSION['user']['ID_User']);
                        
                        ?>
                        <ul class="data-utama-list">
                            <li class="list-item-data-utama">NIK : 351817530405004 </li>
                            <li class="list-item-data-utama">NISM : 035641 </li>
                            <li class="list-item-data-utama">NIM : <?= $data_mahasiswa['NIM'] ?></li>
                            <li class="list-item-data-utama">NAMA : <?= $data_mahasiswa['Nama_Mahasiswa'] ?></li>
                            <li class="list-item-data-utama">Tempat, Tanggal Lahir : 13 agustus 2005</li>
                            <li class="list-item-data-utama">Nama Ibu Kandung : yunika </li>
                        </ul>
                    </div>
                </div>
                <div class="data-right">
                    <div class="data-tambahan">
                        <h4>Data Tambahan &#9655</h4>
                        <ul class="data-tambahan-list">
                            <li class="list-item-data-tambahan">Asal SLTA : Smkn 1 Kamal</li>
                            <li class="list-item-data-tambahan">Jenis Kelamin : <?= $data_mahasiswa['Jenis_Kelamin_Mahasiswa'] ?></li>
                            <li class="list-item-data-tambahan">Agama : Islam</li>
                            <li class="list-item-data-tambahan">Nama Ayah : Haikal </li>
                            <li class="list-item-data-tambahan">Alamat : Jl telang indah raya</li>
                            <li class="list-item-data-tambahan">No Telp : <?= $_SESSION['user']['No_Hp']?></li>
                            <li class="list-item-data-tambahan">Warga Negara : Indonesia </li>
                            <li class="list-item-data-tambahan">email : <?= $data_mahasiswa['NIM'] ?> @student.trunojoyo.ac.id </li>
                        </ul>
                    </div>
                    <p>Jika ada kesalahan pada data, terutama di data utama, silahkan ajukan perubahan</p>
                    <a href="#"><button>Ajukan</button></a>
                </div>
            </div>
            
        </main>
    </div>

    <script src="../js/index-mahasiswa.js"></script>
</body>
</html>