<?php
session_start();

// Mengecek apakah pengguna sudah login dan levelnya adalah 'admin'
if (!isset($_SESSION["user"]) || $_SESSION['Level'] != 'admin') {
    header("Location: ../loginpage.php");
    exit();
}

// Menyertakan file konfigurasi dan koneksi ke database
include_once($_SERVER["DOCUMENT_ROOT"] . "../config.php");
include_once(BASEPATH . "/database.php");

// Menampilkan error untuk memudahkan debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mengecek apakah parameter 'id' ada dalam URL
if (isset($_GET['id'])) {
    // Mengambil nilai 'id' dan melakukan sanitasi input
    $id = intval($_GET['id']); 

    // Mengecek apakah ID valid dan ada di dalam tabel
    if ($id > 0) {
        // Query untuk menghapus data berdasarkan ID
        $sql = "DELETE FROM matakuliah WHERE ID_Matakuliah = ?";

        // Menyiapkan statement dan mengecek apakah berhasil
        if ($stmt = DB->prepare($sql)) {
            // Mengikat parameter untuk query
            $stmt->bind_param("i", $id);

            // Menjalankan query dan mengecek hasil eksekusi
            if ($stmt->execute()) {
                // Menampilkan pesan sukses jika data berhasil dihapus
                echo "<script>alert('Data berhasil dihapus'); window.location.href='kelola-matkul.php';</script>";
            } else {
                // Menampilkan pesan kesalahan jika gagal menghapus data
                echo "<script>alert('Terjadi kesalahan saat menghapus data'); window.location.href='kelola-matkul.php';</script>";
            }

            // Menutup statement
            $stmt->close();
        } else {
            // Menampilkan pesan kesalahan jika statement gagal disiapkan
            die("Error in preparing statement: " . DB->error);
        }
    } else {
        // Jika ID tidak valid, kembalikan ke halaman kelola-matkul.php
        header("Location: kelola-matkul.php");
    }
} else {
    // Jika parameter 'id' tidak ada, kembalikan ke halaman kelola-matkul.php
    header("Location: kelola-matkul.php");
}

// Menutup koneksi database
DB->close();
?>
