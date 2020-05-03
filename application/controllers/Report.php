<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('MYPDF');
        $this->load->model('m_productout');
    }

    public function invoice($id)
    {
        $data = $this->m_productout->invoicePOut($id);
        $trx = date("Y", strtotime($data->datetrx));
        $value = $this->m_productout->totalInstituteYear($data->tbl_instansi_id, $trx);

        // create new PDF document
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('System Logistics');
        $pdf->SetTitle('Report Barang Keluar');
        $pdf->SetSubject('Product Out');
        $pdf->SetKeywords('PDF, logistik, system, produk, keluar');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('times', 'B', 11);

        // add a page
        $pdf->AddPage('L', 'A4');

        // set a position
        $pdf->SetXY(5, 15);

        $page_head = '<table>
            <tr>
                <td>
                    <table cellspacing="5" style="float:right; width:100%">
                        <tr>
                            <td width="90px">Nama Instansi</td>
                            <td width="5px">:</td>
                            <td width="72%">' . $data->instansi . '</td>
                        </tr>
                        <tr>
                            <td width="90px">Telp</td>
                            <td width="5px">:</td>
                            <td width="72%">' . $data->phone . '</td>
                        </tr>
                        <tr>
                            <td width="90px">Alamat</td>
                            <td width="5px">:</td>
                            <td width="100%">' . $data->address . '</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table cellspacing="5" style="float:right; width:100%">
                        <tr>
                            <td width="90px">No. Invoice</td>
                            <td width="5px">:</td>
                            <td width="50%">' . $data->documentno . '</td>
                        </tr>
                        <tr>
                            <td width="90px">Tgl Transaksi</td>
                            <td width="5px">:</td>
                            <td width="50%">' . date("d-M-y", strtotime($data->datetrx)) . '</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';

        $pdf->writeHTML($page_head, true, false, false, false, '');

        $pdf->SetXY(7, 50);
        $page_col = '<table border="1" style="width:100%">
            <tr align="center">
                <th width="3%">No</th>
                <th width="20%">Nama Produk</th>
                <th width="30%">Keterangan</th>
                <th width="10%">Qty</th>
                <th width="20%">Harga</th>
                <th width="20%">Jumlah</th>
            </tr>
            <tr>
                <td align="center" width="3%">1</td>
                <td width="20%">' . $data->value . "-" . $data->barang . '</td>
                <td width="30%">' . $data->keterangan . '</td>
                <td align="right" width="10%">' . $data->qtyentered . '</td>
                <td align="right" width="20%">' . rupiah($data->unitprice) . '</td>
                <td align="right" width="20%">' . rupiah($data->amount) . '</td>
            </tr>
            <tr>
                <td align="right" width="83%">Total Anggaran 1 Tahun</td>
                <td align="right">' . rupiah($data->budget_ins) . '</td>
            </tr>
            <tr>
                <td align="right" width="83%">Pengeluaran</td>
                <td align="right">' . rupiah($data->amount) . '</td>
            </tr>
            <tr>
                <td align="right" width="83%">Sisa Anggaran</td>
                <td align="right">' . rupiah($data->budget_ins - $value->amount) . '</td>
            </tr>
        </table>';

        $pdf->writeHTML($page_col, true, false, false, false, '');

        //Close and output PDF document
        $pdf->Output('Report Barang Keluar', 'I');
    }
}
