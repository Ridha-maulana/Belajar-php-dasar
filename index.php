<?php
// jalanakan session
session_start();

// cek apakah sudah login
if(!isset($_SESSION["login"]) ) {
    header("Location: login.php");
    die;
}

// Memanggil file functions
require 'functions.php';

// pagination 
// konfigurasi pembagian halaman dengan cara paginition
$jumlahDataPerhalaman = 7;

// --cara pertama --
// $result = mysqli_query($conn,"SELECT * FROM mahasiswa");
// $jumlahData = mysqli_num_rows($result);

// --cara kedua--
$jumlahData =count(query("SELECT * FROM mahasiswa"));


// --------------------------------------------------------------------------------------
// cara memecahkan halaman dengan cound - di bulatkan, floor - kebawah dan ceil - ke atas
$jumlahHalaman = ceil($jumlahData /$jumlahDataPerhalaman);
// kondisi denga operator ternari
$halamanAktif = ( isset($_GET["halaman"]) )? $_GET["halaman"] : 1;
// halaman = 2, awalData = 2 
// halaman = 3, awalData = 4
// algoritman jumlah halaman
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;



// if(isset($_GET["halaman"]) ) {
// // mencari tau halama aktif 
//     $halamanAktif = $_GET["halaman"];
// } else{
//     $halamanAktif = 1;
// }
// var_dump($halamanAktif);

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerhalaman");


// tombol cari di tekan 
if (isset($_POST["cari"]) ) {

    $mahasiswa = cari($_POST["keyword"]);
}
?>



<!DOCTYPE html>
<html >
<head>

    <title>Halama Admin</title>
</head>
<body>

<a href="logout.php">Logout </a>

        <h1>Daftar mahasiswa</h1>



<a href="tambah.php">Tambah Data Mahasiswa </a>
<br><br>

<form action="" method="post">
    <input type="text" name="keyword" size="40" autofocus placeholder="Masukkan keyword pencariaan...." autocomplete="off">
    <button type="submit" name="cari">Cari!</button>
    <br>
</form>
<br><br>
<!-- navigasi -->

<!-- membuta tanda <-   -->
<?php if($halamanAktif > 1 ) : ?>
    <a href="?halaman=<?= $halamanAktif -1 ?>">&laquo;;</a>
<?php endif; ?>


<!-- membuat angkat di halaman -->
<?php for($i = 1; $i <= $jumlahHalaman; $i++ ) : ?>

    <!-- membuat bout di angka halaman -->
    <?php if($i == $halamanAktif): ?>
        <a href="?halaman=<?= $i; ?>" style = "font-weight:bold; color:brown;"><?= $i; ?></a> 
    <?php else : ?>
        <a href="?halaman=<?= $i; ?>"><?= $i; ?></a> 
    <?php endif;?>
<?php endfor; ?>

<!-- membuta tanda ->   -->
<?php if($halamanAktif < $jumlahHalaman ) : ?>
    <a href="?halaman=<?= $halamanAktif +1 ?>">&raquo;</a>
<?php endif; ?>



    <br>

<table border="1" cellpading="10" cellspacing="0">

    <tr>
        <th>No.</th>
        <th>Aksi</th>
        <th>Gambar</th>
        <th>NAMA</th>
        <th>NRP</th>
        <th>Email</th>
        <th>Jurusan</th>
    </tr>

    <?php $i = 1; ?>
<?php foreach( $mahasiswa as $row ) : ?>
    <tr>

        <td><?= $i; ?></td>
        <td>
            <a href="ubah.php?id=<?= $row["id"];  ?>">Ubah</a> |
            <a href="hapus.php?id=<?= $row["id"];  ?>">Hapus</a>
        </td>
        <td><img src="img/<?= $row["gambar"];  ?>" width="50"</td>
        <td><?= $row["nama"]; ?></td>
        <td><?= $row["nrp"]; ?></td>
        <td><?= $row["email"]; ?></td>
        <td><?= $row["jurusan"]; ?></td>
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>

</table>

</body>
</html>