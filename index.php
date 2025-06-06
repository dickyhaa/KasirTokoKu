<?php
    require 'ceklogin.php';
    
    //Hitung jumlah pesanan
    $hpesanan = mysqli_query($koneksi, "SELECT * FROM pesanan");
    //Jumlah pesanan
    $jpesanan = mysqli_num_rows($hpesanan);
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
            <span class="navbar-brand ps-3">Kasir TokoKu</span>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>           
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link active" href="index.php">
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
                            <a class="nav-link" href="pelanggan.php">
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
                        <h1 class="mt-4">Data Pesanan</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Pesanan hari ini</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Jumlah Pesanan : <?=$jpesanan;?></div>
                                </div>
                            </div>                            
                        </div>
                            <!-- Tombol untuk membuka modal, kode modal ada di bawah -->
                            <button type="button" class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Pesanan Baru
                        </button>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pesanan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>                                    
                                    <tbody>
                                    <?php
                                        //Memasukkan semua data dari tabel produk ke variabel ambil
                                            $ambil = mysqli_query($koneksi,
                                            "SELECT * FROM pesanan p, pelanggan pl WHERE p.idpelanggan = pl.idpelanggan"
                                        );

                                        //Selama variabel produk memiliki nilai, tampilkan data ke website
                                        //Start of while
                                            while($pesanan = mysqli_fetch_array($ambil)) {
                                                $idpesanan = $pesanan['idpesanan'];
                                                $tanggal = $pesanan['tanggal'];
                                                $namapelanggan = $pesanan['namapelanggan'];
                                                $alamat = $pesanan['alamat'];

                                                $hitungjumlah = mysqli_query($koneksi, 
                                                    "SELECT * FROM detailpesanan
                                                    WHERE idpesanan='$idpesanan'");
                                                $jumlah = mysqli_num_rows($hitungjumlah);
                                        ?>
                                        <tr>
                                            <td><?=$idpesanan;?></td>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namapelanggan;?> - <?=$alamat;?></td>
                                            <td><?=$jumlah;?></td>
                                            <td>
                                                <a href="view.php?idp=<?=$idpesanan;?>" class="btn btn-primary">
                                                Tampilkan
                                                </a>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idpesanan;?>">
                                                Delete
                                                </button>
                                            </td>
                                        </tr>

                                                <!-- Modal untuk fungsi Delete -->
                                            <div class="modal fade" id="delete<?=$idpesanan;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Pesanan <?=$namapelanggan;?></h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form method="post">

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    Konfirmasi penghapusan pesanan.
                                                    <input type="hidden" name="idpesanan" value="<?=$idpesanan;?>">
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="deletepesanan">Hapus</button>
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
            <h4 class="modal-title">Tambah Pesanan Baru</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form method="post">

        <!-- Modal body -->
        <div class="modal-body">
        Pilih Pelanggan
        <select name="idpelanggan" class="form-control">
            <?php 
            $ambilpelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");

            while($pelanggan = mysqli_fetch_array($ambilpelanggan)) {
                $namapelanggan = $pelanggan['namapelanggan'];
                $idpelanggan = $pelanggan['idpelanggan'];
                $alamat = $pelanggan['alamat'];
            
            ?>

            <option value="<?=$idpelanggan;?>">
            <?=$namapelanggan;?> - <?=$alamat;?>
            </option>

            <?php
            }
            ?>
        </select>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="tambahpesanan">Tambahkan</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batalkan</button>
        </div>
        </form>
    </div>    
    </div>
</div>
</html>