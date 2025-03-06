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

// Query untuk mendapatkan data mahasiswa berdasarkan ID_User
$user_id = $_SESSION['user']['ID_User']; // Sesuaikan dengan kolom ID_User di sesi
$student = get_mahasiswa_from_id_user($user_id);
// Query untuk mendaptkan data prodi Mahasiswa
$prodi_result = get_prodi_mahasiswa($student['NIM']);
$prodi = $prodi_result->fetch_assoc();
$prodi_mahasiswa = $prodi['Nama_Prodi'];
// Mendapatkan maximal SKS yang bisa diambil oleh mahasiswa
$ip_semester = get_ip_semester($student['NIM'])['IP_Semester'];
$max_sks = max_sks_diambil($ip_semester);
// Query mendapatkan dosen wali
$dosen_wali = get_dosen_wali($student['NIM'])['Nama_Dosen'];
// Query untuk mendapatkan data KRS mahasiswa berdasarkan NIM
$krs_mahasiswa = get_krs_mahasiswa($student['NIM'], $student['SEMESTER_Mahasiswa']);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    if (isset($_POST['selected_courses'])) {
        DB->begin_transaction(); // Start transaction
        try {
            foreach ($_POST['selected_courses'] as $value) {
                list($id_matakuliah_krs, $id_krs) = explode(',', $value);
                delete_krs_detail($id_krs, $id_matakuliah_krs);
            }
            DB->commit(); // Commit transaction
        } catch (Exception $e) {
            DB->rollback(); // Rollback transaction on error
            echo "Failed to delete data: " . $e->getMessage();
            echo "<script>alert('Gagal menghapus data: " . $e->getMessage() . "');</script>";
        }
        // Refresh the page to reflect the changes
        header("Location: krs-tambah.php");
        exit();
    } else {
        echo "<script>alert('Tidak ada data yang dipilih!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/krs-tambah.css">
</head>
<body>
    <div class="container">
        <!-- Hamburger Menu -->
        <button class="hamburger" onclick="toggleSidebar()">☰</button>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-section">
                <div class="avatar"></div>
                <p>mahasiswa - <?= $_SESSION['user']['Username']  ?></p>
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

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>KARTU RENCANA STUDI</h1>
                <a href="../logout.php" class="logout">Log Out</a>
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
            <div class="student-info">
                <table>
                    <tr>
                        <td>NIM : </td>
                        <td><?= $student['NIM'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>Nama : </td>
                        <td><?= $student['Nama_Mahasiswa'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>IPK : </td>
                        <td><?= $student['IPK'] ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>Maksimum SKS : </td> 
                        <td><?= $max_sks ?? '-' ?> </td> 
                    </tr>
                    <tr>
                        <td>Program Studi : </td>
                        <td><?= $prodi_mahasiswa ?? '-' ?></td>
                    </tr>
                    <tr>
                        <td>Semester : </td>
                        <td><?= $student['SEMESTER_Mahasiswa']  ?></td>
                    </tr>
                    <tr>
                        <td>Dosen Wali : </td>
                        <td><?= $dosen_wali ?? '-' ?></td>
                    </tr>
                </table>
            </div>
            <div class="course-list">
                <form method="POST" action="krs-tambah.php">
                    <table>
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>ID_KRS</th>
                                <th>ID_Matakuliah_KRS</th>
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (mysqli_num_rows($krs_mahasiswa) > 0) {
                            $no = 1;
                            while ($row = $krs_mahasiswa->fetch_assoc()){
                                echo "<tr>";
                                    echo "<td>".$no."</td>";
                                    echo "<td>".$row['ID_KRS']."</td>";
                                    echo "<td>".htmlspecialchars($row['ID_Matakuliah_KRS'])."</td>";
                                    echo "<td>".htmlspecialchars($row['Kode_Matakuliah'])."</td>";
                                    echo "<td>".htmlspecialchars($row['Nama_Matakuliah'])."</td>";
                                    echo "<td>".htmlspecialchars($row['SKS_Matakuliah'])."</td>";
                                    echo "<td><input type='checkbox' name='selected_courses[]' value='" . $row['ID_Matakuliah_KRS'] . ',' . $row['ID_KRS'] . "'></td>";

                                echo "</tr>";
                                $no++;
                            }
                        }
                        ?>                            
                        </tbody>
                    </table>
                    <div class="actions">
                        <button type="button" class="add-button" style="background-color: red; color: white; padding: 10px;" 
                                onclick="window.location.href='krs-matakuliah.php';">
                            Tambah
                        </button>
                        <button type="submit" name="delete" class="delete-button" onclick="return confirm('apakah anda yakin menghapus')" style="background-color: blue; color: white; padding: 10px;">
                            Hapus
                        </button>                    
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
    </script>
    <script src="../js/script.js"></script>
</body>
</html>

