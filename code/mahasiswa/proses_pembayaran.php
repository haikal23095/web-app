<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: /loginpage.php");
}

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

if ($_SESSION['Level'] != 'mahasiswa') {
    header("Location: /loginpage.php");
    exit();
}

require_once '../vendor/autoload.php'; // Library Midtrans, pastikan sudah diinstal via Composer

// Fungsi untuk menangani transaksi baru
function processTransaction()
{
    $order_id = $_POST['order_id'];
    $gross_amount = $_POST['amount'];

    // Data pelanggan (sesuaikan dengan data user Anda)
    $customer_details = array(
        'first_name' => 'Wiwik',
        'last_name' => 'Ainun Janah',
        'email' => 'wiwik@example.com',
        'phone' => '08123456789'
    );

    // Data transaksi
    $transaction = array(
        'transaction_details' => array(
            'order_id' => $order_id,
            'gross_amount' => $gross_amount
        ),
        'customer_details' => $customer_details
    );

    try {
        // Buat URL pembayaran Snap
        $paymentUrl = \Midtrans\Snap::createTransaction($transaction)->redirect_url;

        // Redirect pengguna ke URL pembayaran
        header("Location: $paymentUrl");
        exit();
    } catch (Exception $e) {
        echo 'Terjadi kesalahan: ' . $e->getMessage();
        exit();
    }
}

// Fungsi untuk menangani notifikasi dari Midtrans
function handleNotification()
{
    $json = file_get_contents('php://input');
    $notification = json_decode($json);

    if ($notification) {
        $order_id = $notification->order_id;
        $transaction_status = $notification->transaction_status;
        $status = ''; // Default empty status

        if ($transaction_status === 'settlement') {
            // Pembayaran sukses
            $status = 'Success';
            file_put_contents('log.txt', "Order ID: $order_id - Pembayaran berhasil\n", FILE_APPEND);
        } elseif ($transaction_status === 'pending') {
            // Pembayaran pending
            $status = 'Pending';
            file_put_contents('log.txt', "Order ID: $order_id - Pembayaran pending\n", FILE_APPEND);
        } elseif ($transaction_status === 'expire' || $transaction_status === 'cancel') {
            // Pembayaran gagal atau kadaluarsa
            $status = 'Failed';
            file_put_contents('log.txt', "Order ID: $order_id - Pembayaran gagal/kadaluarsa\n", FILE_APPEND);
        }

        // Ambil data pembayaran dari notifikasi
        $nim = $_SESSION['user']['NIM']; // NIM dari session
        $amount = $notification->gross_amount;
        $tanggal_pembayaran = date("Y-m-d"); // Tanggal hari ini
        $id_metode_pembayaran = rand(1, 99999); // ID metode pembayaran, bisa disesuaikan

        // Simpan data pembayaran ke tabel Pembayaran_UKT jika status pembayaran sukses
        if ($status === 'Success') {
            $query = "
                INSERT INTO Pembayaran_UKT (NIM, Jumlah_Pembayaran, Tanggal_Pembayaran, ID_Metode_Pembayaran, Status_Pembayaran)
                VALUES (?, ?, ?, ?, ?)
            ";

            // Prepared statement untuk keamanan
            $stmt = mysqli_prepare(DB, $query);
            mysqli_stmt_bind_param($stmt, "iisds", $nim, $amount, $tanggal_pembayaran, $id_metode_pembayaran, $status);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                file_put_contents('log.txt', "Pembayaran untuk Order ID: $order_id berhasil disimpan.\n", FILE_APPEND);
            } else {
                file_put_contents('log.txt', "Gagal menyimpan pembayaran untuk Order ID: $order_id. Error: " . mysqli_error(DB) . "\n", FILE_APPEND);
            }

            // Tutup koneksi
            mysqli_stmt_close($stmt);
        }

        // Berikan respons ke Midtrans
        http_response_code(200);
        echo "OK";
        exit();
    } else {
        http_response_code(400);
        echo "Bad Request";
        exit();
    }
}

// Logika utama untuk memisahkan transaksi baru dan notifikasi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Jika data berasal dari form pembayaran
    if (isset($_POST['order_id']) && isset($_POST['amount'])) {
        processTransaction();
    } else {
        // Jika data berasal dari notifikasi Midtrans
        handleNotification();
    }
} else {
    echo "Metode tidak didukung.";
    exit();
}
?>
