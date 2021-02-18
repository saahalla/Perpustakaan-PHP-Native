<?php
    include('function.php'); // function

    $id = $_GET['id'];

    $url = "http://saahalla.my.id/uas_perpus/api/index.php";
    $data = [
        "accessToken" => "16022021-saahalla",
        "action" => "deleteBuku",
        "data" => "buku",
        "id" => $id
    ];
    $json = json_encode($data);

    $result = post_data($url, $json);
    
    // if($result["isSuccess"]==true){
        header("Location: index.php");
    // }
