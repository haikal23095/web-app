<?php
require "koneksi.php";

//query pelanggan
    $query = "SELECT * FROM pelanggan";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 0){
        $error[$pelanggan] = "Data tidak ditemukan";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <style>
        h1{
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 35%;
            margin: auto;
            border: 1px black solid;
            border-radius: 5px;
            padding: 10px;
        }
        form h3 {
            text-align: center;
        }
        span {
            color: red;
        }
        button {
            background-color: #399fed;
            color:white;
            border: 2px #399fed solid;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <h1>Form Input Data Transaksi</h1>
    <form action="validasi.php" method="POST">
        <h3>Tambah Data Transaksi</h3>
        <label for="waktu_transaksi">Waktu Transaksi : </label>
        <br>
        <input type="date" name="waktu_transaksi" id="waktu_transaksi" value= "<?php echo isset($waktu_transaksi) ? $waktu_transaksi : "" ; ?>">
        <span class="error"><?php echo isset($error["waktu_transaksi"]) ? $error["waktu_transaksi"] : ""; ?></span>
        <br>
        <label for="keterangan">Keterangan : </label>
        <br>
        <textarea name="keterangan" id="keterangan" placeholder="Masukkan keterangan transaksi"><?php echo isset($keterangan) ? $keterangan : "" ; ?></textarea>
        <br>
        <label for="total">Total</label>
        <br>
        <input type="number" name="total" id="number" value= "<?php echo isset($total) ? $total : 0 ; ?>">
        <span class="error"><?php echo isset($error["total"]) ? $error["total"] : ""; ?></span>
        <br>
        <label for="pelanggan">Pelanggan</label>
        <br>
        <select name="pelanggan" id="pelanggan">
            <option value="0">Pilih pelanggan </option>
            <?php
            foreach($result as $val){
                echo "<option value='" . $val['id'] . "'>" .$val['nama']. "</option>";
            }
            ?>
        </select>
        <span class="error"><?php echo isset($error["pelanggan"]) ? $error["pelanggan"] : ""; ?></span>
        <br>
        <button type="submit" name="tambah_transaksi">Tambah Transaksi</button>
    </form>
</body>
</html>
