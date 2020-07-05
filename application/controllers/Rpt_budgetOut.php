<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rpt_budgetOut extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('BOPDF');
        $this->load->model('m_budget');
        $this->load->model('m_product');
        $this->load->model('m_institute');
        $this->load->model('m_category');
        $this->load->model('m_type');
    }

    public function index()
    {
        $data['product'] = $this->m_product->listProduct();
        $data['institute'] = $this->m_institute->listInstitute();
        $data['category'] = $this->m_category->listCategory();
        $data['type'] = $this->m_type->listType();
        $this->template->load('overview', 'report/vRpt_budgetOut', $data);
    }

    public function proses()
    {
        $post = $this->input->post(null, TRUE);
        $oriDateStart = str_replace('/', '-', $post['datetrx_start']);
        $oriDateEnd = str_replace('/', '-', $post['datetrx_end']);
        $date_start = date("Y-m-d", strtotime($oriDateStart));
        $date_end = date("Y-m-d", strtotime($oriDateEnd));
        $this->report($post, $oriDateStart, $oriDateEnd, $date_start, $date_end);
    }

    public function report($setPost, $oriDateStart, $oriDateEnd, $date_start, $date_end)
    {
        $options = $setPost['inlineRadioOptions'];
        $id_product = $setPost['listproduct'];
        $id_institute = $setPost['listinstitute'];
        $id_category = $setPost['listcategory'];
        $id_type = $setPost['listtype'];
        $data_head = "";
        $result = "";
        $budget = "";
        $number = 0;
        $jumlah = 0;       
        
        if ($options == "product") {
            if (!empty($id_product)) {
                $detail_product = $this->m_product->detail($id_product)->row();
                $data_head = $detail_product->value . "-" . $detail_product->name;
            }
            $result = $this->m_product->listProductOut($options, $id_product, $date_start, $date_end);
            $budget = $this->m_budget->budgetYear($date_start, $date_end);
        } else if ($options == "institute") {
            if (!empty($id_institute)) {
                $detail_institute = $this->m_institute->detail($id_institute)->row();
                $data_head = $detail_institute->value . "-" . $detail_institute->name;
            }
            $result = $this->m_product->listProductOut($options, $id_institute, $date_start, $date_end);
            $budget = $this->m_institute->totalInstituteBudget($id_institute);
        } else if ($options == "category") {
            if (!empty($id_category)) {
                $detail_category = $this->m_category-> detail($id_category)->row();
                $data_head = $detail_category->value . "-" . $detail_category->name;
            }
            $result = $this->m_product->listProductOut($options, $id_category, $date_start, $date_end);
            $budget = $this->m_budget->budgetYear($date_start, $date_end);
        } else {
            if (!empty($id_type)) {
                $detail_type = $this->m_type-> detail($id_type)->row();
                $data_head = $detail_type->value . "-" . $detail_type->name;
            }
            $result = $this->m_product->listProductOut($options, $id_type, $date_start, $date_end);
            $budget = $this->m_budget->budgetYear($date_start, $date_end);
        }

        if (!empty($result)) {
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
                            </tr>';
                if ($options == "product") {
                    $page_head .= '<tr>
                                    <td width="85px">Product</td>
                                    <td width="5px">:</td>
                                    <td width="30%">' . $data_head . '</td>
                                </tr>';
                } else if ($options == "institute") {
                    $page_head .= '<tr>
                                    <td width="85px">Institute</td>
                                    <td width="5px">:</td>
                                    <td width="30%">' . $data_head . '</td>
                                </tr>';
                } else if ($options == "category") {
                    $page_head .= '<tr>
                                    <td width="85px">Category</td>
                                    <td width="5px">:</td>
                                    <td width="30%">' . $data_head . '</td>
                                </tr>';
                } else {
                    $page_head .= '<tr>
                                    <td width="85px">Type Logistics</td>
                                    <td width="5px">:</td>
                                    <td width="30%">' . $data_head . '</td>
                                </tr>';
                }
            $page_head .= '</table>
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
                    
            foreach ($result as $value) {
                $number++;
                $documentno = $value->documentno;
                $product_name = $value->value . '-' . $value->name;
                $qty = $value->qtyentered;
                $unitprice = $value->unitprice;
                $amount = $value->amount;
                $desc = $value->keterangan;
                $jumlah +=  $amount;
                
                $page_col .= '<tr>
                    <td align="center" width="5%">'. $number. '</td>
                    <td width="10%">'. $documentno. '</td>
                    <td width="20%">' . $product_name . '</td>';
                if ($qty != 0) {
                    $page_col .= '<td align="right" width="7%">' .$qty. '</td>';
                } else {
                    $page_col .= '<td align="right" width="7%"></td>';
                }
                if ($unitprice != 0) {
                    $page_col .= '<td align="right" width="15%">' . rupiah($unitprice) . '</td>';
                } else {
                    $page_col .= '<td align="right" width="15%"></td>';
                }
                
                $page_col .= '<td align="right" width="15%">' . rupiah($amount) . '</td>
                    <td width="30%">' . $desc . '</td>
                </tr>';
                
            }

            $totalBudget = $budget->budget;
            $remain = $totalBudget - $jumlah;
            
            if ($options == "institute") {
                if (!empty($id_institute)) {
                    $page_col .= '<tr>
                        <td align="right" width="72%">Total Budget Insitute</td>
                        <td align="right" width="30%">' . rupiah($totalBudget) . '</td>
                    </tr>';
                } else {
                    $page_col .= '<tr>
                        <td align="right" width="72%">Total All Budget Insitute</td>
                        <td align="right" width="30%">' . rupiah($totalBudget) . '</td>
                    </tr>';
                }                
            } else {
                $page_col .= '<tr>
                    <td align="right" width="72%">Total All Budget</td>
                    <td align="right" width="30%">' . rupiah($totalBudget) . '</td>
                </tr>';
            }   
            $page_col .='<tr>
                    <td align="right" width="72%">Spending</td>
                    <td align="right" width="30%">' . rupiah($jumlah) . '</td>
                </tr>
                <tr>
                    <td align="right" width="72%">Remaining Budget</td>
                    <td align="right" width="30%">' . rupiah($remain) . '</td>
                </tr>
            </table>';

            $pdf->writeHTML($page_col, true, false, false, false, '');
            
            //Close and output PDF document
            $pdf->Output('Report Barang Budget Keluar', 'I');
        } else {
            echo "<script>alert('Document not found')</script>";
        }
    }
}
