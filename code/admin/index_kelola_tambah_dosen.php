<?php 
$page = "akun-dosen-tambah";
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
    $nip = $_POST['nip'];
    $nama_dosen = $_POST['nama_dosen'];
    $alamat_dosen = $_POST['alamat_dosen'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $ttl = $_POST['ttl'];
    $agama = $_POST['agama'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];
    $id_prodi = $_POST['prodi'];
    $password = $_POST['password'];

    // Buat user secara otomatis
    $username = strtolower(str_replace(' ', '_', $nama_dosen)); // Username dari nama dosen
    // $password = $password; // Password default
    $level = 'dosen'; // Level user dosen

    // Memulai transaksi
    DB->begin_transaction();

    try {
        // Insert ke tabel User
        $sql_user = "INSERT INTO User (Nama_User, Username, Password, Level, No_HP) VALUES ('$nama_dosen','$nama_dosen''$username', sha2('$password',256), '$level', '$telp')";
        if (!DB->query($sql_user)) {
            throw new Exception("Error inserting into User: " . DB->error);
        }

        // Ambil ID_User yang baru saja dibuat
        $id_user = DB->insert_id;

        // Insert ke tabel Dosen
        $sql_dosen = "INSERT INTO Dosen (NIP, Nama_Dosen, Alamat_Dosen, Jenis_Kelamin_Dosen, ID_Prodi, ID_User, ttl, agama, email, telp) 
                      VALUES ('$nip', '$nama_dosen', '$alamat_dosen', '$jenis_kelamin', '$id_prodi', '$id_user', '$ttl', '$agama', '$email', '$telp')";
        
        if (!DB->query($sql_dosen)) {
            throw new Exception("Error inserting into Dosen: " . DB->error);
        }

        // Commit transaksi jika semua berhasil
        DB->commit();
        header('Location: index_akundosen.php');
        exit();
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB->rollback();
        echo "Error: " . $e->getMessage();
    }
}
    // $DB->close();

// $Nama_Prodi = get_prodi_from_ID_Prodi($nama_prodi);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="../css/style_kelola_tambah_dosen.css">
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
                <h2>Tambah Data Dosen</h2>
                <form id="dosenForm" action="index_kelola_tambah_dosen.php" method="POST">
                    <div class="form-group">
                    <label for="nip">NIP:</label>
                    <input type="number" id="nip" name="nip" required><br><br>

                    <label for="nama_dosen">Nama Dosen:</label>
                    <input type="text" id="nama_dosen" name="nama_dosen" required><br><br>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br><br>

                    <label for="alamat_dosen">Alamat Dosen:</label>
                    <textarea id="alamat_dosen" name="alamat_dosen" required></textarea><br><br>

                    <label for="jenis_kelamin">Jenis Kelamin Dosen:</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="L">L</option>
                        <option value="P">P</option>
                    </select><br><br>

                    <label for="ttl">Tanggal Lahir:</label>
                    <input type="date" id="ttl" name="ttl" required><br><br>

                    <label for="agama">Agama:</label>
                    <input type="text" id="agama" name="agama" required><br><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br><br>

                    <label for="telp">No HP:</label>
                    <input type="text" id="telp" name="telp" required pattern="\d{12}" title="Harus 12 digit angka"><br><br>

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
                    </select><br><br>
                    <div class="form-buttons">
                        <button type="submit" class="btn-add">Tambah</button>
                        <a href="index_akundosen.php"><button type="button" class="btn-cancel">Batal</button></a>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <script src="../js/index_kelola_tambah_dosen.js"></script>
</body>
</html>