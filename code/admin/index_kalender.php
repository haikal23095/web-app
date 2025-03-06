<?php
$page = "kalender";
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

if(isset($_POST['kalender'])) {
    get_file_kalender($_FILES);
};

$kalender = get_nama_kalender();
if (isset($_POST['hapus'])) {
    if (!empty($_POST['checkbox'])) {
        // var_dump($_POST['checkbox']);die;
        $idsToDelete = implode(',', $_POST['checkbox']);
        $sql = "DELETE FROM Kalender WHERE ID_Kalender IN ($idsToDelete)";
        if (DB->query($sql) === TRUE) {
            echo "
            <script>
                alert('data berhasil dihapus');
                document.location.href = './data';
            </script>
            ";
            exit;
        } else {
            echo "Error: " . DB->error;
        }
    } else {
        echo "<script>alert('Tidak ada data yang dipilih.')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="/css/style_kalender.css">
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
                <h1>Kalender Akademik</h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')" >Log Out</a>  
            </header>
            <section class="table-section">
                <form action="" method="POST" id="file" enctype= 'multipart/form-data'>
                    <label for="fileinput" class="add-button">Tambah</label>
                    <input style="display:none;" name="kalender" class="kalender" type="file" id="fileinput" accept=".pdf" required>
                </form>
                <form action="" method="post">
                    <button class="delete-button" type="submit" name="hapus" id="ooooo" value="Hapus yang dipilih">Hapus</button>
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Pilih</th>  
                                <th>Title</th>
                                <th>Date Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($kalender)!= 0):?>
                                <?php $no = 1; foreach (mysqli_fetch_all($kalender) as $data):?>
                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td><input type='checkbox' id="oooo" name='checkbox[]' value="<?= $data[0] ?>"></td>
                                    <td><?php echo $data[1] ?></td>
                                    <td><?php echo $data[2] ?></td>
                                </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </form>
            </section>
        </main>
    </div>

    <script src="../js/script_kalender.js"></script>
</body>
</html>