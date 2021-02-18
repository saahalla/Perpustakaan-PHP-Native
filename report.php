<?php
    
    

    // $path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
    require 'vendor/autoload.php';

    $html = 'Hallo';
    $mpdf = new \Mpdf\Mpdf([
        'margin_left' => 20,
        'margin_right' => 15,
        'margin_top' => 20,
        'margin_bottom' => 20,
        'margin_header' => 10,
        'margin_footer' => 10
    ]);

    $mpdf->SetProtection(array('print'));
    $mpdf->SetTitle("Acme Trading Co. - Invoice");
    $mpdf->SetAuthor("Acme Trading Co.");
    $mpdf->SetWatermarkText("Paid");
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');
    echo $html;
    $mpdf->WriteHTML($html);

    $mpdf->Output();