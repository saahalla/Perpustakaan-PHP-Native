<?php
    include('function.php'); // function
    $id = $_GET["id"];
    $date_kembali = date("Y-m-d");

    $url = "http://saahalla.my.id/uas_perpus/api/index.php";
    $data = [
        "accessToken" => "16022021-saahalla",
        "action" => "updateDataPinjam",
        "id" => $id,
        "date_kembali" => $date_kembali,
    ];
    
    $json = json_encode($data);
    echo $json;
    $result = post_data($url, $json);
    echo json_encode($result);
    if($result["isSuccess"]==true){
        // $array = $result["data"];
        header("Location: pinjam_show.php");
    }

    