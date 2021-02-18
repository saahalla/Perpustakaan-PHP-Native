 <?php

    if(isset($_POST['add'])){
        $judul = strip_tags($_POST["judul"]);
        $pengarang = strip_tags($_POST["pengarang"]);
        $jenis = strip_tags($_POST["jenis"]);
        $penerbit = strip_tags($_POST["penerbit"]);
        $tahun = strip_tags($_POST["tahun"]);

        // include('api/index.php');
        include('function.php');
        if(!empty($_FILES["image"]["tmp_name"])){
            $image = upload_image($_FILES);
        }else{
            $image = "";
        }

        $timestamp = date("Y-m-d H:i:s");
        
        $url = "http://saahalla.my.id/uas_perpus/api/index.php";
        $data = [
            "accessToken" => "16022021-saahalla",
            "action" => "addBuku",
            "judul" => $judul,
            "pengarang" => $pengarang,
            "jenis" => $jenis,
            "penerbit" => $penerbit,
            "tahun" => $tahun,
            "image" => $image,
            "timestamp" => $timestamp
        ];
        $json = json_encode($data);
        
        $result = post_data($url, $json);
        
        if($result["isSuccess"]==true){
            header("Location: index.php");
        }
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menambah Data Buku</title>
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
            
            <h3>Menambah Daftar Buku</h3>
            <a href="index.php" class="btn btn-sm mt-2 btn-info mb-2">Lihat data buku</a>
            <br>

            <form action="" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="judul">Judul Buku</label>
                    <input class="form-control form-control-sm" type="text" name="judul" placeholder="Judul Buku" required/>
                </div>

                <div class="form-group">
                    <label for="pengarang">Pengarang</label>
                    <input class="form-control form-control-sm" type="text" name="pengarang" placeholder="Nama Pengarang" required/>
                </div>

                <div class="form-group">
                    <label for="jenis">Jenis Buku</label>
                    <select class="custom-select form-control form-control-sm" id="jenis" name="jenis">
                        <option selected>Umum</option>
                        <option value="Bahasa">Bahasa</option>
                        <option value="Jaringan">Jaringan</option>
                        <option value="Pemrograman">Pemrograman</option>
                        <option value="Server">Server</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="penerbit">Penerbit</label>
                    <input class="form-control form-control-sm" type="text" name="penerbit" placeholder="Nama Penerbit" required/>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun Terbit</label>
                    <input class="form-control form-control-sm" type="text" name="tahun" placeholder="Tahun Terbit" required/>
                </div>
                <div class="form-group">
                    <label for="image">Upload Gambar</label>
                    <input class="form-control form-control-sm" type="file" name="image" placeholder="upload" accept="image/*"/>
                </div>

                <input type="submit" class="btn btn-success btn-block" name="add" value="Tambah" />
               
            </form>
            
        </div>

    </div>
</div>

</body>
</html>