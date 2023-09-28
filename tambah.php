<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
require 'function.php';

if (isset($_POST['submit'])) {
   

    // Perbaikan query SQL (tambahkan single quote dan perbaiki sintaks)
   
    // Periksa apakah query berhasil dijalankan
    if (tambah($_POST)> 0 ) {
        echo "<script>alert('Data Berhasil Di Tambahkan') 
                document.location.href='index.php'        
                </script>";
    } else {
        echo "<script> Data Gagal Di Tambahkan </script>
        document.location.href = 'index.php'      
        ";
    }
}

// Jangan lupa menutup koneksi
mysqli_close($conn);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
</head>
<body>
    <h1>Tmmbah Data Mahasiswa</h1>
    <form action="" method= "post" enctype="multipart/form-data">
        <ul>
            <li>
                <Label for="nrp">Nrp</Label>
                <input type="text" id="nrp" name="nrp" required>
            </li>
            <li>
                <Label for="gambar">Gambar</Label>
                <input type="file" id="gambar" name="gambar" >
            </li>
            <li>
                <Label for="nama">Nama</Label>
                <input type="text" name="nama" id="nama">
            </li>
            <li>
                <Label for="email">Email</Label>
                <input type="email" id="email" name="email">
            </li>
            <li>
                <Label for="jurusan">Jurusan</Label>
                <input type="jurusan" id="jurusan" name="jurusan">
            </li>
            <li>
                <Label for="prodi">Prodi</Label>
                <input type="prodi" id="prodi" name="prodi">
            </li>
            <li><button type="submit" name="submit">Kirim</button></li>
            </ul>



    </form>
</body>
</html>