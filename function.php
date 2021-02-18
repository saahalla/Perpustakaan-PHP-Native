<?php
    date_default_timezone_set('Asia/Jakarta');
    require 'vendor/autoload.php';
    // vendor untuk php excel
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    function post_data($url, $json){
        // api get data buku by ID
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
        return $result;
    }

    function upload_image($array){
        // upload image
        $unic = uniqid();
        $target_dir = "uploads/";
        $target_file = $target_dir . $unic ."-".  basename($array["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($array["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            // echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($array["image"]["size"] > 10000000) {
            // echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        $image = $unic ."-". htmlspecialchars( basename( $array["image"]["name"]));
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            return false;
            // echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($array["image"]["tmp_name"], $target_file)) {
                return $image;
            } else {
                return false;
                // echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // function export data to csv
    function createCSV($json, $csvfilename){
		$data = json_decode($json, true);
	    $fp = fopen("reports/$csvfilename", 'w');
	    $header = false;
	    foreach ($data as $row)
	    {
	        if (empty($header))
	        {
	            $header = array_keys($row);
	            fputcsv($fp, $header, ";");
	            $header = array_flip($header);
	        }
	        fputcsv($fp, array_merge($header, $row), ";");
	    }
	    fclose($fp);
        $return = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/reports/$csvfilename";
        if(strstr($return, "showPinjam")){
            $return = str_replace("download.php?action=showPinjam", "", $return);
        }elseif(strstr($return, "showIndex")){
            $return = str_replace("download.php?action=showIndex", "", $return);
        }elseif(strstr($return, "showUser")){
            $return = str_replace("download.php?action=showUser", "", $return);
        }
	    return $return;
	}

    function createExcel(){
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // api get data buku
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
        $no=1;

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Judul Buku');
        $sheet->setCellValue('C1', 'Pengarang');
        $sheet->setCellValue('D1', 'Jenis Buku');
        $sheet->setCellValue('E1', 'Penerbit');
        $sheet->setCellValue('F1', 'Tahun Terbit');
        $sheet->setCellValue('G1', 'Url Gambar');

        for($i=0; $i<count($array); $i++){
            $image = "";
            if($array[$i]["image"] != ""){
                $image = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/".$array[$i]["image"];
                $image = str_replace("download.php?action=excelUser", "uploads", $image);
                // echo $image;
                // $image = file_get_contents($url_image);
                // echo $image;
            }else{
                $image = "tidak ada gambar";
            }
            
            $sheet->setCellValue('A'.($i+2), $no++);
            $sheet->setCellValue('B'.($i+2), $array[$i]["judul_buku"]);
            $sheet->setCellValue('C'.($i+2), $array[$i]["pengarang"]);
            $sheet->setCellValue('D'.($i+2), $array[$i]["jenis_buku"]);
            $sheet->setCellValue('E'.($i+2), $array[$i]["penerbit"]);
            $sheet->setCellValue('F'.($i+2), $array[$i]["tahun_terbit"]);
            $sheet->setCellValue('G'.($i+2), $image);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('reports/Report Excel - '.date("Y-m-d").'.xlsx');

        $return = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/Report Excel - ".date("Y-m-d").".xlsx";
        $return = str_replace("download.php?action=excelUser", "reports", $return);
        return $return;
    }

    function createPdf(){
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 20,
            'margin_right' => 15,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        // api get data buku
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

        $html = '<div>';
        $html .= '<h3 align="center"> Report Data Buku Perpusakaan '.date("d M Y")." </h3>";
        for($i=0; $i<count($array); $i++){
            $judul = $array[$i]["judul_buku"];
            $pengarang = $array[$i]["pengarang"];
            $jenis = $array[$i]["jenis_buku"];
            $penerbit = $array[$i]["penerbit"];
            $tahun = $array[$i]["tahun_terbit"];
            $image = $array[$i]["image"];


            $html .= "<h3>$judul</h3>";
            if($image!=""){ 
                $html .= "<img src='uploads/".$image."' alt='' width='200' height='250'>";
            }
            $html .= "<p>
                        Pengarang : $pengarang<br>
                        Jenis Buku : $jenis<br>
                        Nama Penerbit : $penerbit<br>
                        Tahun Terbit : $tahun<br>
                    </p>
                    <br>
                    <hr>";
        }
                
        $html .= "</div>";

        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("Data Buku");
        $mpdf->SetAuthor("Saahalla");
        $mpdf->SetWatermarkText("Test");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        // echo $html;
        $mpdf->WriteHTML($html);

        $mpdf->Output("reports/Data Buku - ".date("Y-m-d").".pdf");

        $return = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/Data Buku - ".date("Y-m-d").".pdf";
        $return = str_replace("download.php?action=createPdf", "reports", $return);
        return $return; 
    }
    