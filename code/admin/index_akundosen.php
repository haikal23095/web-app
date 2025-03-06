<?php
$page = "akun-dosen";
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
$data_dosen = get_all_data_dosen();

// session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hapus'])) {
    $nip = $_POST['NIP'];

    // Memulai transaksi
    DB->begin_transaction();

    try {
        // Query untuk menghapus data dari tabel Dosen
        $sql = "DELETE FROM Dosen WHERE NIP = ?";
        $stmt = DB->prepare($sql);
        $stmt->bind_param("i", $nip);

        if ($stmt->execute()) {
            // Commit transaksi jika berhasil
            DB->commit();
            echo "<script>alert('Data berhasil dihapus.');</script>";
        } else {
            throw new Exception("Error deleting record: " . DB->error);
        }
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }

    header("Location:" . $_SERVER['PHP_SELF']);
    exit();
}

// // $hapus_data = delete_data_dosen($nip);
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hapus'])) {
//     if (isset($_POST['NIP'])) {
//         DB->begin_transaction(); // Start transaction
//         try {
//             foreach ($_POST['NIP'] as $nip) {
//                 delete_data_dosen($nip);
//             }
//             DB->commit(); // Commit transaction
//         } catch (Exception $e) {
//             DB->rollback(); // Rollback transaction on error
//             echo "Failed to delete data: " . $e->getMessage();
//         }
//         // Refresh the page to reflect the changes
//         header("Location: index_akundosen.php");
//         exit();
//     }
// }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="/css/style_akundosen.css">
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
                <h1>Kelola Akun Dosen</h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout">Log Out</a>
            </header>
            <section class="table-section">
                <table>
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data_dosen as $val): ?>
                            <tr>
                                <td><?= $val['NIP'] ?></td>
                                <td><?= $val['Nama_Dosen'] ?></td>
                                <td><?= $val['Nama_Prodi'] ?></td>
                                <td><?= $val['Alamat_Dosen'] ?></td>
                                <td><?= $val['Jenis_Kelamin_Dosen'] ?></td>
                                <td class="tombol_aksi">
                                    <form action="" method="POST" enctype= 'multipart/form-data'>
                                        <input type="hidden" name="NIP" value="<?= $val['NIP'] ?>">
                                        <button type="submit" name="hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
                                </td>                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="../admin/index_kelola_tambah_dosen.php">
                    <button class="tambah">Tambah</button>
                </a>
            </section>
        </main>
    </div>
    <script src="../js/script_akundosen.js"></script>
</body>
</html>