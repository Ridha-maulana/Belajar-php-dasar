<?php 
// jalanakan session
session_start();

// cek apakah sudah login
if(!isset($_SESSION["login"]) ) {
       header("Location: login.php");
       die;
}

require 'functions.php';

// ambil data di URL
$id = $_GET["id"];

// query data mahasiswa berdasarkan id [0] adalah nomor pertama di array numerik [0],['jurusan']
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];


// cek apakah tombol submit sudah di tekan 
if(isset($_POST["submit"])) {



       // cek apakah data berhasil di ubah atau tidak

       if( ubah($_POST) > 0 ) {
       echo "
              <script> 
                     alert('Data berhasil di ubah!');
                     document.location.href = 'index.php';
              </script>
       ";

} else {
       echo "
       <script> 
              alert('Data gagal di ubah!');
              document.location.href = 'index.php';
       </script>
       ";
       }
}
?>

<!DOCTYPE html>
<html >
<head>
       <meta charset="UTF-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Ubah Data Mahasiswa</title>
       <style>
              label {
              display: block;
              }
       </style>
</head>
<body>
       <h1> Ubah Data mahasiswa</h1>

       <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
              <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"]; ?>">
       <ul>
              <li>
                     <label for="nama"> Nama : </label>
                     <input type="text" name="nama" id="nama" 
                     value="<?= $mhs["nama"]; ?>">
              </li>
              <li>
                     <label for="nrp"> NRP : </label>
                     <input type="text" name="nrp" id="nrp" 
                     value="<?= $mhs["nrp"]; ?>">
              </li>
              <li>
                     <label for="email"> Email : </label>
                     <input type="text" name="email" id="email" 
                     value="<?= $mhs["email"]; ?>">
              </li>
              <li>
                     <label for="jurusan"> Jurusan : </label>
                     <input type="text" name="jurusan" id="jurusan" 
                     value="<?= $mhs["jurusan"]; ?>"> 
              </li>
              <li>
                     <label for="gambar"> Gambar : </label> <br>
                     <img src="img/<?= $mhs['gambar']; ?>"  width="40"><br>
                     <input type="file" name="gambar" id="gambar" >
              </li>
              <li>
                     <button type="submit" name="submit"> Ubah Data! </button>
              </li>
       </ul>

</form>

</body>
</html>