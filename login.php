<?php 

// include('api/index.php');
$error_msg = "";
$old_username = "";

if(isset($_POST['login'])){
    include('function.php'); // function
    
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $url = "http://saahalla.my.id/uas_perpus/api/index.php";
    $data = [
        "accessToken" => "16022021-saahalla",
        "action" => "login",
        "username" => $username,
        "password" => $password
    ];
    $json = json_encode($data);

    $result = post_data($url, $json);

    if($result["isSuccess"] == true){
        // buat Session
        $user_data = $result["data"];
        session_start();
        $_SESSION["user"] = $user_data;
        // echo "login";
        // login sukses, alihkan ke halaman timeline
        header("Location: index.php");
    }else{
        if($result["message"] == "user not found"){
            $error_msg = "Username atau email Anda belum terdaftar, silahkan mendaftar terlebih dahulu.";
        }else{
            $error_msg = "Password Anda salah, silahkan masukkan kembali password Anda.";
            $old_username = $result["last_username"];
        }
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Perpus</title>

    <!-- bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="bg-info">

<div class="container mt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-4 p-4 rounded" style="background-color: lightsalmon">

        <div align="center" class="mb-4">
            <img src='https://kampus.antarbangsa.ac.id/pluginfile.php/1/theme_mb2nl/logo/1602325669/logo-antarbangsa-1024x355.png' alt='Logo STMIK 1Antar Bangsa' width='200px' height='80px' />
        </div>
        
        <h3>Silakan Masuk</h3>

        <form action="" method="POST">
            <?php
                if($error_msg!=""){
                    echo "<p class='bg-danger mt-2'>$error_msg</p>";
                }
            ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control" type="text" name="username" placeholder="Username atau email" value="<?php echo $old_username != "" ? $old_username:''  ?>"/>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Password" />
            </div>

            <input type="submit" class="btn btn-success btn-block" name="login" value="Masuk" />
            
            <p>Mau Mendaftar Akun? <a href="register.php">Register</a></p>
            

        </form>
            
        </div>

    </div>
</div>
    
</body>
</html>