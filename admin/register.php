<?php

if(isset($_POST['register'])){
    include('../function.php'); // function

    // filter data yang diinputkan
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    // enkripsi password
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $role = 'admin';

    $url = "http://saahalla.my.id/uas_perpus/api/index.php";
    $data = [
        "accessToken" => "16022021-saahalla",
        "action" => "register",
        "username" => $username,
        "name" => $name,
        "email" => $email,
        "role" => $role,
        "password" => $password
    ];
    $json = json_encode($data);

    $result = post_data($url, $json);
    
    if($result["isSuccess"]==true) header("Location: ../login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Account</title>
    <!-- bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body class="bg-info">

<div class="container mt-2">
    <div class="row justify-content-center align-items-center" >
        <div class="col-md-4 p-4 rounded" style="background-color: lightsalmon">
            <div align="center" class="mb-4">
                <img src='https://kampus.antarbangsa.ac.id/pluginfile.php/1/theme_mb2nl/logo/1602325669/logo-antarbangsa-1024x355.png' alt='Logo STMIK 1Antar Bangsa' width='200px' height='80px' />
            </div>
            
            <h3>Silakan Masukkan Data Diri Anda</h3>
            <br>

            <form action="" method="POST">

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input class="form-control form-control-sm" type="text" name="name" placeholder="Nama kamu" />
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control form-control-sm" type="text" name="username" placeholder="Username" />
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control form-control-sm" type="email" name="email" placeholder="Alamat Email" />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control form-control-sm" type="password" name="password" placeholder="Password" />
                </div>

                <input type="submit" class="btn btn-success btn-block" name="register" value="Daftar" />
                <p>Sudah Mempunyai Akun? <a href="../login.php">Login</a></p>
            </form>
            
        </div>

    </div>
</div>

</body>
</html>