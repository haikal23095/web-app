<?php
// Include dependencies
include_once($_SERVER["DOCUMENT_ROOT"] . "../config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");


// Ambil payload dari Midtrans
$json = file_get_contents('php://input');

// Log payload untuk debugging
file_put_contents('payload_log.txt', "Payload: " . $json . "\n", FILE_APPEND);

// Validasi JSON
if (!$json) {
    http_response_code(400);
    exit("No JSON payload received");
}

$data = json_decode($json, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    exit("Invalid JSON format");
}

// Validasi payload berisi semua kunci yang dibutuhkan
if (!isset($data['order_id'], $data['status_code'], $data['gross_amount'], $data['signature_key'])) {
    http_response_code(400);
    exit("Invalid Payload: Missing required fields");
}

// Validasi Signature Key
$signatureKey = hash('sha512', $data['order_id'] . $data['status_code'] . $data['gross_amount'] . $serverKey);
if ($signatureKey !== $data['signature_key']) {
    http_response_code(403);
    exit("Invalid Signature");
}

// Extract data dari notifikasi Midtrans
$orderID = $data['order_id'];
$nim = extractNIMFromOrderID($orderID); // Buat fungsi untuk mengambil NIM dari order_id
if (!$nim) {
    http_response_code(400);
    exit("Invalid Order ID Format");
}

$jumlahPembayaran = $data['gross_amount'];
$tanggalPembayaran = date('Y-m-d', strtotime($data['transaction_time']));
$metodePembayaran = mapPaymentMethod($data['payment_type']); // Fungsi untuk mapping ID metode pembayaran
$statusPembayaran = $data['transaction_status'] === 'settlement' ? 'Success' : ($data['transaction_status'] === 'pending' ? 'Pending' : 'Failed');

// Simpan data transaksi ke database
global $DB;
if (!$DB) {
    http_response_code(500);
    exit("Database connection error");
}

// Log transaksi ke file
$logData = "OrderID: $orderID, NIM: $nim, Jumlah: $jumlahPembayaran, Tanggal: $tanggalPembayaran, Metode: $metodePembayaran, Status: $statusPembayaran\n";
file_put_contents('transaction_log.txt', $logData, FILE_APPEND);

// Query ke database
$stmt = $DB->prepare("INSERT INTO Pembayaran_UKT (NIM, Jumlah_Pembayaran, Tanggal_Pembayaran, ID_Metode_Pembayaran, Status_Pembayaran) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE Status_Pembayaran = ?");
$stmt->bind_param("iisiss", $nim, $jumlahPembayaran, $tanggalPembayaran, $metodePembayaran, $statusPembayaran, $statusPembayaran);
if (!$stmt->execute()) {
    http_response_code(500);
    exit("Database error: " . $stmt->error);
}
$stmt->close();
$DB->close();

// Kirim respons sukses ke Midtrans
http_response_code(200);
echo "Webhook processed successfully";

// Fungsi untuk mapping metode pembayaran
function mapPaymentMethod($paymentType) {
    $mapping = [
        'gopay' => 1, // Contoh ID untuk Gopay
        'bank_transfer' => 2, // Contoh ID untuk Bank Transfer
        'credit_card' => 3, // Contoh ID untuk Kartu Kredit
        'qris' => 4 // Contoh ID untuk QRIS
    ];
    return isset($mapping[$paymentType]) ? $mapping[$paymentType] : null;
}

// Fungsi untuk extract NIM dari Order ID
function extractNIMFromOrderID($orderID) {
    if (strpos($orderID, '-') === false) {
        return null;
    }
    $parts = explode('-', $orderID);
    return isset($parts[1]) ? (int)$parts[1] : null;
}
?>
