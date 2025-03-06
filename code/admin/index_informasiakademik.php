<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: /loginpage.php");
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH .  "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'admin') {
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
    <link rel="stylesheet" href="../css/style_informasiakademik.css">
</head>
<body>
    <div class="container">
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

        <!-- Main Content -->
        <main>
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <h1>Informasi Akademik</h1>
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')" >Log Out</a>
            </header>
            <section class="welcome-message">
                <p>
                Informasi akademik tentang hari, jam dan juga kelas dosen untuk melakukan masa belajar mengajar terhadap mahasiswa.
                </p>
            </section>
            <!-- plih program studi -->
            <form action="informasi-matakuliah.php" method="POST" id="prodi">
                <label for="opt-prodi">Program Studi</label>
                <select name="opt-prodi" id="opt-prodi">
                    <option value="1">TEKNIK INFORMATIKA</option>
                    <option value="2">TEKNIK MESIN</option>
                    <option value="3">TEKNIK INDUSTRI</option>
                    <option value="4">TEKNIK MEKATRONIKA</option>
                    <option value="5">TEKNIK ELEKTRO</option>
                    <option value="6">SISTEM INFRORMASI</option>
                </select>
                <button type="submit">Lihat</button>
            </form>
            <!-- Paket matakuliah setiap semester -->
            <ul class="paket-semester">
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 1</span>
                    <table border="1" class="table-matakuliah">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Nama Dosen</td>
                                <td>W/P</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="action">
                                    <button class="remove">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="../admin/index_infoakademik_tambah.php">
                            <button class="add">Tambah</button>
                        </a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 2</span>
                    <table border="1" class="table-matakuliah">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Nama Dosen</td>
                                <td>W/P</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="action">
                                    <button class="remove">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="../admin/index_infoakademik_tambah.php">
                            <button class="add">Tambah</button>
                        </a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 3</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Nama Dosen</td>
                                <td>W/P</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="action">
                                    <button class="remove">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="../admin/index_infoakademik_tambah.php">
                            <button class="add">Tambah</button>
                        </a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 4</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Nama Dosen</td>
                                <td>W/P</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="action">
                                    <button class="remove">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="../admin/index_infoakademik_tambah.php">
                            <button class="add">Tambah</button>
                        </a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 5</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Nama Dosen</td>
                                <td>W/P</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="action">
                                    <button class="remove">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="../admin/index_infoakademik_tambah.php">
                            <button class="add">Tambah</button>
                        </a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 6</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Nama Dosen</td>
                                <td>W/P</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="action">
                                    <button class="remove">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="../admin/index_infoakademik_tambah.php">
                            <button class="add">Tambah</button>
                        </a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 7</span>
                    <table border="1" class="table-matakuliah">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Nama Dosen</td>
                                <td>W/P</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="action">
                                    <button class="remove">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="../admin/index_infoakademik_tambah.php">
                            <button class="add">Tambah</button>
                        </a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 8</span>
                    <table border="1" class="table-matakuliah">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Nama Dosen</td>
                                <td>W/P</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="action">
                                    <button class="remove">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="../admin/index_infoakademik_tambah.php">
                            <button class="add">Tambah</button>
                        </a>
                    </div>
                </li>
                
            </ul>
            
        </main>
    </div>

    <script src="../js/script_informasiakademik.js"></script>
</body>
</html>
