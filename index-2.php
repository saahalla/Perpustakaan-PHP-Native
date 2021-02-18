<?php
    session_start();
    if(!isset($_SESSION["user"])) header("Location: login.php");

    include_once('config2.php');

    $result = mysqli_query($mysqli, "SELECT * FROM buku ORDER BY id DESC");
    print_r($result);
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
        <div class="col-md-8 justify-content-center align-items-center" style="background-color: lightsalmon; height: 100%;">
            <div align="center" class="mb-4 mt-2">   
                <img src='https://kampus.antarbangsa.ac.id/pluginfile.php/1/theme_mb2nl/logo/1602325669/logo-antarbangsa-1024x355.png' alt='Logo STMIK 1Antar Bangsa' width='200px' height='80px' />
                <h3>Selamat Datang di Perpustakaan STMIK AB</h3>
                <?php 
                    session_start();
                    // print_r($_SESSION["user"]);
                ?>
            </div>
            <a href="add.php" class="btn btn-info mb-4">Tambah buku</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Judul Buku</th>
                    <th scope="col">Pengarang</th>
                    <th scope="col">Jenis Buku</th>
                    <th scope="col">Penerbit</th>
                    <th scope="col">Tahun Terbit</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $no = 1;
                    while($data_buku = mysqli_fetch_array($result)){
                    	print_r($data_buku, true);
                        echo "<tr>";
                        echo "<td>".$no++."</td>";
                        echo "<td>".$data_buku["judul_buku"]."</td>";
                        echo "<td>".$data_buku["pengarang"]."</td>";
                        echo "<td>".$data_buku["jenis_buku"]."</td>";
                        echo "<td>".$data_buku["penerbit"]."</td>";
                        echo "<td>".$data_buku["tahun_terbit"]."</td>";
                        echo "<td style='display: flex'>
                                <a class='btn btn-info btn-sm mr-1' href='show.php?id=$data_buku[id]'>Show</a>
                                <a class='btn btn-success btn-sm mr-1' href='edit.php?id=$data_buku[id]'>Edit</a>
                                <a class='btn btn-danger btn-sm' href='delete.php?id=$data_buku[id]'>Delete</a>
                            </td> " ;

                        echo "</tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>