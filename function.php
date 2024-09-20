<?php
session_start();
//membuat koneksi ke database
$conn = mysqli_connect("localhost","root","","stock-barang");

//menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $stockawal = $_POST['stockawal'];
    $stock = $_POST['stock'];
    $barangkeluar = $_POST['barangkeluar'];
    $stockakhir = $_POST['stockakhir'];
    $tanggal = $_POST['tanggal'];


    $addtotable = mysqli_query($conn,"INSERT into barang (namabarang, stockawal, stock, barangkeluar, stockakhir, tanggal) 
    values ('$namabarang', '$stockawal', '$stock','$barangkeluar', '$stockakhir', '$tanggal')");
    if($addtotable){
        header('location:index.php');
    } else {
        echo 'Gagal';
        header('location:index.php');
    }
}

//Menambah Barang Masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $jumlah = $_POST['jumlah'];
    $tanggalmasuk = $_POST['tanggalmasuk'];

    $cekstocksekarang = mysqli_query($conn,"select * from barang where idbarang='$barangnya'");
    $cekstockakhir = mysqli_query($conn,"select * from barang where idbarang='$barangnya'");

    $ambildatanya = mysqli_fetch_array($cekstocksekarang);
    $ambildataakhir = mysqli_fetch_array($cekstockakhir);

    $stocksekarang = $ambildatanya['stock'];
    $stockakhir = $ambildataakhir['stockakhir'];
    $tambahkanstocksekarangdenganjumlah = $stocksekarang+$jumlah;
    $tambahkanstockakhirdenganjumlah = $stockakhir+$jumlah;

    $addtomasuk = mysqli_query($conn,"insert into masuk (idbarang, jumlah, tanggalmasuk) 
    values ('$barangnya', '$jumlah', '$tanggalmasuk')");
    $updatestockmasuk = mysqli_query($conn, "update barang set stock='$tambahkanstocksekarangdenganjumlah', stockakhir='$tambahkanstockakhirdenganjumlah' 
    where idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else {
        echo 'Gagal';
        header('location:masuk.php');
    }
}

//Menambah Barang Keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $jumlahkeluar = $_POST['jumlahkeluar'];
    $tanggalkeluar = $_POST['tanggalkeluar'];

    $cekstockakhir = mysqli_query($conn,"select * from barang where idbarang='$barangnya'");
    $ambildataakhir = mysqli_fetch_array($cekstockakhir);
    $stockakhir = $ambildataakhir['stockakhir'];

    $cekbarangkeluar = mysqli_query($conn,"select * from barang where idbarang='$barangnya'");
    $ambildatakeluarnya = mysqli_fetch_array($cekbarangkeluar);
    $barangkeluar = $ambildatakeluarnya['barangkeluar'];

    $tambahkanstockakhirdenganjumlah = $stockakhir-$jumlahkeluar;
    $tambahkanbarangkeluardenganjumlah = $barangkeluar+$jumlahkeluar;

    $addtokeluar = mysqli_query($conn,"insert into keluar (idbarang, jumlahkeluar, tanggalkeluar) 
    values ('$barangnya', '$jumlahkeluar', '$tanggalkeluar')");
    $updatestockmasuk = mysqli_query($conn, "update barang set barangkeluar='$tambahkanbarangkeluardenganjumlah', stockakhir='$tambahkanstockakhirdenganjumlah' 
    where idbarang='$barangnya'");
    if($addtokeluar&&$updatestockmasuk){
        header('location:keluar.php');
    } else {
        echo 'Gagal';
        header('location:keluar.php');
    }
}

//Update info barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $stockawal = $_POST['stockawal'];
    $stock = $_POST['stock'];
    $barangkeluar = $_POST['barangkeluar'];
    $stockakhir = $_POST['stockakhir'];
    $tanggal = $_POST['tanggal'];

    $update = mysqli_query($conn,"update barang set namabarang='$namabarang', stockawal='$stockawal', stock='$stock', barangkeluar='$barangkeluar', stockakhir='$stockakhir', tanggal='$tanggal' where idbarang ='$idb'");
    if($update){
        header("location:index.php");
    } else {
        echo "Gagal";
        header("location:index.php");
    } 

}


//Meanghapus barang dari stock
if(isset($_POST["hapusbarang"])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn,"delete from barang where idbarang='$idb'");
    if($hapus){
        header("location:index.php");
    } else {
        echo "Gagal";
        header("location:index.php");
    } 

}

//Mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $jumlah = $_POST['jumlah'];
    $tanggalmasuk = $_POST['tanggalmasuk'];


    $lihatstock = mysqli_query($conn, "select * from barang where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrng = $stocknya['stock'];


    $lihatstockakhir = mysqli_query($conn, "select * from barang where idbarang='$idb'");
    $stockakhirnya = mysqli_fetch_array($lihatstockakhir);
    $stockakhirskrng = $stockakhirnya['stockakhir'];


    $jumlahskrng = mysqli_query($conn,"select * from masuk where idmasuk='$idm'");
    $jumlahnya = mysqli_fetch_array($jumlahskrng);
    $jumlahskrng = $jumlahnya['jumlah'];

    if($jumlah>$jumlahskrng) {
        $selisih = $jumlah-$jumlahskrng;
        $kurangin = $stockskrng+$selisih;
        $kuranginstockakhir = $stockakhirskrng+$selisih;
        $kuranginstocknya = mysqli_query($conn, "update barang set stock='$kurangin', stockakhir='$kuranginstockakhir' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set jumlah='$jumlah', tanggalmasuk='$tanggalmasuk' where idmasuk='$idm'");
            if($kuranginstocknya&&$updatenya) {
                header("location:masuk.php");
            } else {
                echo "Gagal";
                header("location:masuk.php");
            }

    } else {
        $selisih = $jumlahskrng-$jumlah;
        $kurangin = $stockskrng-$selisih;
        $kuranginstockakhir = $stockakhirskrng+$selisih;
        $kuranginstocknya = mysqli_query($conn, "update barang set stock='$kurangin', stockakhir='$kuranginstockakhir' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set jumlah='$jumlah', tanggalmasuk='$tanggalmasuk' where idmasuk='$idm'");
            if($kuranginstocknya&&$updatenya) {
                header("location:masuk.php");
            } else {
                header("location:masuk.php");
           }        
        }
    }


//Menghapus barang masuk
if(isset($_POST["hapusbarangmasuk"])){
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from barang where idbarang='$idb'");
    $getdatastockakhir = mysqli_query($conn,"select * from barang where idbarang='$idb'");

    $data = mysqli_fetch_array($getdatastock);
    $dataakhir = mysqli_fetch_array($getdatastockakhir);

    $stok = $data["stock"];
    $stockakhir = $dataakhir["stockakhir"];

    $selisih = $stok-$qty;
    $selisihakhir = $stockakhir-$qty;

    $update = mysqli_query($conn, "update barang set stock='$selisih', stockakhir='$selisihakhir' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata) {
        header('location:masuk.php');
    }  else {
        header('location:masuk.php');
    }     
}


