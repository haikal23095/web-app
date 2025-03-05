<?php
require "koneksi.php";

$error = [];


if (isset($_POST['tambah_transaksi'])){
    // waktu transaksi
    $waktu_transaksi = $_POST['waktu_transaksi'];
    $keterangan = $_POST['keterangan'];
    $total = $_POST['total'];
    $pelanggan = $_POST['pelanggan'];
    if (empty($waktu_transaksi)){
        $error["waktu_transaksi"] = "Tanggal wajib di isi";
        $waktu_transaksi = "";
    }else{
        // echo $waktu_transaksi."<br>";
        $waktu_transaksi_str = strtotime($waktu_transaksi);
        // echo $waktu_transaksi."<br>";
        $dateNow = strtotime(date('Y-m-d'));
        // echo $dateNow;
        if ($waktu_transaksi_str < $dateNow){
            $error["waktu_transaksi"]= "waktu transaksi tidak boleh hari sebelum tanggal sekarang";
            $waktu_transaksi = "";
        }
    }
    // keterangan
    if (empty($keterangan)){
        $keterangan = "-";
    }else{
        $keterangan = test_input($keterangan);
    }
    //total
    if ($total == 0){
        $error["total"] = "Total tidak boleh 0";
    }else{
        $total = test_input($total);
    }
    //pelanggan
    if ($pelanggan == '0'){
        $error["pelanggan"] = "Masukkan pelanggan";
    }else{
        $pelanggan = test_input($pelanggan);
    }

    if ($error == []){
        $query = "INSERT INTO transaksi(waktu_transaksi, keterangan, total, pelanggan_id) VALUES ('$waktu_transaksi', '$keterangan', '$total', '$pelanggan')";
        $result = mysqli_query($conn, $query);
        if ($result){
            echo "Data berhasil di insert";
            header('Location: master_form.php');
        }else{
            echo "Data gagal di insert ".mysqli_error($conn);
        }
    }
}

// filter input function
function test_input($inp){
    $inp = trim($inp);
    $inp = stripslashes($inp);
    $inp = htmlspecialchars($inp);
    return $inp;
}

?>