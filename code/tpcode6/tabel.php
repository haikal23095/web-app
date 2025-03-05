<?php
include 'koneksi.php';
$query = "SELECT barang.id, barang.kode_barang, barang.nama_barang, barang.harga, barang.stok, supplier.nama FROM barang JOIN supplier ON barang.supplier_id = supplier.id";
$result = mysqli_query($conn, $query);
$query2 = "SELECT * FROM transaksi JOIN pelanggan ON transaksi.id = pelanggan.id";
$result2 = mysqli_query($conn, $query2);
$query3 = "SELECT * FROM transaksi_detail JOIN barang ON transaksi_detail.barang_id = barang.id";
$result3 = mysqli_query($conn, $query3);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data-supplier</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            margin: 0;
            padding:0;
        }
        h1{
            text-align: center;
        }
        .container{
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 40%;
            margin: auto;
        }
        .transaksi {
            display: flex;
            justify-content: space-evenly;
            margin: 30px 0 30px 0;
        }
        .add_button {
            display: flex;
            justify-content: center;
            padding: 20px;

        }
        .add_button button {
            margin: 10px;
        }

    </style>
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body>
    <h1>Pengelolaan Master Detail</h1>
    <div class="container">
        <h3 id="Judul">Data Tabel Barang</h3>
        <table name="table_barang" id="table_barang" border="1">
            <tr id="head-table-barang">
                <td>ID</td>
                <td>Kode Barang</td>
                <td>Nama Barang</td>
                <td>Harga</td>
                <td>Stok</td>
                <td>Nama Supplier</td>
                <td>Action</td>
            </tr>
            <?php
                if (mysqli_num_rows($result)> 0){
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            echo "<td>".$row['kode_barang']."</td>";
                            echo "<td>".$row['nama_barang']."</td>";
                            echo "<td>".$row['harga']."</td>";
                            echo "<td>".$row['stok']."</td>";
                            // sementara
                            echo "<td>".$row['nama']."</td>";
                            //
                            echo "<td>
                            <a href='delete_barang.php?id=" .$row['id']."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'><button class='hapus-data-supplier' name='hapus-data-supplier'>Hapus</button></a>
                            </td>";
                            // echo "<button class='hapus-data-supplier' name='hapus-data-supplier'><a href='delete_supplier.php?id=".$row['id']."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a></button> </td>";
                            echo "</tr>";
                    }
                }else{
                    echo 'Data supplier tidak ditemukan';
                }
                ?>
        </table>
    </div>
    <div class="transaksi">
        <div class="transaksi_master">
            <h3>Transaksi</h3>
            <table name="table_transaski_master" id="table_transaksi_master" border="1">
                <tr>
                    <td>ID</td>
                    <td>Waktu Transaksi</td>
                    <td>Keterangan</td>
                    <td>Total</td>
                    <td>Nama Pelanggan</td>
                </tr>
                <?php
                if (mysqli_num_rows($result2)> 0){
                    while ($row = mysqli_fetch_assoc($result2)){
                        echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            echo "<td>".$row['waktu_transaksi']."</td>";
                            echo "<td>".$row['keterangan']."</td>";
                            echo "<td>".$row['total']."</td>";
                            echo "<td>".$row['nama']."</td>";
                            echo "</tr>";
                    }
                }else{
                    echo 'Data supplier tidak ditemukan';
                }
                ?>
            </table>
        </div>
        <div class="transaksi_detail">
        <h3>Transaksi detail</h3>
            <table name="table_transaski_detail" id="table_transaksi_detail" border="1">
                <tr>
                    <td>Transaksi ID</td>
                    <td>Nama Barang</td>
                    <td>Harga</td>
                    <td>QTY</td>
                </tr>
                <?php
                if (mysqli_num_rows($result3)> 0){
                    while ($row = mysqli_fetch_assoc($result3)){
                        echo "<tr>";
                            echo "<td>".$row['transaksi_id']."</td>";
                            echo "<td>".$row['nama_barang']."</td>";
                            echo "<td>".$row['harga']."</td>";
                            echo "<td>".$row['qty']."</td>";
                            echo "</tr>";
                    }
                }else{
                    echo 'Data supplier tidak ditemukan';
                }
                ?>
            </table>
        </div>
    </div>
    <div class="add_button">
        <a href="master_form.php"><button>Tambah Transaksi</button></a>
        <a href="detail_form.php"><button>Tambah Transaksi Detail</button></a>
    </div>
    <script src="script.js"></script>
</body>
</html>


