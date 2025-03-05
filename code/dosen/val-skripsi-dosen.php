<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");

if ($_SESSION['Level'] != 'dosen') {
    header("Location: ../loginpage.php");
    exit();
}

// Fetch lecturer details
$idUser = $_SESSION['user']['ID_User'];
$sql = "SELECT * FROM Dosen WHERE ID_User = ?";
$stmt = mysqli_prepare(DB, $sql);
$stmt->bind_param("i", $idUser);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $dosen = $result->fetch_assoc();
} else {
    echo "Data dosen tidak ditemukan.";
    exit();
}

$nip_dosen = $dosen['NIP'];
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/val-skripsi-dosen.css">
</head>
<body>
    <div class="container">
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
        <main class="main-content">
            <header class="header">
                <h1>VALIDASI Judul Skripsi</h1>
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')">
                    <button class="logout-btn">Log Out</button>
                </a>
            </header>
            <div class="description">
                <h3>Keterangan ▷</h3>
                <p>Validasi pengajuan Judul Skripsi yang akan diambil oleh mahasiswa.</p>
            </div>
            <table>
                <tr>
                    <th>No.</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Judul Skripsi</th>
                    <th colspan="2">Validasi</th>
                    <th>Status</th>
                </tr>
                <?php
                $query = "SELECT mb.ID_Mahasiswa_Bimbingan, mb.Nama_Mahasiswa_Bimbingan, mb.Judul_Skripsi, mb.NIM, mb.status_judul 
                          FROM Mahasiswa_Bimbingan mb 
                          WHERE mb.NIP = ?";
                $stmt = mysqli_prepare(DB, $query);
                $stmt->bind_param("i", $nip_dosen);
                $stmt->execute();
                $result = $stmt->get_result();

                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['NIM']}</td>
                            <td>{$row['Nama_Mahasiswa_Bimbingan']}</td>
                            <td>{$row['Judul_Skripsi']}</td>
                            <td>
                                <form method='POST' action='accept_skripsi_dosen.php'>
                                    <input type='hidden' name='id_bimbingan' value='{$row['ID_Mahasiswa_Bimbingan']}'>
                                    <button type='submit' class='accept'>Accept</button>
                                </form>
                            </td>
                            <td>
                                <form method='POST' action='tolak_skripsi_dosen.php'>
                                    <input type='hidden' name='id_bimbingan' value='{$row['ID_Mahasiswa_Bimbingan']}'>
                                    <button type='submit' class='reject'>Tolak</button>
                                </form>
                            </td>
                            <td>{$row['status_judul']}</td>
                          </tr>";
                    $no++;
                }
                ?>
            </table>
        </main>
    </div>
</body>
</html>
