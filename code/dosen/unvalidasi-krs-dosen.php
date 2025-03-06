<?php
session_start();

// Include necessary files
include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

// Ensure the user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: /loginpage.php");
    exit();
}

// Check if the action and NIM are set
if (isset($_POST['action']) && isset($_POST['NIM'])) {
    $nim = $_POST['NIM'];
    $action = $_POST['action'];

    // Make sure NIM is properly sanitized
    $nim = mysqli_real_escape_string(DB, $nim);

    if ($action == 'unvalidasi') {
        // Update the Mahasiswa_Perwalian table to set status_krs as 'unvalid'
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

// Redirect back to the validation page
header("Location: val-krs-dosen.php");
exit();