<?php
    include('function.php'); // function
    session_start();

    $role = $_SESSION["user"]["roles"];
    
    $url = "http://saahalla.my.id/uas_perpus/api/index.php";
    $data = [
        "accessToken" => "16022021-saahalla",
        "action" => "getDataPinjam",
        "role" => $role
    ];

    if($role != "admin"){
        $data["username"] = $_SESSION["user"]["username"];
    }
    // echo json_encode($data);

    $json = json_encode($data);

    $result = post_data($url, $json);
    $array = [];
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
    <title>Data peminjaman</title>

    <!-- bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="bg-info">
    <div class="row justify-content-center align-items-center mt-2">
        <div class="col-md-8 justify-content-center align-items-center table-responsive" style="background-color: lightsalmon; height: 100%;">
            <div align="center" class="mb-4 mt-2">   
                <img src='https://kampus.antarbangsa.ac.id/pluginfile.php/1/theme_mb2nl/logo/1602325669/logo-antarbangsa-1024x355.png' alt='Logo STMIK 1Antar Bangsa' width='200px' height='80px' />
                <h3>Selamat Datang di Perpustakaan STMIK AB</h3>
            </div>
            <!-- <a href="add.php" class="btn btn-info mb-4">Tambah buku</a> -->
            <a href="index.php" class="btn btn-info mb-4">Lihat Data Buku</a>
            <a href="download.php?action=showPinjam" class="btn btn-info mb-4">Download Data Peminjaman</a>
            <a href="logout.php" class="btn btn-info mb-4">Logout</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Peminjam</th>
                    <th scope="col">Nama Buku</th>
                    <th scope="col">Jumlah Buku</th>
                    <th scope="col">Tanggal Peminjaman</th>
                    <th scope="col">Tanggal Kembali</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                    <!-- <th scope="col">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                <?php
                    $no = 1;
                    foreach($array as $key => $value){
                        $id_kembali = $value["id"];
                        if($value["kembali"] == 1){
                            $status = "Sudah dikembalikan";
                            $action = '<button type="button" class="btn btn-sm btn-secondary btn-lg" disabled>Selesai</button>';
                        }else{
                            $status = "Belum dikembalikan";
                            $action = '<a href="kembali.php?id='.$id_kembali.'" class="btn btn-sm btn-info mb-4">Ubah Status</a>';
                        }
                        if($value["tgl_kembali"] == null){
                            $value["tgl_kembali"] = "-";
                        }
                        

                        echo "<tr>";
                        echo "<td>".$no++."</td>";
                        echo "<td>".$value["name"]."</td>";
                        echo "<td>".$value["judul_buku"]."</td>";
                        echo "<td>".$value["jumlah_pinjam"]."</td>";
                        echo "<td>".$value["tgl_pinjam"]."</td>";
                        echo "<td>".$value["tgl_kembali"]."</td>";
                        echo "<td>".$status."</td>";
                        echo "<td>".$action."</td>";

                        echo "</tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>