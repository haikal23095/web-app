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

$mahasiswa = get_mahasiswa_from_id_user( $_SESSION['user']['ID_User']);
$total_kali_nilai = 0;

if (is_array($mahasiswa) && isset($mahasiswa['NIM'])) {
    $data_transkrip = get_transkrip_nilai($mahasiswa['NIM']);
    // print_r($data_transkrip);
    // echo is_array($data_transkrip) && isset($data_transkrip['NIM']) ? 'true' : 'false';
    if (mysqli_num_rows($data_transkrip) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_assoc($data_transkrip)){ 
            $kredit = (int)$row['SKS_Matakuliah'];
            $nilai = (float)konversi_nilai($row['Nilai']);
            $kali_nilai = $kredit * $nilai;

            $total_kali_nilai += $kali_nilai;
            ?>
            <?php }; 
    } else { ?>
            <td colspan="6">Data transkrip tidak ditemukan</td>
        </tr>
<?php }
} // Ambil NIM mahasiswa dari URL atau parameter lainnya
// $nim = isset($_GET['nim']) ? $_GET['nim'] : '';

// if ($nim) {
//     // **Query 1: Ambil data mahasiswa dan program studi**
//     $sql_mahasiswa = "
//         SELECT 
//             m.NIM, 
//             m.Nama_Mahasiswa, 
//             p.Nama_Prodi 
//         FROM 
//             Mahasiswa m
//         INNER JOIN 
//             Prodi p 
//         ON 
//             m.ID_Prodi = p.ID_Prodi
//         WHERE 
//             m.NIM = ?
//     ";

//     $stmt_mahasiswa = $conn->prepare($sql_mahasiswa);
//     $stmt_mahasiswa->bind_param("i", $nim);
//     $stmt_mahasiswa->execute();
//     $result_mahasiswa = $stmt_mahasiswa->get_result();

//     // Periksa apakah data mahasiswa ditemukan
//     if ($result_mahasiswa->num_rows > 0) {
//         $row_mahasiswa = $result_mahasiswa->fetch_assoc();
//         $nama_mahasiswa = $row_mahasiswa['Nama_Mahasiswa'];
//         $nim_mahasiswa = $row_mahasiswa['NIM'];
//         $prodi = $row_mahasiswa['Nama_Prodi'];
//     } else {
//         $nama_mahasiswa = "Tidak ditemukan";
//         $nim_mahasiswa = "Tidak ditemukan";
//         $prodi = "Tidak ditemukan";
//     }

//     $stmt_mahasiswa->close();

//     // **Query 2: Ambil data transkrip nilai berdasarkan NIM**
//     $sql_transkrip = "
//         SELECT 
//             Semester_Transkrip, 
//             Kode_Matakuliah, 
//             Nama_Matkuliah_Transkrip, 
//             SKS_Transkrip, 
//             Nilai 
//         FROM 
//             Transkip_nilai
//         WHERE 
//             NIM = ?
//         ORDER BY 
//             Semester_Transkrip, Kode_Matakuliah
//     ";

//     $stmt_transkrip = $conn->prepare($sql_transkrip);
//     $stmt_transkrip->bind_param("i", $nim);
//     $stmt_transkrip->execute();
//     $result_transkrip = $stmt_transkrip->get_result();

//     // Simpan data transkrip nilai untuk ditampilkan
//     $data_transkrip = [];
//     $total_sks = 0;
//     $jumlah_mmatkul = 0;

//     if ($result_transkrip->num_rows > 0) {
//         while ($row_transkrip = $result_transkrip->fetch_assoc()) {
//             $data_transkrip[] = $row_transkrip;
//             $total_sks += $row_transkrip['SKS_Transkrip'];
//             $jumlah_mmatkul++;
//         }
//     } else {
//         $data_transkrip = null; // Tidak ada data transkrip
//     }

//     $stmt_transkrip->close();
//     $conn->close();
// } else {
//     echo "NIM tidak valid.";
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="/css/transkrip_nilai.css">
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
                <h1>Transkrip Nilai</h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')" >Log Out</a>
            </header>
            <section class="welcome-message">
                <p>
                Transkrip Nilai berisi informasi nilai hasil studi mahasiswa mulai 
                dari semester awal sampai dengan semester terakhir mahasiswa. 
                Transkrip ini dapat dicetak dalam bentuk transkrip satu halaman.
                </p>
            </section>

            <div class="content-grid">
                <!-- Profil -->
                <div class="user-profile-transkrip-nilai">
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
                    </table>
                </div>
            </div>

            <div class="table-transkrip-nilai">
                <table border="2">
                    <tr>
                        <th>NO</th>
                        <th>SEMESTER</th>
                        <th>KODE</th>
                        <th>MATA KULIAH</th>
                        <th>SKS</th>
                        <th>NILAI</th>
                    </tr>
                    <?php
                    $mahasiswa = get_mahasiswa_from_id_user( $_SESSION['user']['ID_User']);
                    if (is_array($mahasiswa) && isset($mahasiswa['NIM'])) {
                        $data_transkrip = get_transkrip_nilai($mahasiswa['NIM']);
                        // print_r($data_transkrip);
                        // echo is_array($data_transkrip) && isset($data_transkrip['NIM']) ? 'true' : 'false';
                        if (mysqli_num_rows($data_transkrip) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($data_transkrip)){ ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['Semester_Matakuliah']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Kode_Matakuliah']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Nama_Matakuliah']); ?></td>
                                    <td><?php echo htmlspecialchars($row['SKS_Matakuliah']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Nilai']); ?></td>
                                </tr>
                            <?php }; 
                        } else { ?>
                            <tr>
                                <td colspan="6">Data transkrip tidak ditemukan</td>
                            </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6">Data mahasiswa tidak ditemukan</td>
                        </tr>
                    <?php } ?>        
                </table>
            </div>
            <div class="new-content-grid">
                <div class="prestasi-akademik">
                    <table>
                        <tr>
                            <td><b>Prestasi Akademik</b></td>
                        </tr>
                        <tr>
                            <td>Jumlah SKS diambil</td>
                            <td>: <?php echo get_sks_total_transkrip(get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['NIM'])['TotalSKS']; ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah mata kuliah diambil</td>
                            <td>: <?php echo get_matakuliah_total_transkrip(get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['NIM'])['TotalMatakuliah'] ?></td>
                        </tr>
                        <tr>
                            <td>IP Kumulatif</td>
                            <td>: <?php echo number_format($total_kali_nilai/ get_sks_total_transkrip(get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['NIM'])['TotalSKS'], 2); ?></td>
                        </tr>
                    </table>
                </div>

                <div class="keterangan-nilai">
                    <table>
                        <p><b>Keterangan Nilai</b></p>
                        <tr>
                            <td>A</td>
                            <td>: 4.00</td>
                            <td></td>
                            <td>C</td>
                            <td>: 2.00</td>
                        </tr>
                        <tr>
                            <td>B+</td>
                            <td>: 3.50</td>
                            <td></td>
                            <td>D+</td>
                            <td>: 1.50</td>
                        </tr>
                        <tr>
                            <td>B</td>
                            <td>: 3.00</td>
                            <td></td>
                            <td>D</td>
                            <td>: 1.00</td>
                        </tr>
                        <tr>
                            <td>C+</td>
                            <td>: 2.50</td>
                            <td></td>
                            <td>E</td>
                            <td>: 0.00</td>
                        </tr>
                    </table>
                </div>
            </div>
            <a href="cetak_transkrip.php"><button class="cetak">Cetak</button></a>
        </main>
    </div>

    <script src="../js/script2.js"></script>
</body>
</html>
