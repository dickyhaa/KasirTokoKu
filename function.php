<?php
//Memulai Query
session_start();

// buat koneksi 
$koneksi = mysqli_connect("localhost","root","","dbkasirtokoku");

//====Fungsi modal HALAMAN LOG IN====
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data user berdasarkan username
    $check = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    $user = mysqli_fetch_assoc($check);

    // Cek jika user ditemukan dan password cocok
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loginsuccess'] = 'True';
        header('location:index.php'); // Redirect ke halaman index.php
        exit;
    } else {
        echo '
        <script>
            alert("Username atau Password salah");
            window.location.href="login.php";  
        </script>
        ';
    }
}

//====Fungsi modal HALAMAN Registrasi====
if(isset($_POST['register'])) {
    $inputusername = htmlspecialchars($_POST['username']);
    $inputpassword = $_POST['password'];
    $inputpassword2 = $_POST['password2'];

    // Cek username sudah ada atau belum
    $result = mysqli_query($koneksi, "SELECT username FROM admin WHERE username = '$inputusername'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Maaf username sudah terdaftar!');</script>";
    } else {
        // Cek konfirmasi password
        if ($inputpassword !== $inputpassword2) {
            echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
        } else {
            // Enkripsi password
            $passwordHash = password_hash($inputpassword, PASSWORD_DEFAULT);

            // Tambahkan user baru ke database
            $query = "INSERT INTO admin (username, password) VALUES ('$inputusername', '$passwordHash')";
            mysqli_query($koneksi, $query);
            
            // Cek apakah query berhasil
            if (mysqli_affected_rows($koneksi) > 0) {
                echo "<script>alert('Registrasi berhasil!'); window.location='login.php';</script>";
            } else {
                echo "<script>alert('Registrasi gagal!');</script>";
            }
        }
    }
}

//====Fungsi modal HALAMAN STOK.php====
// Tambah stok produk
if(isset($_POST['tambahstok'])) {
    $namaproduk = $_POST['namaproduk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $insert = mysqli_query($koneksi,
    "INSERT INTO produk (namaproduk,harga,stok) VALUES ('$namaproduk','$harga','$stok')"
    );

    // Cek apakah data berhasil dimasukkan
    // Jika berhasil, redirect ke halaman stok.php
    if($insert) {
        header('location:stok.php');
    } else {
        echo '
        <script>
            alert("Gagal menambahkan stok");
            window.location.href="stok.php";
        </script>
        ';
    }
}

//====Fungsi modal HALAMAN PELANGGANG.php====
// Tambah pelanggan
if(isset($_POST['tambahpelanggan'])) {
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $insert = mysqli_query($koneksi,
    "INSERT INTO pelanggan (namapelanggan,notelp,alamat) VALUES ('$namapelanggan','$notelp','$alamat')"
    );

    if($insert) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>
            alert("Gagal menambahkan pelanggan");
            window.location.href="pelanggan.php";
        </script>
        ';
    }
}

//====Fungsi modal HALAMAN INDEX.php====
// Tambah pesanan
if(isset($_POST['tambahpesanan'])) {
    $idpelanggan = $_POST['idpelanggan'];

    $insert = mysqli_query($koneksi,
    "INSERT INTO pesanan (idpelanggan) VALUES ('$idpelanggan')"
    );

    if($insert) {
        header('location:index.php');
    } else {
        echo '
        <script>
            alert("Gagal menambahkan pesanan");
            window.location.href="index.php";
        </script>
        ';
    }
}

