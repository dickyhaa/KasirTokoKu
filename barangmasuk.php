<?php
    require 'ceklogin.php';
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
                            <a class="nav-link active" href="barangmasuk.php">
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
                        <h1 class="mt-4">Data Barang Masuk</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Stok barang hari ini</li>
                        </ol>

                        <!-- Tombol untuk membuka modal, kode modal ada di bawah -->
                        <button type="button" class="btn btn-info mb-3" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Barang Masuk
                        </button>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Barang Masuk
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>                                    
                                    <tbody>
                                        <?php
                                        //Memasukkan semua data dari tabel produk ke variabel ambil
                                            $ambil = mysqli_query($koneksi, "SELECT * FROM masuk m, produk p WHERE m.idproduk = p.idproduk");
                                            $i = 1; //Digunakan sebagai penomoran, karena penambahan while loop (iterasi)

                                        //Selama variabel produk memiliki nilai, tampilkan data ke website
                                        //Start of while
                                            while($produk = mysqli_fetch_array($ambil)) {
                                                $namaproduk = $produk['namaproduk'];
                                                $jumlah = $produk['qty'];
                                                $tanggal = $produk['tanggalmasuk'];

                                        ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namaproduk;?></td>
                                            <td><?=$jumlah;?></td>
                                            <td><?=$tanggal;?></td>
                                            <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idproduk;?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idproduk;?>">
                                                Delete
                                            </button>
                                            </td>
                                        </tr>

                                            <!-- Modal untuk fungsi Edit -->
                                            <div class="modal fade" id="edit<?=$idproduk;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit <?=$namaproduk;?></h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form method="post">

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <input type="text" name="namaproduk" id="" class="form-control" placeholder="Nama Barang" value="<?=$namaproduk;?>">
                                                    <input type="num" name="harga" id="" class="form-control mt-2" placeholder="Harga Barang" value="<?=$harga;?>">
                                                    <input type="num" name="stok" id="" class="form-control mt-2" placeholder="Stok" value="<?=$stok;?>">
                                                    <input type="hidden" name="idpr" value="<?=$idproduk;?>">
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="editbarang">Ubah</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batalkan</button>
                                                </div>

                                                </form>

                                                </div>    
                                            </div>
                                            </div>

                                                <!-- Modal untuk fungsi Delete -->
                                            <div class="modal fade" id="delete<?=$idproduk;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus <?=$namaproduk;?></h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form method="post">

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    Konfirmasi penghapusan jenis Barang.
                                                    <input type="hidden" name="idpr" value="<?=$idproduk;?>">
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="deletebarang">Hapus</button>
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
        <h4 class="modal-title">Pilih Barang</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <form method="post">

    <!-- Modal body -->
    <div class="modal-body">
        <select name="idproduk" class="form-control">
            <?php 
            $ambilproduk = mysqli_query($koneksi, 
                "SELECT * FROM produk");
                

            while($produk = mysqli_fetch_array($ambilproduk)) {
                $idproduk = $produk['idproduk'];
                $namaproduk = $produk['namaproduk'];

            
            ?>

            <option value="<?=$idproduk;?>">
                <?=$namaproduk;?> (<?=$produk['stok'];?> Stok) 
            </option>

            <?php
            } 
            ?>

        </select>
        <input type="number" name="qty" class="form-control mt-2" placeholder="Jumlah" min="1" required>
        </div>

    <!-- Modal footer -->
    <div class="modal-footer">
        <button type="submit" class="btn btn-success" name="masuk">Tambahkan</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batalkan</button>
    </div>

    </form>

    </div>    
</div>

</html>
