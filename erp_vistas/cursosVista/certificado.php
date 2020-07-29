<?php
    $empleado = $_POST['empleado'];
    $curso = strtoupper($_POST['curso']);
    $grupo = strtoupper($_POST['grupo']);


    require "../../config/config.php";
    require_once ROOT_PATH . "/vendor/fpdf/fpdf/original/fpdf.php";
    
    $pdf = new FPDF();

    $pdf->AddPage();
    $pdf->Image('../../assets/images/certificado.jpg',0,0,210,299);
    $pdf->SetFont('Arial','B',32);
    $pdf->Text(55,105,$empleado);  
    $pdf->Text(70,162,$curso);  
    $pdf->Text(85,195,$grupo);  
    $pdf->Output('D','certificado-' .$curso.'.pdf');
?>