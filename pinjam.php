<?php

    include('function.php');
    // get id from URL
    $id = $_GET["id"];

    // api get data buku by ID
    $url = "http://saahalla.my.id/uas_perpus/api/index.php";
    $data = [
        "accessToken" => "16022021-saahalla",
        "action" => "getDataBukuById",
        "data" => "buku",
        "id" => $id,
    ];
    $json = json_encode($data);
    
    $result = post_data($url, $json);
    // echo json_encode($data_buku);
    if($result["isSuccess"]==true){
        $data_buku = $result["data"]["0"];
    }

    $id = $data_buku["id"];
    $judul = $data_buku["judul_buku"];
    $pengarang = $data_buku["pengarang"];
    $jenis = $data_buku["jenis_buku"];
    $penerbit = $data_buku["penerbit"];
    $tahun = $data_buku["tahun_terbit"];
    $image = $data_buku["image"];

    session_start();
    // print_r($_SESSION["user"]);
    $users= $_SESSION["user"];
    $nama = $users["name"];
    $email = $users["email"];
    $id_user = $users["id"];
    $date = date("d M, Y");
    $date_db = date("Y-m-d");

    // api add Data Peminjaman
    $url = "http://saahalla.my.id/uas_perpus/api/index.php";
    $data = [
        "accessToken" => "16022021-saahalla",
        "action" => "addDataPinjam",
        "date" => $date_db,
        "id" => $id,
        "id_user" => $id_user
    ];
    $json = json_encode($data);

    $result = post_data($url, $json);
    
    
    // print_r($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pinjam Buku</title>

    <!-- bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="bg-info">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 justify-content-center align-items-center mt-2" style="background-color: lightsalmon; height: 100%;">
            <div align="center" class="mb-4 mt-4">   
                <img src='https://kampus.antarbangsa.ac.id/pluginfile.php/1/theme_mb2nl/logo/1602325669/logo-antarbangsa-1024x355.png' alt='Logo STMIK 1Antar Bangsa' width='200px' height='80px' />
                <h3>Selamat Datang di Perpustakaan STMIK AB</h3>
                
            </div>
            <a href="add.php" class="btn btn-info mb-4">Tambah buku</a>
            <a href="index.php" class="btn btn-info mb-4">Lihat data buku</a>
            <a href="pinjam_show.php" class="btn btn-info mb-4">Lihat Data Peminjaman</a>


            <div>
                <h3>Data Peminjaman <?php echo $judul ?></h3>
                <p>
                    <b>Data Peminjam : </b> <br>
                    Nama Peminjam : <?php echo $nama ?><BR>
                    Email : <?php echo $email ?> <br>
                    Tanggal Pinjam : <?php echo $date ?> <br><br>

                    <b>Data buku :</b> <br>
                    <?php
                        if($image!=""){ 
                            echo "<img class='mb-4 rounded' src='uploads/".$image."' alt='' width='200' height='260'>";
                        } 
                    ?>
                    <br>
                    Pengarang : <?php echo $pengarang ?><br>
                    Jenis Buku : <?php echo $jenis ?><br>
                    Nama Penerbit : <?php echo $penerbit ?><br>
                    Tahun Terbit : <?php echo $tahun ?><br>
                </p>
            </div>

        </div>
    </div>

</body>
</html>