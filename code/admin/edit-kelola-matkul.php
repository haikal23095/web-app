<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: /loginpage.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] !== 'admin') {
    header("Location: /loginpage.php");
    exit();
}

$prodi = 0;
if (isset($_POST['submit-prodi'])) {
    $prodi = $_POST['opt-prodi'];
}

// Mendapatkan ID dari query string
$id = $_GET['id'] ?? '';

if ($id) {
    // Ambil data mata kuliah berdasarkan ID
    $query = "SELECT * FROM Matakuliah WHERE ID_Matakuliah = ?";
    $stmt = DB->prepare($query);

    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Data tidak ditemukan.";
            exit;
        }
    } else {
        echo "Terjadi kesalahan pada query.";
        exit;
    }
} else {
    echo "ID tidak valid.";
    exit();
}

// Proses form update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $prasyarat = $_POST['prasyarat'];
    $semester = $_POST['semester'];
    $sks = $_POST['sks'];

    // Validasi dan update data
    $query = "UPDATE Matakuliah 
              SET Kode_Matakuliah = ?, Nama_Matakuliah = ?, Prasyarat_Matakuliah = ?, Semester_Matakuliah = ?, SKS_Matakuliah = ? 
              WHERE ID_Matakuliah = ?";
    $stmt = DB->prepare($query);

    if ($stmt) {
        $stmt->bind_param('ssiiii', $kode, $nama, $prasyarat, $semester, $sks, $id);

        if ($stmt->execute()) {
            header('Location: kelola-matkul.php?status=success');
            exit;
        } else {
            echo "Gagal memperbarui data.";
        }
    } else {
        echo "Terjadi kesalahan pada query.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Kuliah</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            padding: 20px;
        }

        .header h1 {
            font-size: 1.8rem;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        form div {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], 
        input[type="number"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        input[type="text"]:focus, 
        input[type="number"]:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            .header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>Edit Mata Kuliah</h1>
            </header>

            <!-- Display Status -->
            <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
                <p style="color: green; text-align: center; font-weight: bold;">Data berhasil diperbarui!</p>
            <?php endif; ?>

            <!-- Edit Form -->
            <form action="edit-kelola-matkul.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
                <div>
                    <label for="kode">Kode</label>
                    <input type="text" name="kode" id="kode" value="<?php echo htmlspecialchars($row['Kode_Matakuliah']); ?>" required>
                </div>

                <div>
                    <label for="nama">Nama Mata Kuliah</label>
                    <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($row['Nama_Matakuliah']); ?>" required>
                </div>

                <div>
                    <label for="prasyarat">Prasyarat</label>
                    <input type="text" name="prasyarat" id="prasyarat" value="<?php echo ($row['Prasyarat_Matakuliah']); ?>" required>
                </div>

                <div>
                    <label for="semester">Semester</label>
                    <input type="number" name="semester" id="semester" value="<?php echo htmlspecialchars($row['Semester_Matakuliah']); ?>" required>
                </div>

                <div>
                    <label for="sks">SKS</label>
                    <input type="number" name="sks" id="sks" value="<?php echo htmlspecialchars($row['SKS_Matakuliah']); ?>" required>
                </div>

                <button type="submit" name="submit">Update</button>
            </form>
        </main>
    </div>
</body>
</html>