<?php
    $url = "http://saahalla.my.id/uas_perpus/api/index.php";
    $data = [
        "accessToken" => "16022021-saahalla",
        "action" => "getAllData",
        "data" => "buku",
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

    echo $result;
    // die();
    curl_close($ch);
    $result = json_decode($result, true);
    
    if($result["isSuccess"]=="true"){
        $array = $result["data"];
    }

    ?>
    <?php

session_start();
if(!isset($_SESSION["user"])) header("Location: login.php");

include('function.php'); // function

$url = "http://saahalla.my.id/uas_perpus/api/index.php";
$data = [
    "accessToken" => "16022021-saahalla",
    "action" => "getAllData",
    "data" => "buku",
];
$json = json_encode($data);

$result = post_data($url, $json);

if($result["isSuccess"]=="true"){
    $array = $result["data"];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Index</title>

<!-- bootstrap CDN -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="bg-info">
<div class="row justify-content-center align-items-center mt-2">
    <div class="col-md-8 col-sm-12 justify-content-center align-items-center table-responsive" style="background-color: lightsalmon; height: 100%;">
        <div align="center" class="mb-4 mt-2">   
            <img src='https://kampus.antarbangsa.ac.id/pluginfile.php/1/theme_mb2nl/logo/1602325669/logo-antarbangsa-1024x355.png' alt='Logo STMIK 1Antar Bangsa' width='200px' height='80px' />
            <h3>Selamat Datang di Perpustakaan STMIK AB</h3>
        </div>
        
        <?php
            // jika user role = admin maka akan ada beberapa menu yg dimunculkan
            // selain itu hanya menu khusus user biasa yang dimunculkan
            $role = $_SESSION["user"]["roles"];
            if($role==="admin"){
                echo   '<a href="add.php" class="btn btn-info mb-4">Tambah buku</a>
                        <a href="user_show.php" class="btn btn-info mb-4">Data User</a>';
            }
        ?>
        <a href="pinjam_show.php" class="btn btn-info mb-4">Data Peminjaman</a>
        <?php
            if($role==="admin"){
                echo   '<a href="download.php?action=showIndex" class="btn btn-info mb-4">Download CSV</a>
                        <a href="download.php?action=excelUser" class="btn btn-info mb-4">Download Excel</a>
                        <a href="download.php?action=createPdf" class="btn btn-info mb-4">Download Pdf</a>';
            }
        ?>
        
        <a href="logout.php" class="btn btn-info mb-4">Logout</a>

        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Judul Buku</th>
                <th scope="col">Pengarang</th>
                <th scope="col">Jenis Buku</th>
                <th scope="col">Penerbit</th>
                <th scope="col">Tahun Terbit</th>
                <th scope="col">Gambar</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $no = 1;
                foreach($array as $key => $value){
                    if($value["image"]!=""){
                        $image = "<img src='uploads/".$value["image"]."' width='100' height='140'/>";
                    }else{
                        $image = '<button type="button" class="btn btn-sm btn-danger" disabled>No Image</button>';
                    }
                    
                    echo "<tr>";
                    echo "<td>".$no++."</td>";
                    echo "<td>".$value["judul_buku"]."</td>";
                    echo "<td>".$value["pengarang"]."</td>";
                    echo "<td>".$value["jenis_buku"]."</td>";
                    echo "<td>".$value["penerbit"]."</td>";
                    echo "<td>".$value["tahun_terbit"]."</td>";
                    echo "<td>$image</td>";
                    echo "<td style='display: flex'>";
                    echo "<a class='btn btn-info btn-sm mr-1' href='show.php?id=$value[id]'>Show</a>";
                    if($role==="admin"){
                        echo "<a class='btn btn-success btn-sm mr-1' href='edit.php?id=$value[id]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='delete.php?id=$value[id]'>Delete</a>";
                    }else{
                        echo "<a class='btn btn-info btn-sm mr-1' href='pinjam.php?id=$value[id]'>Pinjam</a>";
                    }
                            
                            
                    echo "</td> " ;

                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>