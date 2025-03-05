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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_bimbingan'])) {
    $id_bimbingan = intval($_POST['id_bimbingan']);
    
    // Update status to 'Tolak' (Rejected) - this corresponds to 'Tolak' in the status_judul column
    $sql = "UPDATE Mahasiswa_Bimbingan SET status_judul = 'Tolak' WHERE ID_Mahasiswa_Bimbingan = ?";
    $stmt = mysqli_prepare(DB, $sql);
    $stmt->bind_param("i", $id_bimbingan);
    if ($stmt->execute()) {
        $message = "Judul Skripsi berhasil divalidasi sebagai ditolak.";
    } else {
        $message = "Terjadi kesalahan saat memvalidasi.";
    }
    $stmt->close();

    // Redirect back with a message
    header("Location: val-skripsi-dosen.php?message=" . urlencode($message));
    exit();
} else {
    header("Location: val-skripsi-dosen.php?message=" . urlencode("Permintaan tidak valid."));
    exit();
}
?>