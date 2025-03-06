<?php
$page = "krs-awal";
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

// $data_prodi = get_prodi_from_ID_Prodi($id_prodi);
$data_krs = get_data_matkul_krs();

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link rel="stylesheet" href="../css/style_krs_awal.css">
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
        <main>
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <button id="hamburger" class="hamburger">&#9776;</button> <!-- Tombol Hamburger -->
                <h1>Kartu Rencana Studi</h1>
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')" >Log Out</a>  
            </header>
            <section class="welcome-message">
                <p>
                    Informasi Matakuliah Ditawarkan berisi seluruh matakuliah yang ditawarkan pada semester aktif. Dari seluruh matakuliah yang terdapat pada daftar, setiap matakuliah mempunyai aturan tersendiri bergantung pada program studi, kurikulum, dan aturan akademik lainnya. Untuk lebih jelasnya, anda dapat melihat detail kelas
                </p>
            </section>
            <!-- plih program studi -->
            <form action="" method="POST" id="prodi">
                <label for="opt-prodi">Program Studi</label>
                <select name="opt-prodi" id="opt-prodi">
                    <option value="0">Pilih Program Studi</option>
                    <?php
                        $get_prodi = get_program_studi();
                        if ($get_prodi->num_rows > 0) {
                            while ($row = $get_prodi->fetch_assoc()) {
                                echo "<option value='" . $row['ID_Prodi'] . "'>" . $row['Nama_Prodi'] . "</option>";
                            }
                        }
                    ?>
                </select>
                <button type="submit" name="submit-prodi">Lihat</button>
            </form>
            <!-- Paket matakuliah setiap semester -->
            <ul class="paket-semester">
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 1</span>
                    <table border="1" class="table-matakuliah">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>SKS</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($data_krs as $val): ?>
                                <?php if ($val['Semester_Matakuliah'] == 1): ?>

                                    <tr>
                                        <td><?= $no++;?></td>
                                        <td><?= htmlspecialchars($val['Kode_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['Nama_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['SKS_Matakuliah']) ?></td>
                                        <td class="tombol_aksi">
                                            <a href="../admin/index_kelola_edit_dosen.php"><button class="add">Edit</button></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="index_krs_tambahdata.php"><button class="add">Tambah</button></a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 2</span>
                    <table border="1" class="table-matakuliah">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>SKS</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($data_krs as $val): ?>
                                <?php if ($val['Semester_Matakuliah'] == 2): ?>

                                    <tr>
                                        <td><?= $no++;?></td>
                                        <td><?= htmlspecialchars($val['Kode_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['Nama_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['SKS_Matakuliah']) ?></td>
                                        <td class="tombol_aksi">
                                            <a href="../admin/index_kelola_edit_dosen.php"><button class="add">Edit</button></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="index_krs_tambahdata.php"><button class="add">Tambah</button></a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 3</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>SKS</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($data_krs as $val): ?>
                                <?php if ($val['Semester_Matakuliah'] == 3): ?>

                                    <tr>
                                        <td><?= $no++;?></td>
                                        <td><?= htmlspecialchars($val['Kode_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['Nama_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['SKS_Matakuliah']) ?></td>
                                        <td class="tombol_aksi">
                                            <a href="../admin/index_kelola_edit_dosen.php"><button class="add">Edit</button></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="index_krs_tambahdata.php"><button class="add">Tambah</button></a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 4</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>SKS</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($data_krs as $val): ?>
                                <?php if ($val['Semester_Matakuliah'] == 4): ?>

                                    <tr>
                                        <td><?= $no++;?></td>
                                        <td><?= htmlspecialchars($val['Kode_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['Nama_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['SKS_Matakuliah']) ?></td>
                                        <td class="tombol_aksi">
                                            <a href="../admin/index_kelola_edit_dosen.php"><button class="add">Edit</button></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="index_krs_tambahdata.php"><button class="add">Tambah</button></a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 5</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>SKS</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($data_krs as $val): ?>
                                <?php if ($val['Semester_Matakuliah'] == 5): ?>

                                    <tr>
                                        <td><?= $no++;?></td>
                                        <td><?= htmlspecialchars($val['Kode_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['Nama_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['SKS_Matakuliah']) ?></td>
                                        <td class="tombol_aksi">
                                            <a href="../admin/index_kelola_edit_dosen.php"><button class="add">Edit</button></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="index_krs_tambahdata.php"><button class="add">Tambah</button></a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 6</span>
                    <table border="1" class="table-matakuliah">
                    <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>SKS</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($data_krs as $val): ?>
                                <?php if ($val['Semester_Matakuliah'] == 6): ?>

                                    <tr>
                                        <td><?= $no++;?></td>
                                        <td><?= htmlspecialchars($val['Kode_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['Nama_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['SKS_Matakuliah']) ?></td>
                                        <td class="tombol_aksi">
                                            <a href="../admin/index_kelola_edit_dosen.php"><button class="add">Edit</button></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="index_krs_tambahdata.php"><button class="add">Tambah</button></a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 7</span>
                    <table border="1" class="table-matakuliah">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>SKS</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($data_krs as $val): ?>
                                <?php if ($val['Semester_Matakuliah'] == 7): ?>

                                    <tr>
                                        <td><?= $no++;?></td>
                                        <td><?= htmlspecialchars($val['Kode_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['Nama_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['SKS_Matakuliah']) ?></td>
                                        <td class="tombol_aksi">
                                            <a href="../admin/index_kelola_edit_dosen.php"><button class="add">Edit</button></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="index_krs_tambahdata.php"><button class="add">Tambah</button></a>
                    </div>
                </li>
                <li>
                    <span class="dropdown-matakuliah">&#9655</span><span>Paket Semester 8</span>
                    <table border="1" class="table-matakuliah">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Kode</td>
                                <td>Matakuliah</td>
                                <td>SKS</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; foreach ($data_krs as $val): ?>
                                <?php if ($val['Semester_Matakuliah'] == 8): ?>

                                    <tr>
                                        <td><?= $no++;?></td>
                                        <td><?= htmlspecialchars($val['Kode_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['Nama_Matakuliah']) ?></td>
                                        <td><?= htmlspecialchars($val['SKS_Matakuliah']) ?></td>
                                        <td class="tombol_aksi">
                                            <a href="../admin/index_kelola_edit_dosen.php"><button class="add">Edit</button></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="actions">
                        <a href="index_krs_tambahdata.php"><button class="add">Tambah</button></a>
                    </div>
                </li>
                
            </ul>
            
        </main>
    </div>

    <script src="../js/script_krs_awal.js"></script>
</body>
</html>
