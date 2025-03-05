<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH . "/database.php");

if ($_SESSION['Level'] != 'mahasiswa') {
    header("Location: ../loginpage.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['user']['ID_User'];
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    if ($password_baru !== $konfirmasi_password) {
        $error_message = "Password baru dan konfirmasi tidak cocok.";
    } else {
        // Verifikasi password lama
        $query = "SELECT Password FROM User WHERE ID_User = ?";
        $stmt = mysqli_prepare(DB, $query);
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $stmt->bind_result($password_hash);
        $stmt->fetch();
        $stmt->close();

        // Bandingkan hash password lama dengan input
        $password_lama_hashed = hash('sha256', $password_lama);
        if ($password_hash !== $password_lama_hashed) {
            $error_message = "Password lama tidak sesuai.";
        } else {
            // Update password baru
            $password_baru_hashed = hash('sha256', $password_baru);
            $update_query = "UPDATE User SET Password = ? WHERE ID_User = ?";
            $update_stmt = mysqli_prepare(DB, $update_query);
            $update_stmt->bind_param("si", $password_baru_hashed, $id_user);
            if ($update_stmt->execute()) {
                $success_message = "Password berhasil diubah.";
            } else {
                $error_message = "Terjadi kesalahan saat mengubah password.";
            }
            $update_stmt->close();
        }
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
    <link rel="stylesheet" href="../css/ubah-password.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-section">
                <div class="avatar"></div>
                <p>mahasiswa - <?= $_SESSION['user']['Username'] ?></p>
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
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>UBAH PASSWORD AKUN MAHASISWA</h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')"><button class="logout-btn">Log Out</button></a>  
            </div>

            <!-- Keterangan -->
            <div class="keterangan">
                <p>
                    <strong>Keterangan</strong>
                    <span class="arrow">▶</span>
                </p>
                <p>
                    Ubah Password dapat digunakan untuk merubah password lama menjadi password baru. <br>
                    Jika anda lupa password anda, silahkan menghubungi bagian akademik untuk mendapatkan password baru.
                </p>
            </div>

            <div class="form-ubah-password">
                <h2>Form ubah password</h2>
                <form method="POST">
                    <table>
                        <tr>
                            <td>Password Lama</td>
                            <td><input type="password" name="password_lama" placeholder="Masukkan password lama" required></td>
                        </tr>
                        <tr>
                            <td>Password Baru</td>
                            <td><input type="password" name="password_baru" placeholder="Masukkan password baru" required></td>
                        </tr>
                        <tr>
                            <td>Tulis Ulang Password Baru</td>
                            <td><input type="password" name="konfirmasi_password" placeholder="Ulangi password baru" required></td>
                        </tr>
                    </table>
                    <button type="submit" class="submit-button">Simpan</button>
                    <?php if (isset($error_message)) : ?>
                        <p class="error"><?= $error_message ?></p>
                    <?php elseif (isset($success_message)) : ?>
                        <p class="success"><?= $success_message ?></p>
                    <?php endif; ?>
                </form>
            </div>

        </div>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>
