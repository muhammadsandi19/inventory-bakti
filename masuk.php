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
                        <h1 class="mt-4">Barang Masuk</h1>
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
                                            <th>Jumlah Barang Masuk</th>
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
                                            $ambilsemuadatabarang = mysqli_query($conn, "select * from masuk m, barang s where s.idbarang = m.idbarang 
                                            and tanggalmasuk BETWEEN '$mulai' and '$selesai'");

                                        } else {
                                            $ambilsemuadatabarang = mysqli_query($conn, "select * from masuk m, barang s where s.idbarang = m.idbarang");
                                        }

                                    } else {
                                        $ambilsemuadatabarang = mysqli_query($conn, "select * from masuk m, barang s where s.idbarang = m.idbarang");
                                    }

                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatabarang)){
                                            $idb = $data['idbarang'];
                                            $idm = $data['idmasuk'];
                                            $namabarang = $data['namabarang'];
                                            $jumlah = $data['jumlah'];
                                            $tanggalmasuk = $data['tanggalmasuk'];
                                        ?>

                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namabarang;?></td>
                                            <td><?=$jumlah;?></td>
                                            <td><?=$tanggalmasuk;?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idm;?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idm;?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="edit<?=$idm;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Barang</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    <input type="number" name="jumlah" value="<?=$jumlah;?>" class="form-control" required>
                                                    <br>
                                                    <input type="date" name="tanggalmasuk" value="<?=$tanggalmasuk;?>" class="form-control" required>
                                                    <br>
                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                    <input type="hidden" name="idm" value="<?=$idm;?>">
                                                    <button type="submit" class="btn btn-primary" name="updatebarangmasuk">Submit</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete<?=$idm;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Barang</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                    <div class="modal-body">
                                                    Apakah Anda Yakin Ingin Menghapus <?=$namabarang;?>?
                                                    <input type="hidden" name="idb" value="<?=$idb;?>">
                                                    <input type="hidden" name="idm" value="<?=$idm;?>">
                                                    <input type="hidden" name="qty" value="<?=$jumlah;?>">
                                                    <br>
                                                    <br>
                                                    <button type="submit" class="btn btn-danger" name="hapusbarangmasuk">Hapus</button>
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
                    <h4 class="modal-title">Tambah Barang Masuk</h4>
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
                        }
                    ?>
                </select>
                <br>
                <input type="number" name="jumlah" placeholder="Jumlah Barang" class="form-control" required>
                <br>
                <input type="date" name="tanggalmasuk" placeholder="Tanggal Masuk" class="form-control" required>
                <br>
                <button type="submit" class="btn btn-primary" name="barangmasuk">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</html>
