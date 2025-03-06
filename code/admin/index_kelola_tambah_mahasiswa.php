<?php
$page = "akun-mahasiswa-tambah";
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $nama_mahasiswa = $_POST['nama_mahasiswa'];
    $alamat_mahasiswa = $_POST['alamat_mahasiswa'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $id_prodi = $_POST['prodi'];
    $password = $_POST['password'];
    $telp = $_POST['telp'];

    // Buat user secara otomatis
    $username = strtolower(str_replace(' ', '_', $nama_mahasiswa)); // Username dari nama dosen
    // $password = $password; // Password default
    $level = 'mahasiswa'; // Level user dosen

    // Memulai transaksi
    DB->begin_transaction();

    try {
        // Insert ke tabel User
        $sql_user = "INSERT INTO User (Nama_User, Username, Password, Level, No_HP) VALUES ('$nama_mahasiswa','$nama_mahasiswa''$username', sha2('$password',256), '$level', '$telp')";
        if (!DB->query($sql_user)) {
            throw new Exception("Error inserting into User: " . DB->error);
        }

        // Ambil ID_User yang baru saja dibuat
        $id_user = DB->insert_id;

        // Insert ke tabel Dosen
        $sql_dosen = "INSERT INTO Mahasiswa (NIM, Nama_Mahasiswa, Alamat_Mahasiswa, Jenis_Kelamin_Mahasiswa, ID_User, ID_UKT, SEMESTER_Mahasiswa, ID_Prodi) 
                      VALUES ('$nim', '$nama_mahasiswa', '$alamat_mahasiswa', '$jenis_kelamin', '$id_mahasiswa', '$id_user', '$id_ukt', '$Semester_mahasiswa', '$id_prodi')";
        
        if (!DB->query($sql_dosen)) {
            throw new Exception("Error inserting into Dosen: " . DB->error);
        }

        // Commit transaksi jika semua berhasil
        DB->commit();
        header('Location: index_akunmahasiswa.php');
        exit();
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="../css/style_kelola_tambah_mahasiswa.css">
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
                <h1>Akun Pengguna</h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout">Log Out</a>
            </header>
            <section class="form-section">
                <h2>Tambah Data Mahasiswa</h2>
                <form id="mahasiswaForm" action="index_kelola_tambah_mahasiswa.php" method="POST">
                    <button type="submit" class="btn-add">Tambah</button>
                    <a href="index_akunmahasiswa.php"><button type="button" class="btn-cancel">Batal</button></a>

                    <label for="nim">NIM:</label>
                    <input type="number" id="nim" name="nim" required>

                    <label for="nama_mahasiswa">Nama Mahasiswa:</label>
                    <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <label for="alamat_mahasiswa">Alamat Mahasiswa:</label>
                    <textarea id="alamat_mahasiswa" name="alamat_mahasiswa" required></textarea>
                    
                    <label for="telp">No HP:</label>
                    <input type="text" id="telp" name="telp" required pattern="\d{12}" title="Harus 12 digit angka">

                    <label for="ukt">Golongan UKT:</label>
                    <select id="ukt" name="ukt" required>
                        <?php
                        // Ambil data program studi dari database
                        $sql = "SELECT ID_UKT, Besaran_Ukt FROM UKT_Mahasiswa";
                        $result = DB->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data dari setiap baris
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["ID_UKT"] . "'>" . $row["Besaran_Ukt"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada program studi</option>";
                        }
                        DB->close();
                        ?>
                    </select>

                    <label for="jenis_kelamin">Jenis Kelamin Mahasiswa:</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="L">L</option>
                        <option value="P">P</option>
                    </select>

                    <label for="prodi">Program Studi:</label>
                    <select id="prodi" name="prodi" required>
                        <?php
                        // Ambil data program studi dari database
                        $sql = "SELECT ID_Prodi, Nama_Prodi FROM Prodi";
                        $result = DB->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data dari setiap baris
                            while($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["ID_Prodi"] . "'>" . $row["Nama_Prodi"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada program studi</option>";
                        }
                        DB->close();
                        ?>
                    </select>
                </form>
            </section>
        </main>
    </div>

    <script src="../js/index_kelola_tambah_mahasiswa.js"></script>
</body>
</html>