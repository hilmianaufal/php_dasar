<?php
session_start();
require 'function.php';
if (isset($_COOKIE['id'])&&$_COOKIE['key']){
             $id = $_COOKIE['id'];
             $key = $_COOKIE['key'];

             $result = mysqli_query($conn,"SELECT * FROM user WHERE id=$id");
             $row = mysqli_fetch_assoc($result);

             if ($key === hash('sha256', $row['username'])){
                $_SESSION['login']= true;
             }
    }

if(isset($_SESSION['login'])){
    header("Location: index.php");
    exit;
}



if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn,"SELECT * FROM user WHERE username='$username'");
    // cek Username
    if(mysqli_num_rows($result)=== 1){

        // cek Password 

        $row = mysqli_fetch_assoc($result);
       if( password_verify($password,$row['password'])){
        // set Session
        $_SESSION['login']=true;
        // cek Remember me
        if(isset($_POST['remember'])){
            
            setcookie('id',$row['id'], time()+60);
            setcookie('key',hash('sha256', $row['username']), time()+60);
        }

        header ("Location: index.php");

        exit;
       }
    }
    $error = true;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
</head>
<body>
    <h1>Halaman Login</h1>
    <?php if(isset($error)) : ?>
        <p style="color:red; font-style: italic;">Username atau Password Salah</p>
    <?php endif ; ?>
    <form action="" method="post">

    <ul>
        <li>
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
        </li>
        <li>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </li>
        <li>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Remember me</label>
        </li>
        <li>
            <button type="submit" name="login">Masuk</button>
        </li>
    </ul>

    </form>
</body>
</html>