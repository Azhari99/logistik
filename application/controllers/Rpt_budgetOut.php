<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rpt_budgetOut extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('BOPDF');
        $this->load->model('m_product');
    }

    public function index()
    {
        $data['product'] = $this->m_product->listProduct();
        $this->template->load('overview', 'report/vRpt_budgetOut', $data);
    }
    public function report()
    {
        $post = $this->input->post(null, TRUE);
        $id_product = $post['isproduct'];
        $oriDateStart = str_replace('/', '-', $post['datetrx_start']);
        $oriDateEnd = str_replace('/', '-', $post['datetrx_end']);
        $date_start = date("Y-m-d", strtotime($oriDateStart));
        $date_end = date("Y-m-d", strtotime($oriDateEnd));
        $product = "";
        if (!empty($id_product)) {
            $detail_product = $this->m_product->detail($id_product)->row();
            $product = $detail_product->value."-".$detail_product->name;
        }
        $list_product = $this->m_product->listProductOut($id_product, $date_start, $date_end);

        // create new PDF document
        $pdf = new BOPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('System Logistics');
        $pdf->SetTitle('Report Barang Budget Keluar');
        $pdf->SetSubject('Report Product Budget Out');
        $pdf->SetKeywords('PDF, logistik, system, produk, anggarang, keluar');

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

        // set font
        $pdf->SetFont('times', 'B', 11);

        // add a page
        $pdf->AddPage('L', 'A4');

        // set a position
        $pdf->SetXY(6, 15);

        $page_head = '<table>
            <tr>
                <td>
                    <table cellspacing="5" style="float:right; width:100%">
                        <tr>
                            <td width="85px">Date Transaction</td>
                            <td width="5px">:</td>
                            <td width="30%">' . date("d-m-Y", strtotime($oriDateStart)) . ' s/d ' . date("d-m-Y", strtotime($oriDateEnd)) . '</td>
                        </tr>
                        <tr>
                            <td width="85px">Product</td>
                            <td width="5px">:</td>
                            <td width="30%">' . $product . '</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';

        $pdf->writeHTML($page_head, true, false, false, false, '');
        $pdf->SetXY(10, 30);
        
        $page_col = '<table border="1" style="width:100%">
            <tr align="center">
                <th width="5%">No</th>
                <th width="10%">Document No</th>
                <th width="20%">Nama Produk</th>
                <th width="7%">Qty</th>
                <th width="15%">Unitprice</th>
                <th width="15%">Amount</th>
                <th width="30%">Description</th>
            </tr>';
        $number = 0;
        foreach ($list_product as $value) {
            $number++;
            $page_col .= '<tr>
                <td align="center" width="5%">'. $number. '</td>
                <td width="10%">'. $value->documentno. '</td>
                <td width="20%">' . $value->value . '-' . $value->name . '</td>';
            if ($value->qtyentered != 0) {
                $page_col .= '<td align="right" width="7%">' . $value->qtyentered . '</td>';
            } else {
                $page_col .= '<td align="right" width="7%"></td>';
            }
            if ($value->unitprice != 0) {
                $page_col .= '<td align="right" width="15%">' . rupiah($value->unitprice) . '</td>';
            } else {
                $page_col .= '<td align="right" width="15%"></td>';
            }
            
            $page_col .= '<td align="right" width="15%">' . rupiah($value->amount) . '</td>
            <td width="30%">' . $value->keterangan . '</td>
            </tr>';
        }
        $page_col .= '<tr>
                <td align="right" width="72%">Total Budget</td>
                <td align="right" width="30%"></td>
            </tr>
            <tr>
                <td align="right" width="72%">Spending</td>
                <td align="right" width="30%"></td>
            </tr>
            <tr>
                <td align="right" width="72%">Remaining Budget</td>
                <td align="right" width="30%"></td>
            </tr>
        </table>';

        $pdf->writeHTML($page_col, true, false, false, false, '');
        
        //Close and output PDF document
        $pdf->Output('Report Barang Budget Keluar', 'I');
    }
}
