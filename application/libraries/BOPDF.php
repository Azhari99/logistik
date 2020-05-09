<?php

class BOPDF extends TCPDF
{
    //Page header
    public function Header()
    {
        // Set font Times New Roman
        $this->SetFont('times', 'B', 15);
        // Title
        $this->Cell(0, 15, 'Report Barang Anggaran Keluar', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('times', 10);
        // Page number
        $this->Cell(285, 10, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}