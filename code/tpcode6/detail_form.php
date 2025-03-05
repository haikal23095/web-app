<?php
require "koneksi.php";

$error = [];
if (isset($_POST["tambah_detail_transaksi"])){
    $barang_id = $_POST['barang_id'];
    $transaksi_id = $_POST['transaksi_id'];
    $qty = $_POST['qty'];
    
    // barang_id
    if ($barang_id == 0){
        $error['barang_id'] = "Wajib memilih nama barang";
    }

    // transaksi id
    if ($transaksi_id == 0){
        $error['transaksi_id'] = "Wajib memilih transaksi_id";
    }
    
    //qty
    if (empty($qty)){
        $error['qty']= "Wajib masaukkan jumlah barang yang dibeli";
    }else{
        if (!is_numeric($qty)){
            $error['qty'] = "Masukkan wajib angka";
        }else{
            $qty = test_input($qty);
        }
    }

    if ($error == []){
        $query = "SELECT barang_id FROM transaksi_detail";
        $check_barang_id = mysqli_query($conn, $query);
        $array_barang_id = [];
        foreach($check_barang_id as $val){
            $array_barang_id[] = $val['barang_id'];
        }
        if (in_array($barang_id, $array_barang_id)){
            $error['barang_id'] = "Error : Barang sudah ada di dalam tabel transaksi detail";
        }else{
            $query = "SELECT id from barang";
            $check_barang_id = mysqli_query($conn, $query);
            $array_barang_id = [];
            foreach($check_barang_id as $val){
                $array_barang_id[] = $val['id'];
            }
            $idx = array_search($barang_id, $array_barang_id);
            $query = "SELECT harga FROM barang WHERE id = $idx";
            $check_harga = mysqli_query($conn, $query);
            $harga = 0;
            foreach($check_harga as $val){
                $harga = $val['harga'];
            }
            $harga_transaksi_barang = $harga * $qty;
            $query = "INSERT INTO transaksi_detail(transaksi_id, barang_id, harga, qty) VALUES ('$transaksi_id', '$barang_id', '$harga_transaksi_barang', '$qty')";
            if (mysqli_query($conn, $query)){
                echo "Data transaksi_detail berhasil diinsert";

                //update automatically
                $query4 = "SELECT transaksi_id, harga, qty FROM transaksi_detail WHERE transaksi_id = $transaksi_id";
                $result4 = mysqli_query($conn, $query4);
                $data_harga = [];
                foreach($result4 as $val){
                    $data_harga[$val['transaksi_id']] = $val['harga'] * $val['qty'];
                }

                foreach($data_harga as $key => $val){
                    $query5= "UPDATE transaksi SET total = total + $val WHERE id = $key";
                    mysqli_query($conn, $query5);
                }
            }else{
                echo "Error : ".mysqli_error($conn);
            }
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

$query = "SELECT * FROM barang";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 0){
    echo "Data barang tidak ditemukan";
}
$query2 = "SELECT * FROM transaksi_detail JOIN transaksi ON transaksi_detail.transaksi_id = transaksi.id";
$result2 = mysqli_query($conn, $query);
if (mysqli_num_rows($result2) == 0){
    echo "Data transaksi detail tidak ditemukan";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form detail</title>
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
    <h1>Detail Transaksi</h1>
    <form action="" method="POST">
        <h3>Tambah Detail Transaksi</h3>
        <label for="barang_id">Pilih Barang : </label>
        <select name="barang_id" id="barang_id">
            <option value="0">Pilih Barang :</option>
            <?php
            foreach($result as $val){
                echo "<option value='" . $val['id'] . "'>" .$val['nama_barang']. "</option>";
            }
            ?>
        </select>
        <span class="error"><?php echo isset($error["barang_id"]) ? $error["barang_id"] : ""; ?></span>
        <br>
        <label for="transaksi_id">ID Transaksi : </label>
        <select name="transaksi_id" id="transaksi_id">
            <option value="0">Pilih ID Transaksi</option>
            <?php
            foreach($result2 as $val){
                echo "<option value='" . $val['id'] . "'>" .$val['id']. "</option>";
            }
            ?>
        </select>
        <span class="error"><?php echo isset($error["transaksi_id"]) ? $error["transaksi_id"] : ""; ?></span>
        <br>
        <label for="qty">QTY : </label>
        <input type="number" name="qty" id="qty" placeholder="Masukkan jumlah barang" value= "<?php echo isset($qty) ? $qty : "" ; ?>">
        <span class="error"><?php echo isset($error["qty"]) ? $error["qty"] : ""; ?></span>
        <br>
        <button type="submit" name="tambah_detail_transaksi">Tambah Detail Transaksi</button>
    </form>
</body>
</html>