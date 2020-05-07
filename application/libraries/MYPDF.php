<?php

class MYPDF extends TCPDF
{
    //Page header
    public function Header()
    {
        // Logo
        // $image_file = K_PATH_IMAGES . 'logo_example.jpg';
        // $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font Times New Roman
        $this->SetFont('times', 'B', 15);
        // Title
        $this->Cell(0, 15, 'Invoice Barang Keluar', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(0, 10, 'Invoice Barang Keluar');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('times', 10);
        // Page number
        $this->Cell(200, 10, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}