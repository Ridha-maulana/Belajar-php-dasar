<?php 

// jalanakan session
session_start();

// cek apakah sudah login
if(!isset($_SESSION["login"]) ) {
    header("Location: login.php");
    die;
}

require 'functions.php';
// cek apakah tombol submit sudah di tekan 
if(isset($_POST["submit"])) {

        // cek apakah data berhasil di tambah atau tidak
    if( tambah($_POST) > 0 ) {
    echo "
        <script> 
            alert('Data berhasil di tambahkan!');
            document.location.href = 'index.php';
        </script>
    ";

} else {
    echo "
    <script> 
        alert('Data gagal di tambahkan!');
        document.location.href = 'index.php';
    </script>
    ";
    }
}
?>

<!DOCTYPE html>
<html >
<head>
    
    <title>Tambah Data Mahasiswa</title>
    <style>
            label {
                display: block;
            }
    </style>
</head>
<body>
    <h1> Tambah Data mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
    <ul>
        <li>
            <label for="nama"> Nama : </label>
            <input type="text" name="nama" id="nama" required autocomplete="off" >
        </li>
        <li>
            <label for="nrp"> NRP : </label>
            <input type="text" name="nrp" id="nrp" required autocomplete="off">
        </li>
        <li>
            <label for="email"> Email : </label>
            <input type="text" name="email" id="email"  required autocomplete="off">
        </li>
        <li>
            <label for="jurusan"> Jurusan : </label>
            <input type="text" name="jurusan" id="jurusan" required autocomplete="off" >
        </li>
        <li>
            <label for="gambar"> Gambar : </label>
            <input type="file" name="gambar" id="gambar"   >
        </li>
        <li>
            <button type="submit" name="submit"> Tambah Data! </button>
        </li>
    </ul>

    </form>

</body>
</html>