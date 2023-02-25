<?php 
// jalanakan session
session_start();

// cek apakah sudah login
if(!isset($_SESSION["login"]) ) {
    header("Location: login.php");
    die;
}

require 'functions.php';

$id =  $_GET["id"];


if( hapus($id) > 0 ) {
echo "
        <script> 
            alert('data berhasil di hapus!');
            document.location.href = 'index.php';
        </script>
    ";

} else {
    echo "
    <script> 
        alert('data gagal di hapus!');
        document.location.href = 'index.php';
    </script>
    ";
    }
?>