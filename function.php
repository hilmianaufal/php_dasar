<?php
$conn = mysqli_connect('localhost','root', '', 'phpdasar');

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row= mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data){
    global $conn;
    $nrp = htmlspecialchars ($data['nrp']);
 

    $nama = htmlspecialchars ($data['nama']);
    $email = htmlspecialchars ($data['email']);
    $jurusan = htmlspecialchars ($data['jurusan']);
    $prodi =htmlspecialchars ( $data['prodi']);

    // upload gambar
    $gambar = upload();
    if(!$gambar){
        return false;
    }

    $query = "INSERT INTO mahasiswa (nrp, gambar, nama, email, jurusan, prodi) 
    VALUES ('$nrp', '$gambar', '$nama', '$email', '$jurusan', '$prodi')";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}

function upload() {
    $namaFile= $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];
    // cek apakah tidak ada Gambar yang di upload
    if($error === 4){
        echo "<script> alert('Pilih Gambar Terlebih Dahulu') </script>";
        return false;
    }
    // cek apakah yang di upload adalah gambar
    $extensiGambarValid = ['jpg','jpeg','png'];
    $extensiGambar = explode(".", $namaFile);
    $extensiGambar = strtolower(end($extensiGambar));

    if (!in_array($extensiGambar,$extensiGambarValid)){
        echo "<script> alert('Yang di Upload Bukan Gambar') </script>";
        return false;
    }

    // cek Jika Ukurannya Terlalu Besar 
    if ($ukuranFile > 1000000){
        echo "<script> alert('Ukuran Gambar Terlalu Besar') </script>";
        return false;
    }

    // lolos Pengecekan Gambar Siap Di upload
    // generete Gambar Baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensiGambar;
    move_uploaded_file($tmpName,'img/'. $namaFileBaru);
    return $namaFileBaru;
}





function hapus($id){
    global $conn;
    mysqli_query($conn,"DELETE FROM mahasiswa WHERE id=$id");
    return mysqli_affected_rows($conn);
}

function ubah($data){
    global $conn;
    $id = $data['id'];
    $nrp = htmlspecialchars ($data['nrp']);
    $nama = htmlspecialchars ($data['nama']);
    $email = htmlspecialchars ($data['email']);
    $jurusan = htmlspecialchars ($data['jurusan']);
    $prodi =htmlspecialchars ( $data['prodi']);
    $gambarLama  = htmlspecialchars ($data['gambarLama']);

    // cek Apakah User Pilih Gambar Baru Atau Tidak
    if($_FILES['gambar']['error'] === 4){
        $gambar = $gambarLama;
    }else{
    
    $gambar = upload();
    }
    $query = "UPDATE mahasiswa SET 
                nrp='$nrp',
                gambar = '$gambar',
                nama= '$nama',
                email = '$email',
                jurusan = '$jurusan',
                prodi = '$prodi'
                WHERE id = $id";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}

function registrasi($data){
    global $conn;
    $username = strtolower (stripslashes ( $data['username']));
    $password = mysqli_real_escape_string($conn,$data ['password']);
    $password2 = mysqli_real_escape_string($conn,$data ['password2']);

    // cek Username Sudah Ada Atau Belum
    $result=mysqli_query($conn, "SELECT username FROM user WHERE username='$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>alert('Username Sudah Terdaftar')</script>";
        return false;
    }
    // cek Konfirmasi Password 
    if ($password !== $password2 ) {
        echo "<script> alert('Konfirmasi Password Tidak Sesuai') </script>";
        return false;
    }else{
        $password = password_hash($password, PASSWORD_DEFAULT);
    
        mysqli_query($conn, "INSERT INTO user(username,password) VALUES('$username','$password')");
        return mysqli_affected_rows($conn);
        
    }

    // enkripsi Password


    // tambahkan User Ke Database
}

function cari ($keyword){
    $query ="SELECT * FROM mahasiswa WHERE
    
            nama LIKE '%$keyword%'OR
            nrp LIKE '%$keyword%'OR
            email LIKE '%$keyword%' OR
            jurusan LIKE '%$keyword%'OR
            prodi LIKE '%$keyword%'
            
            
            ";
    return query($query);
}