//Mengubah barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $jumlahkeluar = $_POST['jumlahkeluar'];
    $tanggalkeluar = $_POST['tanggalkeluar'];

    $lihatstock = mysqli_query($conn, "select * from barang where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockakhir = $stocknya['stockakhir'];

    $lihatbarangkeluar = mysqli_query($conn, "select * from barang where idbarang='$idb'");
    $barangnya = mysqli_fetch_array($lihatbarangkeluar);
    $barangkeluar = $barangnya['barangkeluar'];

    $lihatjumlahkeluar = mysqli_query($conn,"select * from keluar where idkeluar='$idk'");
    $jumlahnya = mysqli_fetch_array($lihatjumlahkeluar);
    $jumlahskrng = $jumlahnya['jumlahkeluar'];

    if($jumlahkeluar>$jumlahskrng) {
        $selisih = $jumlahkeluar-$jumlahskrng;
        $kurangin = $stockakhir-$selisih;
        $tambahin = $barangkeluar+$selisih;
        $kuranginstocknya = mysqli_query($conn, "update barang set barangkeluar='$tambahin', stockakhir='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set jumlahkeluar='$jumlahkeluar', tanggalkeluar='$tanggalkeluar' where idkeluar='$idk'");
            if($kuranginstocknya&&$updatenya) {
                header("location:keluar.php");
                } else {
                    echo "Gagal";
                    header("location:keluar.php");
                }
    } else {
        $selisih = $jumlahskrng-$jumlahkeluar;
        $kurangin = $stockakhir+$selisih;
        $tambahin = $barangkeluar-$selisih;
        $kuranginstocknya = mysqli_query($conn, "update barang set barangkeluar='$tambahin', stockakhir='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set jumlahkeluar='$jumlahkeluar', tanggalkeluar='$tanggalkeluar' where idkeluar='$idk'");
            if($kuranginstocknya&&$updatenya) {
               header("location:keluar.php");
               } else {
                echo "Gagal";
                header("location:keluar.php");
           }        
        }
    }     
    
    
//Menghapus barang keluar
if(isset($_POST["hapusbarangkeluar"])){
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn,"select * from barang where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data["stockakhir"];

    $getdatabarang = mysqli_query($conn,"select * from barang where idbarang='$idb'");
    $databarang = mysqli_fetch_array($getdatabarang);
    $barangkeluar = $databarang["barangkeluar"];

    $selisih = $stok+$qty;
    $kurangin = $barangkeluar-$qty;

    $update = mysqli_query($conn, "update barang set barangkeluar='$barangkeluar', stockakhir='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata) {
        header('location:keluar.php');
    }  else {
        header('location:keluar.php');
    }     
}

