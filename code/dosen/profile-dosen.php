<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "../config.php");
include_once(BASEPATH .  "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'dosen') {
    header("Location: ../loginpage.php");
    exit();
}

$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/profiles/';

if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("Gagal membuat folder untuk menyimpan foto.");
    }
}

$photoPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/profiles/" . $_SESSION['user']['Username'] . ".jpg";
$defaultPhoto = "../assets/img/fot.jpg";
$userPhoto = file_exists($photoPath) ? "/uploads/profiles/" . $_SESSION['user']['Username'] . ".jpg?" . time() : $defaultPhoto;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $photo = $_FILES['photo'];
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $photoExtension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));

    if (in_array($photoExtension, $allowedExtensions)) {
        $targetFile = $uploadDir . $_SESSION['user']['Username'] . '.jpg';
        if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
            $userPhoto = "/uploads/profiles/" . $_SESSION['user']['Username'] . ".jpg?" . time();
            echo "<script>alert('Foto berhasil diubah!');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat meng-upload foto.');</script>";
        }
    } else {
        echo "<script>alert('Hanya file JPG, JPEG, atau PNG yang diperbolehkan!');</script>";
    }
}

$idUser = $_SESSION['user']['ID_User'];
$sql = "SELECT d.*, p.Nama_Prodi AS prodi, f.Nama_Fakultas AS fakultas 
        FROM Dosen d
        LEFT JOIN Prodi p ON d.ID_Prodi = p.ID_Prodi
        LEFT JOIN Fakultas f ON p.ID_Fakultas = f.ID_Fakultas
        WHERE d.ID_User = ?";
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

$stmt->close();
DB->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akademik UTM</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile-dosen.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
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

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>PROFILE DOSEN</h1>
                <button id="hamburger" class="hamburger">&#9776;</button>
                <a href="../logout.php" class="logout" onclick="return confirm('apakah anda yakin ingin logout')">
                    <button class="logout-btn">Log Out</button>
                </a>  
            </header>
            <div class="wrap">
                <div class="foto">
                    <ul>
                        <li><img src="<?= $userPhoto ?>" alt="Foto Profil" id="profilePhoto"></li>
                        <li>
                            <form action="profile-dosen.php" method="POST" enctype="multipart/form-data" class="file-upload-container">
                                <label for="photoUpload" id="uploadLabel">Change Foto</label>
                                <input type="file" name="photo" id="photoUpload" accept="image/jpeg, image/png" onchange="previewAndSubmit(event)">
                            </form>
                        </li>
                        <li><p>*Ubah foto sesuai dengan ketentuan*</p></li>
                    </ul>
                </div>

                <div class="kolom">
                    <table >
                        <tr>
                            <th>Data Utama ▷</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td class="depan">NIP</td>
                            <td>: <?= htmlspecialchars($dosen['NIP']) ?></td>
                        </tr>
                        <tr>
                            <td class="depan">Nama</td>
                            <td>: <?= htmlspecialchars($dosen['Nama_Dosen']) ?></td>
                        </tr>
                        <tr>
                            <td class="depan">Tempat Tanggal Lahir</td>
                            <td>: <?= htmlspecialchars($dosen['ttl']) ?></td>
                        </tr>
                        <tr>
                            <td class="depan">Prodi</td>
                            <td>: <?= htmlspecialchars($dosen['prodi']) ?></td>
                        </tr>
                        <tr>
                            <td class="depan">Fakultas</td>
                            <td>: <?= htmlspecialchars($dosen['fakultas']) ?></td>
                        </tr>
                    </table>
                </div>
            </div>


            <div class="kolom">
                <table>
                    <tr>
                        <th>Data Tambahan ▷</th>
                        <th></th>
                    </tr>
                    <tr>
                        <td class="depan">Jenis Kelamin</td>
                        <td>: <?= $dosen['Jenis_Kelamin_Dosen'] == 'L' ? 'Laki-Laki' : 'Perempuan' ?></td>
                    </tr>
                    <tr>
                        <td class="depan">Agama</td>
                        <td>: <?= htmlspecialchars($dosen['agama']) ?></td>
                    </tr>
                    <tr>
                        <td class="depan">e-mail</td>
                        <td>: <?= htmlspecialchars($dosen['email']) ?></td>
                    </tr>
                    <tr>
                        <td class="depan">Alamat</td>
                        <td>: <?= htmlspecialchars($dosen['Alamat_Dosen']) ?></td>
                    </tr>
                    <tr>
                        <td class="depan">Telp</td>
                        <td>: <?= htmlspecialchars($dosen['telp']) ?></td>
                    </tr>
                </table>
            </div>
        </main>
    </div>

    <script src="../js/profile-dosen.js">
        function previewAndSubmit(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePhoto').src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Auto-submit the form
                const form = event.target.closest('form');
                setTimeout(() => {
                    form.submit();
                }, 500); // Delay to ensure the preview updates
            }
        }
    </script>
</body>
</html>