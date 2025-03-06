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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/kelola-matkul.css">
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
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>KELOLA MATA KULIAH</h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')" >Log Out</a>
            </header>

            <div class="tambah">
                <button onclick="location.href='tambah-kelola-matkul.php'">Tambah Mata Kuliah</button>
            </div>

            <!-- plih program studi -->
            <form action="kelola-matkul.php" method="POST" id="prodi">
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

            <table border="1" class="table-matakuliah">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Matakuliah</th>
                        <th>Prasyarat</th>
                        <th>Semester</th>
                        <th>SKS</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <tbody>
                        <?php
                                $semester = 1;
                                $matakuliah = get_matakuliah($semester, $prodi);
                                if ($matakuliah->num_rows > 0) {
                                    while ($semester < 8) {
                                        $matakuliah = get_matakuliah($semester, $prodi);
                                        $no = 1;
                                        while ($row = $matakuliah->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $no . "</td>";
                                            echo "<td>" . $row['Kode_Matakuliah'] . "</td>";
                                            echo "<td>" . $row['Nama_Matakuliah'] . "</td>";
                                            echo "<td>" . $row['Prasyarat_Matakuliah'] . "</td>";
                                            echo "<td>" . $row['Semester_Matakuliah'] . "</td>";
                                            echo "<td>" . $row['SKS_Matakuliah'] . "</td>";
                                            echo "<td>
                                                    <a href='edit-kelola-matkul.php?id=" .$row['ID_Matakuliah']. "' class='btn-edit btn'>Edit</a>
                                                    <a href='hapus-kelola-matkul.php?id=" . "' class='btn-hapus btn' onclick=\"return confirm('Apakah Data ingin dihapus?');\">Hapus</a>
                                                </td>";
                                            echo "</tr>";
                                            $no++;
                                        }
                                        $semester++;
                                    }
                                }   
                        ?>
                    </tbody>
            </table>         
        </main>
    </div>

    <script src="../js/kelola-matkul.js"></script>
</body>
</html>