<?php 
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>BAKTI Kominfo</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">BAKTI Kominfo</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                        <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Transaksi Barang Keluar
                            </a>
                            <a class="nav-link" href="transaksi.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Transaksi Keluar
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Transaksi Keluar</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <form method="post">
                                    <div class="row mt-3">
                                        <div class="col">
                                            <input type="date" name="tgl_mulai" class="">
                                            <input type="date" name="tgl_selesai" class="ml-3">
                                            <button type="submit" name="filter_tgl" class="btn btn-info ml-3">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Transaksi Barang</th>
                                            <th>Keterangan</th>
                                            <th>Tanggal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    <?php
                                    if(isset($_POST['filter_tgl'])) {
                                        $mulai = $_POST['tgl_mulai'];        
                                        $selesai = $_POST['tgl_selesai'];

                                        if($mulai!=null || $selesai!=null) {
                                            $ambilsemuadatabarang = mysqli_query($conn, "SELECT * FROM transaksi
                                                INNER JOIN barang ON transaksi.idbarang = barang.idbarang
                                                INNER JOIN keluar ON transaksi.idkeluar = keluar.idkeluar 
                                            and tanggaltransaksi BETWEEN '$mulai' and '$selesai'");

                                        } else {
                                            $ambilsemuadatabarang = mysqli_query($conn, "SELECT * FROM transaksi
                                                INNER JOIN barang ON transaksi.idbarang = barang.idbarang
                                                INNER JOIN keluar ON transaksi.idkeluar = keluar.idkeluar
                                                ");
                                        }

                                    } else {
                                        $ambilsemuadatabarang = mysqli_query($conn, "SELECT * FROM transaksi
                                                INNER JOIN barang ON transaksi.idbarang = barang.idbarang
                                                INNER JOIN keluar ON transaksi.idkeluar = keluar.idkeluar
                                                ");
                                    }
                                        $i = 1;
                                        
                                        while($data=mysqli_fetch_array($ambilsemuadatabarang)){
                                            $idb = $data['idbarang'];
                                            $idt = $data['idtransaksi'];
                                            $idk = $data['idkeluar'];
                                            $namabarang = $data['namabarang'];
                                            $jumlahtransaksi = $data['jumlahtransaksi'];
                                            $keterangan = $data['keterangan'];
                                            $tanggaltransaksi = $data['tanggaltransaksi'];
                                        ?>
                                        

                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namabarang;?></td>
                                            <td><?=$jumlahtransaksi;?></td>
                                            <td><?=$keterangan;?></td>
                                            <td><?=$tanggaltransaksi;?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idt;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idt;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?=$idt;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Transaksi</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    <input type="number" name="jumlahtransaksi" value="<?=$jumlahtransaksi;?>" class="form-control" required>
                                                    <br>
                                                    <input type="text" name="keterangan" value="<?=$keterangan;?>" class="form-control" required>
                                                    <br>
                                                    <input type="date" name="tanggaltransaksi" value="<?=$tanggaltransaksi;?>" class="form-control" required>
                                                    <br>
                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                    <input type="hidden" name="idt" value="<?=$idt;?>">
                                                    <input type="hidden" name="idk" value="<?=$idk;?>">
                                                    <button type="submit" class="btn btn-primary" name="updatetransaksi">Submit</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?=$idt;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Transaksi</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    Apakah Anda Yakin Ingin Menghapus <?=$namabarang;?>?
                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                    <input type="hidden" name="idt" value="<?=$idt;?>">
                                                    <input type="hidden" name="idk" value="<?=$idk;?>">
                                                    <input type="hidden" name="qty" value="<?=$jumlahtransaksi;?>">
                                                    <input type="hidden" name="keterangan" value="<?=$keterangan;?>">
                                                    <br>
                                                    <br>
                                                    <button type="submit" class="btn btn-danger" name="hapustransaksi">Hapus</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        };

                                        ?>

                                    </tbody>
                                </table>
                                <!-- Button to Open the Modal -->
                               <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Barang
                                </button>
                                <a href="export.php" class="btn btn-success" >Export Data</a>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
      <!-- The Modal -->
      <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Transaksi Keluar</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <form method="post">
                <div class="modal-body">

                <select name="barangnya" class="form-control">
                <?php
                        $ambilsemuadatanya = mysqli_query($conn, "Select * from barang");
                        while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)) {
                            $namabarangnya = $fetcharray['namabarang'];
                            $idbarangnya = $fetcharray['idbarang'];
                    ?>
                    
                    <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>
                        <?php
                                };
                            ?>
                </select>
                <?php
                        $ambilsemuadatakeluarnya = mysqli_query($conn, "Select * from keluar");
                        while($fetcharrayy = mysqli_fetch_array($ambilsemuadatakeluarnya)) {
                            $idkeluar = $fetcharrayy['idkeluar'];
                            $jumlahkeluar = $fetcharrayy['jumlahkeluar'];
                    ?>
                <input type="hidden" name="idkeluarnya" value="<?=$idkeluar;?>">
                    <?php
                            };
                        ?>
                <br>
                <input type="number" name="jumlahtransaksi" placeholder="Jumlah Barang" class="form-control" required>
                <br>
                <input type="text" name="keterangan" placeholder="Keterangan" class="form-control" required>
                <br>
                <input type="date" name="tanggaltransaksi" placeholder="Tanggal Transaksi" class="form-control" required>
                <br>
                <button type="submit" class="btn btn-primary" name="addtransaksi">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</html>