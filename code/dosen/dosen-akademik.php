<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
}

include_once($_SERVER["DOCUMENT_ROOT"] . "../config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'dosen') {
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dosen-akademik.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-section">
                <div class="avatar"></div>
                <p>Dosen - <?= $_SESSION['user']['Username'] ?></p>
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
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>AKADEMIK</h1>
                <button id="hamburger" class="hamburger">&#9776;</button>
                <a href="../logout.php" class="logout" onclick="return confirm('Apakah anda yakin ingin logout?')"><button class="logout-btn">Log Out</button></a>
            </header>

            <!-- Keterangan -->
            <div class="description">
                <h3>Keterangan ▷</h3>
                <p>Informasi Akademik tentang Hari, Jam dan juga kelas dosen untuk melakukan masa belajar mengajar terhadap mahasiswa.</p>
            </div>

            <!-- Pilih Program Studi -->
            <form action="informasi-matakuliah.php" method="POST" id="prodi">
                <label for="opt-prodi">Program Studi</label>
                <select name="opt-prodi" id="opt-prodi">
                    <option value="1">TEKNIK INFORMATIKA</option>
                    <option value="2">TEKNIK MESIN</option>
                    <option value="3">TEKNIK INDUSTRI</option>
                    <option value="4">TEKNIK MEKATRONIKA</option>
                    <option value="5">TEKNIK ELEKTRO</option>
                    <option value="6">SISTEM INFORMASI</option>
                </select>
                <button type="submit">Lihat</button>
            </form>

            <ul class="paket-semester">
                <?php
                    for ($semester = 1; $semester <= 8; $semester++) {
                        echo "<li>";
                        echo "<span class='dropdown-matakuliah'>&#9655;</span><span>Paket Semester $semester</span>";

                        // Query for fetching the courses and their rooms for the selected semester
                        $query = "
                            SELECT m.Kode_Matakuliah, m.Nama_Matakuliah, m.SKS_Matakuliah, r.Nama_Ruangan
                            FROM Matakuliah m
                            LEFT JOIN Matakuliah_KRS mk ON m.ID_Matakuliah = mk.ID_Matakuliah
                            LEFT JOIN Ruangan r ON mk.ID_Ruangan = r.ID_Ruangan
                            WHERE m.Semester_Matakuliah = $semester";

                        $result = mysqli_query(DB, $query);

                        echo "<table border='1' class='table-matakuliah'>
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Kode</td>
                                        <td>Mata Kuliah</td>
                                        <td>SKS</td>
                                        <td>Ruangan</td>
                                    </tr>
                                </thead>
                                <tbody>";

                        if (mysqli_num_rows($result) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>" . $no++ . "</td>
                                        <td>" . $row['Kode_Matakuliah'] . "</td>
                                        <td>" . $row['Nama_Matakuliah'] . "</td>
                                        <td>" . $row['SKS_Matakuliah'] . "</td>
                                        <td>" . $row['Nama_Ruangan'] . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Tidak ada data untuk semester ini</td></tr>";
                        }

                        echo "</tbody></table>";
                        echo "</li>";
                    }
                ?>
            </ul>
        </main>
    </div>

    <script src="../js/dosen-akademik.js"></script>
</body>
</html>
