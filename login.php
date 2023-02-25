<?php 
// jalankan sesesion
session_start();
require 'functions.php';

// cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
      $id = $_COOKIE['id'];
      $key = $_COOKIE['key'];


// ambil username berdasarkan id
      $result =mysqli_query($conn, "SELECT username FROM user WHERE 
            id = $id");
      $row = mysqli_fetch_assoc($result);

      // cek cookie da username 
      if( $key == hash('sha256', $row['username']) ) {
            $_SESSION['login'] = true;
      }


}

// cek apakah sudah login
if( isset($_SESSION["login"]) ) {
      header("Location: login.php");
      die;
}



// cek apakah tombol login sudah di tekan 
if(isset($_POST["login"]) ) {

$username = $_POST["username"];
$password = $_POST["password"];



$result= mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'" );

// cek username
if(mysqli_num_rows($result)  === 1 ) {

      // cek password 
            $row = mysqli_fetch_assoc($result);
                  if( password_verify($password, $row["password"]) ) {
                        // set sesion
                        $_SESSION["login"] = true;

                        // cek remember me

                        if( isset($_POST['remember']) ) {
                              // buat cookie
                              setcookie('id',$row['id'], time()+60);
                              setcookie('key', hash('sha256',$row['password']), time()+60);

                        }
                        header("Location: index.php");
                        die;
            }
      }
      $error = true;

}

?>



<!DOCTYPE html>
<html >
<head>
      <title>Halman Login</title>
</head>
<body>
<h1>Halaman Login</h1>
<?php  if(isset($error)) : ?>
      <p style="color: red; font-style: italic">username / password salah</p>
<?php endif; ?>

<form action="" method="post">
      <ul>
            <li>
                  <label for="username" >Usermane :</label>
                  <input type="text" name="username" id="username">
            </li>
            <li>
                  <label for="password">Password :</label>
                  <input type="password" name="password" id="password">
            </li>
            <li>
                  <input type="checkbox" name="remember" id="remember">
                  <label for="remember">Remember me</label>
            </li>
            <li>
                  <button type="submit" name="login">Login :</button>
            </li>
      </ul>


</form>
</body>
</html>