//Menambah Transaksi Keluar
if(isset($_POST['addtransaksi'])){
    $barangnya = $_POST['barangnya'];
    $idkeluarnya = $_POST['idkeluarnya'];
    $jumlahtransaksi = $_POST['jumlahtransaksi'];
    $keterangan = $_POST['keterangan'];
    $tanggaltransaksi = $_POST['tanggaltransaksi'];

    $cekstockakhir = mysqli_query($conn,"SELECT * from barang where idbarang='$barangnya'");
    $ambildataakhir = mysqli_fetch_array($cekstockakhir);
    $stockakhir = $ambildataakhir['stockakhir'];

    $cekjumlahkeluar = mysqli_query($conn,"SELECT * from keluar where idkeluar='$idkeluarnya'");
    $ambildatakeluar = mysqli_fetch_array($cekjumlahkeluar);
    $hasiljumlahkeluar = $ambildatakeluar['jumlahkeluar'];

    $tambahkanstockakhirdenganjumlah = $stockakhir-$jumlahtransaksi;
    $tambahkantransaksidenganjumlah = $hasiljumlahkeluar+$jumlahtransaksi;

    $addtotransaksikeluar = mysqli_query($conn, "INSERT into transaksi (idbarang, idkeluar, jumlahtransaksi, keterangan, tanggaltransaksi) 
    values ('$barangnya', '$idkeluarnya', '$jumlahtransaksi', '$keterangan', '$tanggaltransaksi')");
    $updatestockbarang = mysqli_query($conn, "UPDATE barang set stockakhir='$tambahkanstockakhirdenganjumlah' 
    where idbarang='$barangnya'");
    $updatejumlahkeluar = mysqli_query($conn, "UPDATE keluar set jumlahkeluar='$tambahkantransaksidenganjumlah' 
    where idkeluar='$idkeluarnya'");
    if($addtotransaksikeluar&&$updatestockbarang&&$updatejumlahkeluar){
        header('location:transaksi.php');
    } else {
        echo 'Gagal';
        header('location:transaksi.php');
    }
}


//Mengubah transaksi
if(isset($_POST['updatetransaksi'])){
    $idb = $_POST['idb'];
    $idt = $_POST['idt'];
    $idk = $_POST['idk'];
    $jumlahtransaksi = $_POST['jumlahtransaksi'];
    $keterangan = $_POST['keterangan'];
    $tanggaltransaksi = $_POST['tanggaltransaksi'];

    $lihatstock = mysqli_query($conn, "select * from barang where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockakhir = $stocknya['stockakhir'];

    $lihatjumlahkeluar = mysqli_query($conn,"select * from keluar where idkeluar='$idk'");
    $jumlahnya = mysqli_fetch_array($lihatjumlahkeluar);
    $jumlahkeluarskrng = $jumlahnya['jumlahkeluar'];

    $lihatjumlahtransaksi = mysqli_query($conn,"select * from transaksi where idtransaksi='$idt'");
    $jumlahtransaksinya = mysqli_fetch_array($lihatjumlahtransaksi);
    $jumlahtransaksiskrng = $jumlahtransaksinya['jumlahtransaksi'];

    if($jumlahtransaksi>$jumlahtransaksiskrng) {
        $selisih = $jumlahtransaksi-$jumlahtransaksiskrng;
        $kurangin = $stockakhir-$selisih;
        $kuranginjumlahkeluar = $jumlahkeluarskrng+$selisih;
        $kuranginstocknya = mysqli_query($conn, "update barang set stockakhir='$kurangin' where idbarang='$idb'");
        $updatekeluarnya = mysqli_query($conn, "update keluar set jumlahkeluar='$kuranginjumlahkeluar' where idkeluar='$idk'");
        $updatetransaksinya = mysqli_query($conn, "update transaksi set jumlahtransaksi='$jumlahtransaksi', keterangan='$keterangan', tanggaltransaksi='$tanggaltransaksi' where idtransaksi='$idt'");
            if($kuranginstocknya&&$updatekeluarnya&&$updatetransaksinya) {
                header("location:transaksi.php");
                } else {
                    echo "Gagal";
                    header("location:transaksi.php");
                }
    } else {
        $selisih = $jumlahtransaksiskrng-$jumlahtransaksi;
        $kurangin = $stockakhir+$selisih;
        $kuranginjumlahkeluar = $jumlahkeluarskrng-$selisih;
        $kuranginstocknya = mysqli_query($conn, "update barang set stockakhir='$kurangin' where idbarang='$idb'");
        $updatekeluarnya = mysqli_query($conn, "update keluar set jumlahkeluar='$kuranginjumlahkeluar' where idkeluar='$idk'");
        $updatetransaksinya = mysqli_query($conn, "update transaksi set jumlahtransaksi='$jumlahtransaksi', keterangan='$keterangan', tanggaltransaksi='$tanggaltransaksi' where idtransaksi='$idt'");
            if($kuranginstocknya&&$updatekeluarnya&&$updatetransaksinya) {
               header("location:transaksi.php");
               } else {
                echo "Gagal";
                header("location:transaksi.php");
           }        
        }
    }     


//Menghapus transaksi
if(isset($_POST["hapustransaksi"])){
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idk = $_POST['idk'];
    $idt = $_POST['idt'];

    $getdatastock = mysqli_query($conn,"select * from barang where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data["stockakhir"];

    $getdatakeluar = mysqli_query($conn,"select * from keluar where idkeluar='$idk'");
    $datakeluar = mysqli_fetch_array($getdatakeluar);
    $jumlahkeluar = $datakeluar["jumlahkeluar"];

    $selisih = $stok+$qty;
    $selisihjumlahkeluar = $jumlahkeluar-$qty;

    $update = mysqli_query($conn, "update barang set stockakhir='$selisih' where idbarang='$idb'");
    $updatekeluar = mysqli_query($conn, "update keluar set jumlahkeluar='$selisihjumlahkeluar' where idkeluar='$idk'");
    $hapusdata = mysqli_query($conn, "delete from transaksi where idtransaksi='$idt'");

    if($update&&$updatekeluar&&$hapusdata) {
        header('location:transaksi.php');
    }  else {
        header('location:transaksi.php');
    }     
}    
?>