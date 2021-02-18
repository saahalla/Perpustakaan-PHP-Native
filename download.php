<?php
    // include file function.php
    include 'function.php';
    $action = $_GET["action"];

    if($action == "showIndex"){
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
        $json = json_encode($array);
        $csv = createCSV($json, "dataBuku.csv");
        header("Location: $csv");

    }elseif($action == "showUser"){
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
        $json = json_encode($array);
        $csv = createCSV($json, "dataUser.csv");
        header("Location: $csv");

    }elseif($action == "showPinjam"){
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
        $json = json_encode($array);
        $csv = createCSV($json, "dataPinjam.csv");
        header("Location: $csv");
    }elseif($action == "excelUser"){
        $excel = createExcel();
        if($excel){
            header("Location: $excel");
        }
    }elseif($action == "createPdf"){
        $pdf = createPdf();
        if($pdf){
            header("Location: $pdf");
        }
    }

    