<?php
    include('function.php'); // function
    $id = $_GET["id"];
    // $data = getDataById("buku", $id);

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show buku</title>

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

            <div>
                <h3>Show <?php echo $judul ?></h3>
                <?php
                    if($image!=""){ 
                        echo "<img class='mb-4 rounded' src='uploads/".$image."' alt='' width='200' height='260'>";
                    } 
                ?>
                
                <p>
                    Pengarang : <?php echo $pengarang ?><br>
                    Jenis Buku : <?php echo $jenis ?><br>
                    Nama Penerbit : <?php echo $penerbit ?><br>
                    Tahun Terbit : <?php echo $tahun ?><br>
                </p>
            </div>
            <a href="pinjam.php?id=<?php echo $id?>" class="btn btn-info mb-4">Pinjam</a>

        </div>
    </div>

</body>
</html>