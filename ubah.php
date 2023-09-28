<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
require 'function.php';
$id = $_GET['id'];

$mhs= query("SELECT * FROM mahasiswa WHERE id = $id" )[0];

if (isset($_POST['submit'])) {
   

    // Perbaikan query SQL (tambahkan single quote dan perbaiki sintaks)
   
    // Periksa apakah query berhasil dijalankan
    if (ubah($_POST)> 0 ) {
        echo "<script>alert('Data Berhasil Di Ubah') 
                document.location.href='index.php'        
                </script>";
    } else {
        echo "<script> Data Gagal Di Ubah </script>
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
                <input type="hidden" value="<?= $mhs['id'] ?>" id="id" name="id" >
                <input type="hidden" value="<?= $mhs['gambar'] ?>"  name="gambarLama" >
            <li>
                <Label for="nrp">Nrp</Label>
                <input type="text" value="<?= $mhs['nrp'] ?>" id="nrp" name="nrp" required>
            </li>
            <li>
                
                <Label for="gambar">Gambar</Label>
                <img src="img/<?= $mhs['gambar'] ?>" width='50' alt="">
                <input type="file" id="gambar"  name="gambar" >

            </li>
            <li>
                <Label for="nama">Nama</Label>
                <input type="text" name="nama" id="nama" value="<?= $mhs['nama'] ?>">
            </li>
            <li>
                <Label for="email">Email</Label>
                <input type="email" id="email" name="email" value="<?= $mhs['email'] ?>">
            </li>
            <li>
                <Label for="jurusan">Jurusan</Label>
                <input type="jurusan" id="jurusan" name="jurusan" value="<?= $mhs['jurusan'] ?>">
            </li>
            <li>
                <Label for="prodi">Prodi</Label>
                <input type="prodi" id="prodi" name="prodi" value="<?= $mhs['prodi'] ?>">
            </li>
            <li><button type="submit" name="submit">Kirim</button></li>
            </ul>



    </form>
</body>
</html>