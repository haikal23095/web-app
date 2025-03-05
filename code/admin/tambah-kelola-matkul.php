<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "../config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] !== 'admin') {
    header("Location: ../loginpage.php");
    exit();
}

$prodi = 0;
if (isset($_POST['submit-prodi'])) {
    $prodi = $_POST['opt-prodi'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Nama_Matakuliah = htmlspecialchars(trim($_POST['Nama_Matakuliah']));
    $Kode_Matakuliah = htmlspecialchars(trim($_POST['kode_matkul']));
    $Semester_Matakuliah = filter_var($_POST['semester'], FILTER_VALIDATE_INT);
    $SKS_Matakuliah = filter_var($_POST['Bobot_SKS'], FILTER_VALIDATE_INT);
    $Prasyarat_Matakuliah = htmlspecialchars(trim($_POST['Prasyarat_Matakuliah'])) ?: NULL;
    $ID_Prodi = (int)$prodi;

    if (!$Nama_Matakuliah || !$Kode_Matakuliah || !$Semester_Matakuliah || !$SKS_Matakuliah || !is_int($Semester_Matakuliah) || !is_int($SKS_Matakuliah)) {
        echo "<script>alert('Data tidak valid. Harap isi semua bidang dengan benar.');</script>";
    } elseif ($ID_Prodi === 0) {
        echo "<script>alert('Harap pilih Program Studi yang valid.');</script>";
    } else {
        $sql = "INSERT INTO Matakuliah (Kode_Matakuliah, Nama_Matakuliah, Prasyarat_Matakuliah, Semester_Matakuliah, SKS_Matakuliah, ID_Prodi)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = DB->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssiiii", $Kode_Matakuliah, $Nama_Matakuliah, $Prasyarat_Matakuliah, $Semester_Matakuliah, $SKS_Matakuliah, $ID_Prodi);

            if ($stmt->execute()) {
                echo "<script>alert('Data Mata Kuliah berhasil disimpan'); window.location = 'kelola-matkul.php';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat menyimpan data: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Terjadi kesalahan, perintah gagal disiapkan.');</script>";
        }
    }

    DB->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Kuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 26px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        label {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 16px;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: #f9f9f9;
        }
        input[type="text"]:focus, input[type="number"]:focus, select:focus {
            border-color: #4CAF50;
            outline: none;
        }
        .btn {
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            width: 45%;
        }
        .simpan {
            background-color: #4CAF50;
            color: white;
            border: none;
            margin-right: 5%;
        }
        .simpan:hover {
            background-color: #45a049;
        }
        .batal {
            background-color: #f44336;
            color: white;
            border: none;
        }
        .batal:hover {
            background-color: #e53935;
        }
        .clearfix {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Tambah Mata Kuliah</h1>
    <form action="" method="post">
        <label for="Nama_Matakuliah">Nama Mata Kuliah:</label>
        <input type="text" id="Nama_Matakuliah" name="Nama_Matakuliah" required>

        <label for="kode_matkul">Kode Mata Kuliah:</label>
        <input type="text" id="kode_matkul" name="kode_matkul" required>

        <label for="semester">Semester:</label>
        <input type="number" id="semester" name="semester" required>

        <label for="Bobot_SKS">Bobot SKS:</label>
        <input type="number" id="Bobot_SKS" name="Bobot_SKS" required>

        <label for="Prasyarat_Matakuliah">Prasyarat (Opsional):</label>
        <input type="text" id="Prasyarat_Matakuliah" name="Prasyarat_Matakuliah">

        <label for="opt-prodi">Program Studi</label>
        <select name="opt-prodi" id="opt-prodi" required>
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

        <div class="clearfix">
            <button type="submit" class="btn simpan" name="submit-prodi">Simpan</button>
            <a href="kelola-matkul.php" class="btn batal">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
