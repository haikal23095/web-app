<?php
include 'koneksi.php';

if (isset($_GET['id'])){
    // sanitasi id menghindari sql injection
    $id = intval($_GET['id']);
    
    $query = "SELECT barang_id FROM transaksi_detail";
    $fetch_barang_id = mysqli_query($conn, $query);
    $array_barang_id = [];
    foreach($fetch_barang_id as $val){
        $array_barang_id[] = $val['barang_id'];
    }
    if (in_array($id, $array_barang_id)){
        header("Location: tabel.php?message=Data Barang tidak dapat dihapus karena digunkan di transaksi detail");
        exit();
    }else{
        $query = "DELETE FROM barang WHERE id = $id";
        if (mysqli_query($conn, $query)){
            echo "Data barang berhasil di hapus";
            header("Location: tabel.php?message=Data barang berhasil dihapus");
            exit();
        }else{
            echo "Error : ". mysqli_error($conn);
            header("Location: delete_supplier.php?message=ID tidak ditemukan");
            exit();
        }
    }

}

?>