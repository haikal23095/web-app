<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
}

include_once($_SERVER["DOCUMENT_ROOT"] . "../config.php");
include_once(BASEPATH .  "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'mahasiswa') {
    header("Location: ../loginpage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="../css/cetak_transkrip.css">
</head>
<body>
    <div class="container-cetak">
        <!-- Main Content -->
        <main class="main-content-cetak">
            <!-- Header -->
            <header class="header-cetak">
                <table>
                    <tr>
                        <td><img src="../assets/img/logo_utm.png" alt="" class="logo-utm"></td>
                    </tr>
                    <tr>
                        <td class="univ">Universitas Trunojoyo Madura</td>
                    </tr>
                    <tr>
                        <td><hr></td>
                    </tr>
                </table>
            </header>
            <div class="transkrip-nilai">
                <table>
                    <tr>
                        <td>TRANSKRIP AKADEMIK</td>
                    </tr>
                    <tr>
                        <td><hr></td>
                    </tr>
                </table>
            </div>
            <div class="content-grid-cetak">
                <!-- Profil -->
                <div class="user-profile-transkrip-nilai-cetak">
                    <table>
                        <tr>
                            <th colspan="2">Sementara</th>
                        </tr>
                        <tr>
                            <td>Diberikan Kepada</td>
                            <td>: <?= get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['Nama_Mahasiswa']; ?></td>
                        </tr>
                        <tr>
                            <td>Tempat dan Tanggal Lahir</td>
                            <td>: UNKNOWN</td>
                        </tr>
                        <tr>
                            <td>Nomor Induk Mahasiswa</td>
                            <td>: <?= get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['NIM'] ; ?></td>
                        </tr>
                        <tr>
                            <td>Fakultas</td>
                            <td>: TEKNIK</td>
                        </tr>
                        <tr>
                            <td>Program Studi</td>
                            <td>: <?= get_prodi_from_ID_Prodi(get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['ID_Prodi'])['Nama_Prodi']; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lulus</td>
                            <td>: 0</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                : Terakreditasi berdasarkan Surat Keputusan Badan 
                                Akreditasi Nasional Perguruan Tinggi Departemen Pendidikan Nasional Republik Indonesia.
                                Nomor : 416/SK/BAN-PT/Akred/S/X/2014 , Tanggal : 11-10-2014
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="table-transkrip-nilai-cetak">
                <table border="1">
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Matakuliah</th>
                        <th rowspan="2">Kredit (K)</th>
                        <th colspan="2">Nilai (N)</th>
                        <th rowspan="2">K X N</th>
                    </tr>
                    <tr>
                        <th>Huruf</th>
                        <th>Angka</th>
                    </tr>
                    <tr>
                    <?php 
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
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['Nama_Matakuliah']); ?></td>
                                    <td><?php echo htmlspecialchars($row['SKS_Matakuliah']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Nilai']); ?></td>
                                    <td><?php echo konversi_nilai($row['Nilai']); ?></td>
                                    <td><?php echo htmlspecialchars($kali_nilai); ?></td>
                                </tr>
                                <?php }; 
                        } else { ?>
                                <td colspan="6">Data transkrip tidak ditemukan</td>
                            </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6">Data mahasiswa tidak ditemukan</td>
                        </tr>
                    <?php } ?>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td><b><?php echo get_sks_total_transkrip(get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['NIM'])['TotalSKS']; ?></b></td>
                        <td colspan="2"></td>
                        <td><b><?= $total_kali_nilai; ?></b></td>
                    </tr>
                    <tr style="text-align: left;">
                        <td colspan="2">Judul Skripsi</td>
                        <td colspan="4">: </td>
                    </tr>
                    <tr style="text-align: left;">
                        <td colspan="2">IPK</td>
                        <td colspan="4">: <?php echo number_format($total_kali_nilai/ get_sks_total_transkrip(get_mahasiswa_from_id_user($_SESSION['user']['ID_User'])['NIM'])['TotalSKS'], 2); ?></td>
                    </tr>
                    <tr style="text-align: left;">
                        <td colspan="2">Predikat</td>
                        <td colspan="4">: </td>
                    </tr>
                </table>
            </div>
            <br><br>
            <div class="new-content-grid-cetak">
                <div class="ttd">
                    <table>
                        <tr>
                            <td>Tempat, Tanggal</td>
                        </tr>
                        <tr>
                            <td><br><br><br></td>
                        </tr>
                        <tr>
                            <td>Nama Dosen</td>
                        </tr>
                        <tr>
                            <td><hr></td>
                        </tr>
                        <tr>
                            <td>NIP: Dosen</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="footer">
                <table>
                    <tr>
                        <td>Salinan Nilai Ini Sah dan Benar bila tanpa coretan dan Tip-Ex</td>
                    </tr>
                </table>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
