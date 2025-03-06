<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: /loginpage.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'dosen') {
    header("Location: /loginpage.php");
    exit();
}

// Ambil data dosen berdasarkan ID_User dari sesi
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

$nip_dosen = $dosen['NIP']; // Assign the NIP of the logged-in lecturer

// Don't close DB connection here yet.
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/val-krs-dosen.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile-section">
                <div class="avatar"></div>
                <p>Dosen - <?= $_SESSION['user']['Username']  ?></p>
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
                <h1>VALIDASI Kartu Rencana Studi</h1>
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <a href="../logout.php" class="logout" onclick="return confirm('Apakah Anda yakin ingin logout?')"><button class="logout-btn">Log Out</button></a>  
            </header>

            <!-- Keterangan -->
            <div class="description">
                <h3>Keterangan ▷</h3>
                <p>Validasi pengajuan Jadwal KRS yang akan diambil oleh mahasiswa.</p>
            </div>

            <!-- Nama Mahasiswa -->
            <table>
                <tr>
                    <th>No.</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Semester</th>
                    <th>Kode Dosen Wali</th>
                    <th>Detail</th>
                    <th colspan="2">Validasi</th>
                    <th>Status</th>
                </tr>
                <?php
                    $query = "SELECT * FROM Mahasiswa_Perwalian WHERE NIP = ?";
                    $stmt = mysqli_prepare(DB, $query);
                    mysqli_stmt_bind_param($stmt, 'i', $nip_dosen);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result && $result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['NIM']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Nama_Mahasiswa_Perwalian']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Semester']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['NIP']) . "</td>"; 
                            echo "<td>
                                    <form method='GET' action='cetak_krs.php'>
                                        <input type='hidden' name='nim' value='" . htmlspecialchars($row['NIM']) . "'>
                                        <button type='submit'>Lihat</button>
                                    </form>
                                </td>";  
                            echo "<td>
                                    <form method='POST' action='validasi-krs-dosen.php'>
                                        <input type='hidden' name='NIM' value='" . htmlspecialchars($row['NIM']) . "'>
                                        <button class='validasi' name='action' value='validasi'>Validasi</button>
                                    </form>
                                </td>";
                            echo "<td>
                                    <form method='POST' action='unvalidasi-krs-dosen.php'>
                                        <input type='hidden' name='NIM' value='" . htmlspecialchars($row['NIM']) . "'>
                                        <button class='unvalidasi' name='action' value='unvalidasi'>Unvalidasi</button>
                                    </form>
                                </td>";
                            echo "<td>" . htmlspecialchars($row['Status_KRS']) . "</td>";;
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Tidak ada data untuk divalidasi.</td></tr>";
                    }

                    $stmt->close();
                    DB->close();
                ?>
            </table>
        </main>
    </div>

<script src="../js/val-krs-dosen.js"></script>
</body>
</html>