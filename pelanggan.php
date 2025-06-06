<?php
require 'ceklogin.php';

    //Hitung jumlah pesanan
    $hpelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
    //Jumlah pesanan
    $jpelanggan = mysqli_num_rows($hpelanggan);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Kasir TokoKu</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Kasir TokoKu</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>           
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-utensils"></i></div>
                                Data Pesanan
                            </a>
                            <a class="nav-link" href="stok.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                                Stok Barang
                            </a>
                            <a class="nav-link" href="barangmasuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-plus"></i></div>
                                Barang Masuk
                            </a> 
                            <a class="nav-link active" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-edit"></i></div>
                                Kelola Pelanggan
                            </a>
                            
                            <a class="nav-link" href="logout.php">                                
                                Log Out
                            </a>
                        </div>                            
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Sistem Kasir | TokoKu
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Kelola Pelanggan</h1>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Jumlah Pelanggan : <?=$jpelanggan;?></div>
                                </div>
                            </div>                            
                        </div>
                        <!-- Tombol untuk membuka modal, kode modal ada di bawah -->
                        <button type="button" class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Pelanggan
                        </button>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pelanggan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Pelanggan</th>
                                            <th>No. Telepon</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>                                    
                                    <tbody>
                                        <?php
                                        //Memasukkan semua data dari tabel produk ke variabel ambil
                                            $ambil = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                                            $i = 1; //Digunakan sebagai penomoran, karena penambahan while loop (iterasi)

                                        //Selama variabel produk memiliki nilai, tampilkan data ke website
                                        //Start of while
                                            while($pelanggan = mysqli_fetch_array($ambil)) {
                                                $namapelanggan = $pelanggan['namapelanggan'];
                                                $notelp = $pelanggan['notelp'];
                                                $alamat = $pelanggan['alamat'];
                                                $idpelanggan = $pelanggan['idpelanggan'];
                                            
                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namapelanggan;?></td>
                                            <td><?=$notelp;?></td>
                                            <td><?=$alamat;?></td>
                                            <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idpelanggan;?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idpelanggan;?>">
                                                Delete
                                            </button>
                                            </td>
                                        </tr>
                                            <!-- Modal untuk fungsi Edit -->
                                            <div class="modal fade" id="edit<?=$idpelanggan;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Pelanggan - <?=$namapelanggan;?></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="post">

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <input type="text" name="namapelanggan" id="" class="form-control" placeholder="Nama Pelanggan" value="<?=$namapelanggan;?>">
                                                        <input type="text" name="notelp" id="" class="form-control mt-2" placeholder="No. Telepon" value="<?=$notelp;?>">
                                                        <input type="text" name="alamat" id="" class="form-control mt-2" placeholder="Alamat" value="<?=$alamat;?>">
                                                        <input type="hidden" name="idpelanggan" value="<?=$idpelanggan;?>">
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" name="editpelanggan">Ubah</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batalkan</button>
                                                    </div>

                                                </form>

                                                </div>    
                                            </div>
                                            </div>

                                            <!-- Modal untuk fungsi Delete -->
                                            <div class="modal fade" id="delete<?=$idpelanggan;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Pelanggan - <?=$namapelanggan;?></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="post">

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Konfirmasi penghapusan data pelanggan.
                                                        <input type="hidden" name="idpelanggan" value="<?=$idpelanggan;?>">
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success" name="deletepelanggan">Hapus</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batalkan</button>
                                                    </div>

                                                </form>

                                                </div>    
                                            </div>
                                            </div>

                                        <?php
                                            } //End of while
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; TokoKu 2025</div>
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
            <h4 class="modal-title">Tambah Pelanggan</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form method="post">

        <!-- Modal body -->
        <div class="modal-body">
            <input type="text" name="namapelanggan" id="" class="form-control" placeholder="Nama Pelanggan">
            <input type="text" name="notelp" id="" class="form-control mt-2" placeholder="No. Telepon">
            <input type="text" name="alamat" id="" class="form-control mt-2" placeholder="Alamat">
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="tambahpelanggan">Tambahkan</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batalkan</button>
        </div>
        </form>
        </div>    
    </div>
</div>
</html>