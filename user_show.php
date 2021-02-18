<?php
    include('function.php'); // function

    $url = "http://saahalla.my.id/uas_perpus/api/index.php";
    $data = [
        "accessToken" => "16022021-saahalla",
        "action" => "getAllData",
        "data" => "users",
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
    <title>Data user</title>

    <!-- bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body class="bg-info">
    <div class="row justify-content-center align-items-center mt-2">
        <div class="col-md-8 justify-content-center align-items-center table-responsive" style="background-color: lightsalmon; height: 100%;">
            <div align="center" class="mb-4 mt-2">   
                <img src='https://kampus.antarbangsa.ac.id/pluginfile.php/1/theme_mb2nl/logo/1602325669/logo-antarbangsa-1024x355.png' alt='Logo STMIK 1Antar Bangsa' width='200px' height='80px' />
                <h3>Selamat Datang di Perpustakaan STMIK AB</h3>
                <?php 
                    session_start();
                    // print_r($_SESSION["user"]);
                ?>
            </div>
            <!-- <a href="add.php" class="btn btn-info mb-4">Tambah buku</a> -->
            <a href="index.php" class="btn btn-info mb-4">Lihat Data buku</a>
            <a href="download.php?action=showUser" class="btn btn-info mb-4">Download Data User</a>
            <a href="logout.php" class="btn btn-info mb-4">Logout</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <!-- <th scope="col">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                <?php
                    $no = 1;
                    foreach($array as $key => $user){
                        echo "<tr>";
                        echo "<td>".$no++."</td>";
                        echo "<td>".$user["username"]."</td>";
                        echo "<td>".$user["name"]."</td>";
                        echo "<td>".$user["email"]."</td>";
                        // echo "<td style='display: flex'>
                        //         <a class='btn btn-info btn-sm mr-1' href='show.php?id=$data_buku[id]'>Show</a>
                        //         <a class='btn btn-success btn-sm mr-1' href='edit.php?id=$data_buku[id]'>Edit</a>
                        //         <a class='btn btn-danger btn-sm' href='delete.php?id=$data_buku[id]'>Delete</a>
                        //     </td> " ;

                        echo "</tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>