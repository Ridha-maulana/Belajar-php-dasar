<?php 
// koneksi ke database
$conn = mysqli_connect("Localhost", "root", "", "phpdasar");



function query($query) {
    global $conn;
$result = mysqli_query($conn, $query);
        $rows = [];
        while( $row = mysqli_fetch_assoc($result)) {
        $rows[] =$row;
    }
    return $rows;
}

function tambah($data) {
    global $conn;
    $nama = htmlspecialchars($data["nama"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars( $data["jurusan"]);

// upload gambar
    $gambar = upload();
        if(!$gambar) {
            return false;
        }    

// query inset "tanbah data " 
    $query ="INSERT INTO  mahasiswa 
            VALUES 
            ('', '$nama', '$nrp', '$email', '$jurusan', '$gambar')
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}


function upload() {

    $namafile = $_FILES['gambar']['name'];
    $ukuranfile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

// cek apakah tidak ada gambar yang upload
    if ($error === 4 ) {
        echo "<script>
            alert('Pilih gambar terlebih dahulu!');
            </script>";
        return false;
    }

//  cek apakah yang di upload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namafile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
        
    if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
            alert('Yang anda upload bukan gambar!');
            </script>";
            return false;

    }

// cek jika ukuran filenya terlalu besar 
    if($ukuranfile > 1000000 ) {
        echo "<script>
            alert('Ukuran gambar terlalu besar!');
            </script>";
        return false;
    }
// generate nama gambar baru  "agar file nama sama tidak tertimpah "   

$namafileBaru = uniqid();
$namafileBaru .='.';
$namafileBaru .= $ekstensiGambar;


// lolos pengecekan, gambar siap diupload
    move_uploaded_file($tmpName, 'img/' .$namafileBaru);

    return $namafileBaru;

}



    function hapus($id) {
        global $conn;
        mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}





function ubah($data) {

    global $conn;
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars( $data["jurusan"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek apakah user pilih gambar baru atau tidak
    if($_FILES['gambar']['error']==4 ) {
        $gambar = $gambarLama;
    } else {
    $gambar = upload();
        }   

// meninpa data baru di rubah 
    $query ="UPDATE mahasiswa SET
            nama = '$nama',
            nrp = '$nrp',
            email = '$email',
            jurusan = '$jurusan',
            gambar = '$gambar'
            WHERE id = $id
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}


function Cari($keyword) {
    $query = "SELECT * FROM mahasiswa
            WHERE
        nama LIKE '%$keyword%'OR 
        nrp LIKE '%$keyword% ' OR 
        email LIKE '%$keyword% 'OR
        jurusan LIKE '%$keyword%'
        ";
    return query($query);

}


function registrasi ($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);


    // username sudah ada apa belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username  = '$username'");

    if( mysqli_fetch_assoc($result)) {
    echo "<script>
            alert('Username sudah terdaftar!');
        </script>";
    return false;
}


    //  cek konfirmasi password
    if($password !== $password2) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
                </script>";
        return false;
    }
    
    // enkripsi password
    $password = password_hash($password2, PASSWORD_DEFAULT);

    //  tambah userbaru ke database
    mysqli_query($conn, "INSERT INTO user 
                    VALUES 
                    ('','$username', '$password')");
        return mysqli_affected_rows($conn);
    
}
?>