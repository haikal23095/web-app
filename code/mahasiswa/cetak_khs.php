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

// // // Ambil NIM mahasiswa dari URL atau parameter lainnya
// $nim = isset($_GET['nim']) ? $_GET['nim'] : '';

// // // Query untuk mengambil data mahasiswa
// $sql = "SELECT m.NIM, m.Nama_Mahasiswa, p.Nama_Prodi FROM mahasiswa m INNER JOIN prodi p ON m.ID_Prodi = p.ID_Prodi WHERE m.NIM = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("i", $nim);
// $stmt->execute();
// $result = $stmt->get_result();

// // Periksa apakah data ditemukan
// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     $nama_mahasiswa = $row['Nama_Mahasiswa'];
//     $nim_mahasiswa = $row['NIM'];
//     $prodi = $row['Nama_Prodi'];
// } else {
//     $nama_mahasiswa = "Tidak ditemukan";
//     $nim_mahasiswa = "Tidak ditemukan";
//     $prodi = "Tidak ditemukan";
// }
// $stmt->close();
// $conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="/css/cetak_khs.css">
</head>
<body>
    <div class="container-cetak">
        <!-- Main Content -->
        <main class="main-content-cetak">
            <!-- Header -->
            <header class="header-cetak">
                <table>
                    <tr>
                        <td rowspan="3"><img src="../assets/img/logo_utm.png" alt="" class="logo-utm"></td>
                    </tr>
                    <tr>
                        <td class="univ">Universitas Trunojoyo Madura</td>
                    </tr>
                    <tr>
                        <td class="fakultas">Fakultas Teknik</td>
                    </tr>
                </table>
            </header>
            <div class="khs-semester">
                <table>
                    <tr>
                        <th>Kartu Hasil Studi</th>
                    </tr>
                    <tr>
                        <th>Semester: Gasal 2023/2024</th>
                    </tr>
                </table>
            </div>
            <div class="content-grid-cetak">
                <!-- Profil -->
                <div class="user-profile-cetak-khs">
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
                            <td>Angkatan</td>
                            <td>: ...</td>
                        </tr>
                        <tr>
                            <td>Program Studi</td>
                            <td>: <?= get_prodi_from_ID_Prodi(get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['ID_Prodi'])['Nama_Prodi']; ?></td>
                        </tr>
                        <tr>
                            <td>Dosen PA</td>
                            <td>: ...</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="table-cetak-khs">
                <table border="1">
                    <tr>
                        <th rowspan="2">No</th>
                        <th colspan="2">Matakuliah</th>
                        <th rowspan="2">SKS</th>
                        <th rowspan="2">Nilai</th>
                        <th rowspan="2">Bobot</th>
                        <th rowspan="2">Nilai sks</th>
                    </tr>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                    </tr>
                    <?php if (!empty($data_khs)) : ?>
                        <?php $no = 1; foreach ($data_khs as $khs) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($khs['Kode_Matakuliah']); ?></td>
                                <td><?= htmlspecialchars($khs['Nama_Matakuliah_Transkrip']); ?></td>
                                <td><?= htmlspecialchars($khs['SKS_Transkrip']); ?></td>
                                <td><?= htmlspecialchars($khs['Nilai']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7">Tidak ada data untuk semester ini.</td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="3"><b>Total SKS</b></td>
                        <td><b>0</b></td>
                    </tr>
                </table>
            </div>
            <div class="new-content-grid-cetak">
                <div class="khs-cetak">
                    <table>
                        <tr>
                            <td>IP Semester</td>
                            <td>: 0.00</td>
                        </tr>
                        <tr>
                            <td>IP Kumulatif</td>
                            <td>: <?php echo get_ipk(get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['NIM']) ?></td>
                        </tr>
                        <tr>
                            <td>Maks beban sks semester selanjutnya</td>
                            <td>: 24 sks</td>
                        </tr>
                    </table>
                </div>

                <div class="ttd">
                    <table>
                        <tr>
                            <td>Tempat, Tanggal</td>
                        </tr>
                        <tr>
                            <td>Mengetahui</td>
                        </tr>
                        <tr>
                            <td>Ketua Jurusan Teknik Informatika</td>
                        </tr>
                        <tr>
                            <td><br><br><br></td>
                        </tr>
                        <tr>
                            <td>Nama Ketua Jurusan</td>
                        </tr>
                        <tr>
                            <td>-----------------------------</td>
                        </tr>
                        <tr>
                            <td>NIP</td>
                        </tr>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
