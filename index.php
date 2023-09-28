<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
require 'function.php';
// pagination

// Configurasi 
$jumlahDataPerHalaman = 2;
$jumlahData = count(query( 'SELECT * FROM mahasiswa'));
$jumlahHalaman = ceil($jumlahData/ $jumlahDataPerHalaman);
if (isset ($_GET['halaman'])){
$halamanAktif = $_GET['halaman'];
}else {
    $halamanAktif = 1;
}
$awalData = ($jumlahDataPerHalaman * $halamanAktif ) - $jumlahDataPerHalaman;


$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman");

// Jika Tombol Cari Di Klik

if(isset($_POST['cari'])){
    $mahasiswa = cari($_POST['keyword']);
}




 ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>
    <a href="logout.php">Logout</a>
    <h1>Daftar Mahasiswa</h1>
    <form action="" method="post" >
        <input type="text" name="keyword" autofocus placeholder="Cari Data Mahasiswa" autocomplete="off" size='50'>
        <button type="submit" name="cari">Cari</button>
    </form>
    <br>
    <!-- navigasi -->
    <?php if($halamanAktif > 1) : ?>
    <a href="?halaman=<?= $halamanAktif-1?>">&lt;</a>

    <?php endif;?>

    <?php for($i=1; $i<= $jumlahHalaman; $i++) : ?>
        <?php if($i == $halamanAktif) : ?>
        <a href="?halaman=<?= $i; ?>" style="font-weight:bold; color:red;"><?= $i; ?></a>
        <?php else : ?>
            <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
        <?php endif ; ?>
     <?php endfor;?>   
     <?php if($halamanAktif < $jumlahHalaman) : ?>
    <a href="?halaman=<?= $halamanAktif+1?>">&gt;</a>

    <?php endif;?>
    <br><br>

    <a href="tambah.php">Tambah Data</a>
    <table border="1" cellpadding ="10" cellspacing="0" >
    <tr>
        <td>No.</td>
        <td>Aksi</td>
        <td>Gambar</td>
        <td>NRP</td>
        <td>Nama</td>
        <td>Email</td>
        <td>Jurusan</td>
    </tr>
    <?php $i=1; ?>
    <?php foreach ($mahasiswa as $row) : ?>
    <tr>
        <td><?= $i++ ;?></td>
        <td>
            <a href="ubah.php?id=<?= $row['id'] ?>">Edit</a> | 
            <a href="hapus.php?id=<?= $row['id'];?>" onclick="return confirm('Yakin?.')">Delete</a>
        </td>
        <td><img src="img/<?= $row['gambar'] ?>"width="50" alt=""></td>
        <td><?= $row['nrp'] ?></td>
        <td><?= $row['nama'] ?></td>
        <td><?= $row['jurusan'] ?></td>
        <td><?= $row['prodi'] ?></td>
    </tr>
        <?php endforeach ; ?>


    </table>
    
</body>
</html>