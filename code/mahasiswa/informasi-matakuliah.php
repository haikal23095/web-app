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
$prodi = 0;
if (isset($_POST['submit-prodi'])) {
    $prodi = $_POST['opt-prodi'];
} else {
    $prodi = 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="/css/informasi-matakuliah.css">
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
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <h1>Informasi Matakuliah</h1>
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')" >Log Out</a>
            </header>
            <section class="welcome-message">
                <p>
                Informasi Matakuliah Ditawarkan berisi seluruh matakuliah yang ditawarkan pada semester aktif. Dari seluruh matakuliah yang terdapat pada daftar, setiap matakuliah mempunyai aturan tersendiri bergantung pada program studi, kurikulum, dan aturan akademik lainnya. Untuk lebih jelasnya, anda dapat melihat detail kelas
                </p>
            </section>
            <!-- plih program studi -->
            <form action="informasi-matakuliah.php" method="POST" id="prodi">
                <label for="opt-prodi">Program Studi</label>
                <select name="opt-prodi" id="opt-prodi">
                    <option value="0">Pilih Program Studi</option>
                    <?php
                        $get_prodi = get_program_studi();
                        if ($get_prodi->num_rows > 0) {
                            while ($row = $get_prodi->fetch_assoc()) {
                                echo "<option value='" . $row['ID_Prodi'] . "'>" . $row['Nama_Prodi'] . "</option>";
                            }
                        }
                    ?>
                </select>
                <button type="submit" name="submit-prodi">Lihat</button>
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
                                <td>Prasyarat</td>
                                <td>Semester</td>
                                <td>SKS</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $matakuliah = get_matakuliah(1, $prodi);
                                $no = 1;
                                if ($matakuliah->num_rows > 0) {
                                    while ($row = $matakuliah->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['Kode_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Nama_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Prasyarat_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Semester_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['SKS_Matakuliah'] . "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 2</span>
                    <table border="1" class="table-matakuliah">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Prasyarat</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $matakuliah = get_matakuliah(2, $prodi);
                                $no = 1;
                                if ($matakuliah->num_rows > 0) {
                                    while ($row = $matakuliah->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['Kode_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Nama_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Prasyarat_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Semester_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['SKS_Matakuliah'] . "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 3</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Prasyarat</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $matakuliah = get_matakuliah(3, $prodi);
                                $no = 1;
                                if ($matakuliah->num_rows > 0) {
                                    while ($row = $matakuliah->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['Kode_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Nama_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Prasyarat_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Semester_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['SKS_Matakuliah'] . "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 4</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Prasyarat</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $matakuliah = get_matakuliah(4, $prodi);
                                $no = 1;
                                if ($matakuliah->num_rows > 0) {
                                    while ($row = $matakuliah->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['Kode_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Nama_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Prasyarat_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Semester_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['SKS_Matakuliah'] . "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 5</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Prasyarat</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $matakuliah = get_matakuliah(5, $prodi);
                                $no = 1;
                                if ($matakuliah->num_rows > 0) {
                                    while ($row = $matakuliah->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['Kode_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Nama_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Prasyarat_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Semester_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['SKS_Matakuliah'] . "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 6</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Prasyarat</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $matakuliah = get_matakuliah(6, $prodi);
                                $no = 1;
                                if ($matakuliah->num_rows > 0) {
                                    while ($row = $matakuliah->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['Kode_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Nama_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Prasyarat_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Semester_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['SKS_Matakuliah'] . "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 7</span>
                    <table border="1" class="table-matakuliah">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Prasyarat</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $matakuliah = get_matakuliah(7, $prodi);
                                $no = 1;
                                if ($matakuliah->num_rows > 0) {
                                    while ($row = $matakuliah->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['Kode_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Nama_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Prasyarat_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Semester_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['SKS_Matakuliah'] . "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 8</span>
                    <table border="1" class="table-matakuliah">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>Prasyarat</td>
                                <td>Kelas</td>
                                <td>SKS</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $matakuliah = get_matakuliah(8, $prodi);
                                $no = 1;
                                if ($matakuliah->num_rows > 0) {
                                    while ($row = $matakuliah->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . $row['Kode_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Nama_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Prasyarat_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['Semester_Matakuliah'] . "</td>";
                                        echo "<td>" . $row['SKS_Matakuliah'] . "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </li>
                
            </ul>
            
        </main>
    </div>
    <script src="../js/informasi-matakuliah.js"></script>
</body>
</html>
