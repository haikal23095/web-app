<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../loginpage.php");
    exit();
}

include_once($_SERVER["DOCUMENT_ROOT"] . "../config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'dosen') {
    header("Location: ../loginpage.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && isset($_POST['NIM'])) {
        $nim = $_POST['NIM'];
        $action = $_POST['action'];

        $nim = mysqli_real_escape_string(DB, $nim);

        if ($action == 'validasi') {
            $query = "UPDATE Mahasiswa_Perwalian SET status_krs = 'valid' WHERE NIM = ?";
            $stmt = mysqli_prepare(DB, $query);
            mysqli_stmt_bind_param($stmt, 's', $nim);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $_SESSION['message'] = "KRS berhasil divalidasi.";
            } else {
                $_SESSION['message'] = "Terjadi kesalahan saat validasi KRS.";
            }
            $stmt->close();
        } elseif ($action == 'unvalidasi') {
            $query = "UPDATE Mahasiswa_Perwalian SET status_krs = 'unvalid' WHERE NIM = ?";
            $stmt = mysqli_prepare(DB, $query);
            mysqli_stmt_bind_param($stmt, 's', $nim);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $_SESSION['message'] = "KRS berhasil di-unvalidasi.";
            } else {
                $_SESSION['message'] = "Terjadi kesalahan saat unvalidasi KRS.";
            }
            $stmt->close();
        } else {
            $_SESSION['message'] = "Aksi tidak dikenali.";
        }
    } else {
        $_SESSION['message'] = "Data tidak lengkap.";
    }

    header("Location: val-krs-dosen.php");
    exit();
}
?>