//====Fungsi modal HALAMAN VIEW.php====
// Pilih barang untuk ditambahkan ke pesanan
if(isset($_POST['pilihbarang'])) {
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp'];//idpesanan
    $qty = $_POST['qty'];//Jumlah barang yang ingin dipesan

    // Hitung stok sekarang ada berapa
    $hitung1 = mysqli_query($koneksi, "SELECT * FROM produk WHERE idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stoksekarang = $hitung2['stok']; // Stok sekarang

    if($stoksekarang>=$qty) {
        // Kurangi stok dengan jumlah yang dipilih
        $selisih = $stoksekarang - $qty;


        //Stok cukup
        $insert = mysqli_query($koneksi,
        "INSERT INTO detailpesanan (idpesanan,idproduk,qty)
        VALUES ('$idp', '$idproduk', '$qty')");

        $updatejumlah = mysqli_query($koneksi,
        "UPDATE produk SET stok='$selisih'
        WHERE idproduk='$idproduk'");

        if($insert && $updatejumlah) {
            header('location:view.php?idp='.$idp);
        } 
    } else {
        //Stok kurang
        echo '
            <script>
                alert("Stok barang tidak cukup");
                window.location.href="view.php?idp='.$idp.'";
            </script>
            ';
    }
}

//====Fungsi Modal HALAMAN BARANGMASUK.php====
// Tambah barang masuk
if (isset($_POST['masuk'])) {
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    // 1. Tambahkan ke tabel masuk
    $insertb = mysqli_query($koneksi, "INSERT INTO masuk (idproduk, qty) VALUES ('$idproduk','$qty')");

    if ($insertb) {
        // 2. Update stok di tabel produk
        $updateStok = mysqli_query($koneksi, "UPDATE produk SET stok = stok + $qty WHERE idproduk = '$idproduk'");

        if ($updateStok) {
            echo '
            <script>
            alert("Barang masuk berhasil ditambahkan dan stok diperbarui");
            window.location.href="barangmasuk.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Barang masuk berhasil, tapi gagal update stok");
            window.location.href="barangmasuk.php";
            </script>
            ';
        }
    } else {
        echo '
        <script>
        alert("Gagal menambahkan barang masuk");
        window.location.href="barangmasuk.php";
        </script>
        ';
    }
}

//====Fungsi modal HALAMAN VIEW.php====
// Hapus pilihan barang
if(isset($_POST['hapuspilihan'])) {
    $idp = $_POST['idp']; // iddetailpesanan
    $idpr = $_POST['idpr']; // idproduk
    $idpesanan = $_POST['idpesanan'];

    // Cek qty saat ini
    $cek1 = mysqli_query($koneksi, "SELECT * FROM detailpesanan WHERE iddetailpesanan='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //Cek stok saat ini
    $cek3 = mysqli_query($koneksi, "SELECT * FROM produk WHERE idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stokbarang = $cek4['stok'];

    $hitungstok = $stokbarang + $qtysekarang;

    $updatestok = mysqli_query($koneksi, "UPDATE produk SET stok='$hitungstok' WHERE idproduk ='$idpr'");
    $hapuspilihan = mysqli_query($koneksi, "DELETE FROM detailpesanan WHERE idproduk='$idpr' and iddetailpesanan='$idp'");

    if($updatestok&&$hapuspilihan) {
        header('location:view.php?idp='.$idpesanan);
    } else {
        echo '
            <script>
                alert("Gagal menghapus pilihan barang");
                window.location.href="view.php?idp='.$idpesanan.'";
            </script>
            ';
    }

}

// Fungsi modal editbarang HALAMAN STOK.php
if(isset($_POST['editbarang'])) {
    $namaproduk = $_POST['namaproduk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $idpr = $_POST['idpr']; //idproduk

    $query = mysqli_query($koneksi, "UPDATE produk 
    SET namaproduk='$namaproduk', harga='$harga', stok='$stok'
    WHERE idproduk='$idpr'");

    if ($query) {
        header('location:stok.php');
    } else {
        echo '
        <script>
            alert("Gagal mengubah barang");
            window.location.href="stok.php";
        </script>
        ';
    }
    
}

// Fungsi modal hapus barang HALAMAN STOK.php
if (isset($_POST['deletebarang'])) {
    $idpr = $_POST['idpr'];

    $query = mysqli_query($koneksi, "DELETE FROM produk WHERE idproduk='$idpr'");

    if ($query) {
        header('location:stok.php');
    } else {
        echo '
        <script>
            alert("Gagal menghapus barang");
            window.location.href="stok.php";
        </script>
        ';
    }
}

// Fungsi modal edit pelanggan di HALAMAN PELANGGAN.php
if(isset($_POST['editpelanggan'])) {
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $idpelanggan = $_POST['idpelanggan']; //idproduk

    $query = mysqli_query($koneksi, "UPDATE pelanggan 
    SET namapelanggan='$namapelanggan', notelp='$notelp', alamat='$alamat'
    WHERE idpelanggan='$idpelanggan'");

    if ($query) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>
            alert("Gagal mengubah data pelanggan");
            window.location.href="pelanggan.php";
        </script>
        ';
    }
    
}

// Fungsi modal delete pelanggan di HALAMAN PELANGGAN.php
if (isset($_POST['deletepelanggan'])) {
    $idpelanggan = $_POST['idpelanggan'];

    $query = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE idpelanggan='$idpelanggan'");

    if ($query) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>
            alert("Gagal menghapus pelanggan");
            window.location.href="pelanggan.php";
        </script>
        ';
    }
}

// Fungsi modal edit barang masuk di HALAMAN BARANGMASUK.php
if(isset($_POST['editdatabarangmasuk'])) {
    $jumlah = $_POST['jumlah'];
    $idm = $_POST['idm']; // id masuk
    $idproduk = $_POST['idproduk']; // id produk

    // Cek jumlah saat ini
    $cekjumlah1 = mysqli_query($koneksi, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $cekjumlah2 = mysqli_fetch_array($cekjumlah1);
    $jumlahsekarang = $cekjumlah2['qty'];

    // Cek stok saat ini
    $cekstok1 = mysqli_query($koneksi, "SELECT * FROM produk WHERE idproduk='$idproduk'");
    $cekstok2 = mysqli_fetch_array($cekstok1);
    $stoksekarang = $cekstok2['stok'];

    if($jumlah >= $jumlahsekarang) {
        // Kalau inputan user lebih besar atau sama dengan qty yang sekarang
        // Hitung selisih
        $selisih = $jumlah-$jumlahsekarang;
        $newstok = $stoksekarang+$selisih;
    } else {
        // Kalau inputan user lebih kecil  dengan qty yang sekarang
        // Hitung selisih
        $selisih = $jumlahsekarang-$jumlah;
        $newstok = $stoksekarang-$selisih;
        // CEK VALIDASI STOK TIDAK BOLEH MINUS
        if ($newstok < 0) {
            echo '<script>alert("Gagal mengubah data barang masuk: stok tidak boleh minus!");window.location.href="barangmasuk.php";</script>';
            exit;
        }
    }
    $query1 = mysqli_query($koneksi, "UPDATE masuk set qty='$jumlah' WHERE idmasuk='$idm'");
    $query2 = mysqli_query($koneksi, "UPDATE produk SET stok ='$newstok' WHERE idproduk='$idproduk'");

    if ($query1&&$query2) {
        header('location:barangmasuk.php');
    } else {
        echo '
        <script>
            alert("Gagal mengubah data barang masuk");
            window.location.href="barangmasuk.php";
        </script>
        ';
    }
}

// Fungsi modal hapus barang masuk di HALAMAN BARANGMASUK.php
if (isset($_POST['hapusdatabarangmasuk'])) {
    $idm = $_POST['idm']; // id masuk
    $idproduk = $_POST['idproduk']; // id produk

    // Cek jumlah saat ini
    $cekjumlah1 = mysqli_query($koneksi, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $cekjumlah2 = mysqli_fetch_array($cekjumlah1);
    $jumlahsekarang = $cekjumlah2['qty'];

    // Cek stok saat ini
    $cekstok1 = mysqli_query($koneksi, "SELECT * FROM produk WHERE idproduk='$idproduk'");
    $cekstok2 = mysqli_fetch_array($cekstok1);
    $stoksekarang = $cekstok2['stok'];

    // Hitung selisih
    $newstok = $stoksekarang-$jumlahsekarang;
    // CEK VALIDASI STOK TIDAK BOLEH MINUS
    if ($newstok < 0) {
        echo '<script>alert("Gagal menghapus data barang masuk: stok tidak boleh minus!");window.location.href="barangmasuk.php";</script>';
        exit;
    }
    $query1 = mysqli_query($koneksi, "DELETE FROM masuk WHERE idmasuk='$idm'");
    $query2 = mysqli_query($koneksi, "UPDATE produk SET stok ='$newstok' WHERE idproduk='$idproduk'");

    if ($query1&&$query2) {
        header('location:barangmasuk.php');
    } else {
        echo '
        <script>
            alert("Gagal menghapus data barang masuk");
            window.location.href="barangmasuk.php";
        </script>
        ';
    }
}

// Fungsi untuk modal delete pesanan di HALAMAN INDEX.php
if (isset($_POST['deletepesanan'])) {
    $idpesanan = $_POST['idpesanan'];

    $cekdetail = mysqli_query($koneksi, "SELECT * FROM detailpesanan dp WHERE idpesanan='$idpesanan'");

    while($cd=mysqli_fetch_array($cekdetail)) {
        // Balikkan stok barang
        $idproduk = $cd['idproduk'];
        $iddp = $cd['iddetailpesanan'];
        $qty = $cd['qty'];

        $cekstok1 = mysqli_query($koneksi, "SELECT * FROM produk WHERE idproduk='$idproduk'");
        $cekstok2 = mysqli_fetch_array($cekstok1);
        $stokbarang = $cekstok2['stok'];

        $stokbaru = $stokbarang + $qty;

        $updatestok = mysqli_query($koneksi, "UPDATE produk SET stok='$stokbaru' WHERE idproduk ='$idproduk'");

        // Hapus data detail pesanan
        $hapusdetailpesanan = mysqli_query($koneksi, "DELETE FROM detailpesanan WHERE iddetailpesanan='$iddp'");
    }
    // Redirect
    $query = mysqli_query($koneksi, "DELETE FROM pesanan WHERE idpesanan='$idpesanan'");

    if ($updatestok && $hapusdetailpesanan && $query) {
        header('location:index.php');
    } else {
        echo '
        <script>
            alert("Gagal menghapus pesanan");
            window.location.href="index.php";
        </script>
        ';
    }
}

//Fungsi modal untuk HALAMAN VIEW.php
if(isset($_POST['editpilihanbarang'])) {
    $qty = $_POST['qty'];
    $idpr = $_POST['idpr'];
    $iddp = $_POST['iddp'];
    $idp = $_POST['idp'];

    // Cek qty saat ini
    $cek1 = mysqli_query($koneksi, "SELECT * FROM detailpesanan WHERE iddetailpesanan='$iddp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //Cek stok saat ini
    $cek3 = mysqli_query($koneksi, "SELECT * FROM produk WHERE idproduk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stokbarangsekarang = $cek4['stok'];

    if($qty >= $qtysekarang){
        // Kalau inputan user lebih besar atau sama dengan qty yang sekarang
        // Hitung selisih
        $selisih = $qty - $qtysekarang;
        $stokbaru = $stokbarangsekarang - $selisih;

        $query1 = mysqli_query($koneksi, "UPDATE detailpesanan SET qty='$qty' WHERE iddetailpesanan='$iddp'");
        $query2 = mysqli_query($koneksi, "UPDATE produk set stok='$stokbaru' WHERE idproduk='$idpr'");

        if($query1 && $query2){
            header('location:view.php?idp='.$idp);
        } else {
            echo '
            <script>
                alert("Gagal memilih barang");
                window.location.href="view.php?idp='.$idp.'";
            </script>
            ';
        }

    } else {
        // Kalau inputan user lebih kecil
        // Hitung selisih
        $selisih = $qtysekarang - $qty ;
        $stokbaru = $stokbarangsekarang + $selisih;

        $query1 = mysqli_query($koneksi, "UPDATE detailpesanan SET qty='$qty' WHERE iddetailpesanan='$iddp'");
        $query2 = mysqli_query($koneksi, "UPDATE produk set stok='$stokbaru' WHERE idproduk='$idpr'");

        if($query1 && $query2){
            header('location:view.php?idp='.$idp);
        } else {
            echo '
            <script>
                alert("Gagal memilih baranag");
                window.location.href="view.php?idp='.$idp.'";
            </script>
            ';
        }
    }
}
?>