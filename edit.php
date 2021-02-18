<?php

    if(isset($_POST['update'])){
        $id = $_POST["id"];
        $judul = $_POST["judul"];
        $pengarang = $_POST["pengarang"];
        $jenis = $_POST["jenis"];
        $penerbit = $_POST["penerbit"];
        $tahun = $_POST["tahun"];

        // include('api/index.php');
        include('function.php');
        $image = upload_image($_FILES);
        $update_at = date("Y-m-d H:i:s");

        $url = "http://saahalla.my.id/uas_perpus/api/index.php";
        $data = [
            "accessToken" => "16022021-saahalla",
            "action" => "editBuku",
            "id" => $id,
            "judul" => $judul,
            "pengarang" => $pengarang,
            "jenis" => $jenis,
            "penerbit" => $penerbit,
            "tahun" => $tahun,
            "image" => $image,
            "update_at" => $update_at
        ];
        $json = json_encode($data);
        
        $result = post_data($url, $json);
        
        if($result["isSuccess"]==true){
            header("Location: index.php");
        }
        
        // echo $query;
        // die();
        print_r($result);
        header("Location: index.php");

    }else{
        // include('api/index.php');
        // get id from URL
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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json"
        ));
        $result = curl_exec($ch);

        // echo $result;
        // die();
        curl_close($ch);
        $result = json_decode($result, true);
        // echo json_encode($data_buku);
        if($result["isSuccess"]==true){
            $data_buku = $result["data"]["0"];
        }
        // $data_buku = $data[0];
        
        $judul = $data_buku["judul_buku"];
        $pengarang = $data_buku["pengarang"];
        $jenis = $data_buku["jenis_buku"];
        $penerbit = $data_buku["penerbit"];
        $tahun = $data_buku["tahun_terbit"];
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Buku</title>
    <!-- bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body class="bg-info">

<div class="container mt-2">
    <div class="row justify-content-center align-items-center" >
        <div class="col-md-6 p-4 rounded" style="background-color: lightsalmon">
            <div align="center" class="mb-4">
                <img src='https://kampus.antarbangsa.ac.id/pluginfile.php/1/theme_mb2nl/logo/1602325669/logo-antarbangsa-1024x355.png' alt='Logo STMIK 1Antar Bangsa' width='200px' height='80px' />
            </div>
            
            <h3>Edit Daftar Buku</h3>
            <br>

            <form action="" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="judul">Judul Buku</label>
                    <input class="form-control form-control-sm" type="text" name="judul" placeholder="Judul Buku" value="<?php echo $judul ?>"/>
                </div>

                <div class="form-group">
                    <label for="pengarang">Pengarang</label>
                    <input class="form-control form-control-sm" type="text" name="pengarang" placeholder="Nama Pengarang" value="<?php echo $pengarang ?>" />
                </div>

                <div class="form-group">
                    <label for="jenis">Jenis Buku</label>
                    <select class="custom-select form-control form-control-sm" id="jenis" name="jenis" value="<?php echo $jenis ?>">
                        <option selected>Umum</option>
                        <option value="Bahasa">Bahasa</option>
                        <option value="Jaringan">Jaringan</option>
                        <option value="Pemrograman">Pemrograman</option>
                        <option value="Server">Server</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="penerbit">Penerbit</label>
                    <input class="form-control form-control-sm" type="text" name="penerbit" placeholder="Nama Penerbit" value="<?php echo $penerbit ?>"/>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun Terbit</label>
                    <input class="form-control form-control-sm" type="text" name="tahun" placeholder="Tahun Terbit" value="<?php echo $tahun ?>" />
                    <input style="display: none;" type="text" name="id" value="<?php echo $id ?>" />
                </div>
                <div class="form-group">
                    <label for="image">Upload Gambar</label>
                    <input class="form-control form-control-sm" type="file" name="image" placeholder="upload" accept="image/*"/>
                </div>


                <input type="submit" class="btn btn-success btn-block" name="update" value="Edit" />
               
            </form>
            
        </div>

    </div>
</div>

</body>
</html>