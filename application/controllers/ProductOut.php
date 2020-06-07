<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductOut extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('POPDF');
        $this->load->model('m_productout');
        $this->load->model('m_product');
        $this->load->model('m_institute');
        $this->load->model('m_budget');
    }

    public function index() 
    {
    	$this->template->load('overview', 'product_out/vPOut');
    }

    public function getAll() 
    {
        $list = $this->m_productout->list();
        $number = 1;
        $data = array();
        foreach ($list as $value) {
            $row = array();
            $product = $value->value.'-'.$value->name;
            $institute = $value->code_institute.'-'.$value->name_institute;
            $row[] = $number++;
            $row[] = $value->documentno;
            $row[] = $product;
            $row[] = $institute;
            $row[] = date('d-m-Y',strtotime($value->datetrx));
            if ($value->jenis_id != 2) {
                $row[] = $value->qtyentered;
                $row[] = rupiah($value->amount);
            } else {
                $row[] = "-";
                $row[] = rupiah($value->amount);
            }
            
            $row[] = $value->keterangan;            
            $row[] = $value->file;

            $level = $this->session->userdata('level');
            if ($level == 2) {
                if ($value->status == 'CO') {
                    $row[] = '<center><span class="label label-success">Completed</span></center>';
                    $row[] = '<center>            
                            <a class="btn btn-primary btn-xs" title="Detail Product Out"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-primary btn-xs" title="Print Product Out"><i class="fa fa-print"></i></a>
                        </center>';
                } else {
                    $row[] = '<center><a href="javascript:void(0)" title="Proses"><span class="label label-warning">Drafted</span></a></center>';
                    $row[] = '<center>            
                            <a class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a class="btn btn-primary btn-xs" title="Print Product Out"><i class="fa fa-print"></i></a>
                        </center>';
                }
            } else {
                if ($value->status == 'CO') {
                    $row[] = '<center><span class="label label-success">Completed</span></center>';
                    $row[] = '<center>            
                            <a class="btn btn-primary btn-xs" onclick="detailProductOut(' . "'" . $value->tbl_barangkeluar_id . "'" . ')" title="Detail Product Out"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-primary btn-xs"  onclick="printProductOut(' . "'" . $value->tbl_barangkeluar_id . "'" . ')" title="Print Product Out"><i class="fa fa-print"></i></a>
                        </center>';
                } else {
                    $row[] = '<center><a href="javascript:void(0)" onclick="completeProductOut(' . "'" . $value->tbl_barangkeluar_id . "'" . ')" title="Proses"><span class="label label-warning">Drafted</span></a></center>';
                    $row[] = '<center>            
                            <a class="btn btn-primary btn-xs" href="productout/edit/' . $value->tbl_barangkeluar_id . '" title="Edit"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-danger btn-xs"  onclick="deleteProductOut(' . "'" . $value->tbl_barangkeluar_id . "'" . ')" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a class="btn btn-primary btn-xs"  onclick="printProductOut(' . "'" . $value->tbl_barangkeluar_id . "'" . ')" title="Print Product Out"><i class="fa fa-print"></i></a>
                        </center>';
                }
            }
            $data[] = $row;
        }
        $result = array('data' => $data );
        echo json_encode($result);
    }

    public function add()
    {
        $data['product'] = $this->m_product->listProduct();
        $data['institute'] = $this->m_institute->listInstitute();
        $data['code'] = $this->m_productout->generateCode();
    	$this->template->load('overview', 'product_out/addPOut', $data);
    }
    
    public function actAdd()
    {
        $this->form_validation->set_rules('product_out','product','required');
        $this->form_validation->set_rules('institute_out','institute','required');
        $this->form_validation->set_rules('datetrx_out','date transaction','required');
        
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        $code = $this->input->post('code_out');
        $product = $this->input->post('product_out');
        $institute = $this->input->post('institute_out');
        $date = explode('/', $this->input->post('datetrx_out'));
        $qty = $this->input->post('qty_out');
        $unitprice = changeFormat($this->input->post('unitprice_out'));
        $total = changeFormat($this->input->post('total_out'));
        $budget = changeFormat($this->input->post('budget_out'));
        $desc = $this->input->post('desc_out');

        $trxDay =  $date[0];
        $trxMonth =  $date[1];
        $trxYear =  $date[2];
        $datetrx = ($trxYear . '-' . $trxMonth . '-' . $trxDay);

        if ($this->form_validation->run() == FALSE) {
            $data['product'] = $this->m_product->listProduct();
            $data['institute'] = $this->m_institute->listInstitute();
            $data['code'] = $this->m_productout->generateCode();
            $this->template->load('overview', 'product_out/addPOut', $data);

        } else {
            $product_detail = $this->m_product->detail($product)->row();
            $qtyAvailable = $product_detail->qtyavailable;
            $type_id = $product_detail->jenis_id;
            $budgetProduct = $product_detail->budget;
            $budget_detail = $this->m_budget->getBudget($type_id, $trxYear);
            $sumBudgetOut = $this->m_productout->totalBudgetProductOut(null, $product, $trxYear);
            $sumQtyOut = $this->m_productout->totalQtyProductOut(null, $product, $trxYear);
            $sumInstituteOut = $this->m_productout->totalInstituteOut(null, $institute, $trxYear);
            
            if ($type_id == 2) {
                $qtyOut = $qty = $unitprice = 0;
                $amount = $budget;
                $instituteOut = $budget + $sumInstituteOut->amount;
                $budgetOut = $budget + $sumBudgetOut->amount;
            } else {
                $qtyOut = $qty;
                $qtyOut = $qty + $sumQtyOut->qtyentered;
                $amount = $total;
                $instituteOut = $total + $sumInstituteOut->amount;
                $budgetOut = $total;
            }
            
            $institute_detail = $this->m_institute->detail($institute)->row();
            $budgetIns = $institute_detail->budget;

            if ($budget_detail != null) {
                $budgetYear = $budget_detail->tahun;
                $status = $budget_detail->status;
                if ($trxYear == $budgetYear && $status == 'O' && $budgetOut <= $budgetProduct && $instituteOut <= $budgetIns && $qtyOut <= $qtyAvailable) {
                    if ($_FILES['nodin_file_out']['name'] != null) {
                        if ($this->upload->do_upload('nodin_file_out')) {
                            $file_name = $this->upload->data('file_name');
                            $param_out = array(
                                'documentno'        => $code,
                                'datetrx'           => $datetrx,
                                'tbl_barang_id'     => $product,
                                'tbl_instansi_id'   => $institute,
                                'qtyentered'        => $qty,
                                'unitprice'         => $unitprice,
                                'amount'            => $amount,
                                'status'            => 'DR',
                                'keterangan'        => $desc,
                                'file'              => $file_name,
                                'createdby'         => $this->session->userdata('userid'),
                                'updatedby'         => $this->session->userdata('userid')
                            );
                            $this->m_productout->save($param_out);
                            if ($this->db->affected_rows() > 0) {
                                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade in" role="alert">' .
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                                    '</button>' .
                                    'Data berhasil disimpan</div>');
                            }
                            echo "<script>window.location='" . site_url('productout') . "';</script>";
                        } else {
                            $error = $this->upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                            echo "<script>window.location='" . site_url('productout/add') . "';</script>";
                        }
                    } else {
                        $param_out = array(
                            'documentno'        => $code,
                            'datetrx'           => $datetrx,
                            'tbl_barang_id'     => $product,
                            'tbl_instansi_id'   => $institute,
                            'qtyentered'        => $qty,
                            'unitprice'         => $unitprice,
                            'amount'            => $amount,
                            'status'            => 'DR',
                            'keterangan'        => $desc,
                            'createdby'         => $this->session->userdata('userid'),
                            'updatedby'         => $this->session->userdata('userid')
                        );
                        $this->m_productout->save($param_out);
                        if ($this->db->affected_rows() > 0) {
                            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                                'Data berhasil disimpan</div>');
                        }
                        echo "<script>window.location='" . site_url('productout') . "';</script>";
                    }
                } else {
                    if ($status == 'C') {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Closed period, silahkan buka periode budget ' . $budgetYear . '!</div>');
                    } else if ($budgetOut > $budgetProduct) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Budget Product sudah melebihi : ' . rupiah($budgetProduct) . ' /Tahun </div>');
                    } else if ($instituteOut > $budgetIns) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Budget Instansi sudah melebihi : ' . rupiah($budgetIns) . ' /Tahun </div>');
                    } else if ($qtyOut > $qtyAvailable) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Quantity yang tersedia sekarang adalah : ' . $qtyAvailable . '</div>');
                    } else {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Error</div>');
                    }
                    echo "<script>window.location='" . site_url('productout/add') . "';</script>";
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Silahkan buat budget tahunan terlebih dahulu !</div>');
                echo "<script>window.location='" . site_url('productout') . "';</script>";
            }
        }
    }

    public function edit($id)
    {
        $data['product_out_id'] = $id;
        $data['product'] = $this->m_product->listProduct();
        $data['institute'] = $this->m_institute->listInstitute();
        $this->template->load('overview', 'product_out/editPOut', $data);
    }

    public function get_data_edit()
    {
        $product_out_id = $this->input->post('id');
        $data = $this->m_productout->detail($product_out_id)->result();
        echo json_encode($data);
    }

    public function actEdit()
    {
        $this->form_validation->set_rules('product_out','product','required');
        $this->form_validation->set_rules('institute_out','institute','required');
        $this->form_validation->set_rules('datetrx_out','date transaction','required');
        
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        $id_barang_out = $this->input->post('id_barang_out');
        $code = $this->input->post('code_out');
        $product = $this->input->post('product_out');
        $institute = $this->input->post('institute_out');
        $date = explode('/', $this->input->post('datetrx_out'));
        $qty = $this->input->post('qty_out');
        $unitprice = changeFormat($this->input->post('unitprice_out'));
        $total = changeFormat($this->input->post('total_out'));
        $budget = changeFormat($this->input->post('budget_out'));
        $desc = $this->input->post('desc_out');

        $trxDay =  $date[0];
        $trxMonth =  $date[1];
        $trxYear =  $date[2];
        $datetrx = ($trxYear . '-' . $trxMonth . '-' . $trxDay);

        if ($this->form_validation->run() == FALSE) {
            $data['product_out_id'] = $id_barang_out;
            $data['product'] = $this->m_product->listProduct();
            $data['institute'] = $this->m_institute->listInstitute();
            $this->template->load('overview', 'product_out/editPOut', $data);

        } else {
            $product_detail = $this->m_product->detail($product)->row();
            $qtyAvailable = $product_detail->qtyavailable;
            $type_id = $product_detail->jenis_id;
            $budgetProduct = $product_detail->budget;
            $budget_detail = $this->m_budget->getBudget($type_id, $trxYear);
            $sumBudgetOut = $this->m_productout->totalBudgetProductOut($id_barang_out, $product, $trxYear);
            $sumQtyOut = $this->m_productout->totalQtyProductOut($id_barang_out, $product, $trxYear);
            $sumInstituteOut = $this->m_productout->totalInstituteOut($id_barang_out, $institute, $trxYear);

            if ($type_id == 2) {
                $qtyOut = $qty = $unitprice = 0;
                $amount = $budget;
                $instituteOut = $budget + $sumInstituteOut->amount;
                $budgetOut = $budget + $sumBudgetOut->amount;
            } else {
                $qtyOut = $qty + $sumQtyOut->qtyentered;
                $amount = $total;
                $instituteOut = $total + $sumInstituteOut->amount;
                $budgetOut = $total;
            }
            $institute_detail = $this->m_institute->detail($institute)->row();
            $budgetIns = $institute_detail->budget;

            if ($budget_detail != null) {
                $budgetYear = $budget_detail->tahun;
                $status = $budget_detail->status;
                if ($trxYear == $budgetYear && $status == 'O' && $budgetOut <= $budgetProduct && $instituteOut <= $budgetIns && $qtyOut <= $qtyAvailable) {
                    if ($_FILES['nodin_file_out']['name'] != null) {
                        if ($this->upload->do_upload('nodin_file_out')) {
                            $item = $this->m_productout->detail($id_barang_out)->row();
                            if ($item->file != null) {
                                $target = './upload/nodin/' . $item->file;
                                unlink($target); //replace data lama
                            }
                            $file_name = $this->upload->data('file_name');
                            $param_out = array(
                                'documentno'        => $code,
                                'datetrx'           => $datetrx,
                                'tbl_barang_id'     => $product,
                                'tbl_instansi_id'   => $institute,
                                'qtyentered'        => $qty,
                                'unitprice'         => $unitprice,
                                'amount'            => $amount,
                                'keterangan'        => $desc,
                                'file'              => $file_name,
                                'updatedby'         => $this->session->userdata('userid'),
                                'updated'           => date('Y-m-d H:i:s')
                                
                            );
                            $where_out = array('tbl_barangkeluar_id' => $id_barang_out);
                            $this->m_productout->update($param_out, $where_out);
                            if ($this->db->affected_rows() > 0) {
                                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                                    '</button>'.
                                    'Data berhasil diubah</div>');
                            }
                            echo "<script>window.location='".site_url('productout')."';</script>";
                        } else {
                            $error = $this->upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                            echo "<script>window.location='" . site_url('productout/edit/' . $id_barang_out) . "'</script>";
                        }
                    } else {
                        $param_out = array(
                            'documentno'        => $code,
                            'datetrx'           => $datetrx,
                            'tbl_barang_id'     => $product,
                            'tbl_instansi_id'   => $institute,
                            'qtyentered'        => $qty,
                            'unitprice'         => $unitprice,
                            'amount'            => $amount,
                            'keterangan'        => $desc,
                            'updatedby'         => $this->session->userdata('userid'),
                            'updated'           => date('Y-m-d H:i:s')
                        );
                        $where_out = array('tbl_barangkeluar_id' => $id_barang_out);
                        $this->m_productout->update($param_out, $where_out);
                        if ($this->db->affected_rows() > 0) {
                            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                                'Data berhasil diubah</div>');
                        }
                        echo "<script>window.location='" . site_url('productout') . "';</script>";
                    }
                } else {
                    if ($status == 'C') {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Closed period, silahkan buka periode budget ' . $budgetYear . '!</div>');
                    } else if ($budgetOut > $budgetProduct) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Budget sudah melebihi : ' . rupiah($budgetProduct) . ' /Tahun </div>');
                    } else if ($instituteOut > $budgetIns) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Budget Instansi sudah melebihi : ' . rupiah($budgetIns) . ' /Tahun </div>');
                    } else if ($qtyOut > $qtyAvailable) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Quantity yang tersedia sekarang adalah : ' . $qtyAvailable . '</div>');
                    } else {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Error</div>');
                    }
                    echo "<script>window.location='" . site_url('productout/edit/' . $id_barang_out) . "'</script>";
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Silahkan buat budget tahunan terlebih dahulu !</div>');
                echo "<script>window.location='" . site_url('productout') . "';</script>";
            }
        }
    }

    public function actComplete($id)
    {
        $productout = $this->m_productout->detail($id)->row();
        $product = $this->m_product->detail($productout->tbl_barang_id)->row();
        $instansi = $this->m_institute->detail($productout->tbl_instansi_id)->row();
        $qtyAvailable = $product->qtyavailable;
        $qty_out = $productout->qtyentered;
        $kode_barang = $product->value;
        $nama_barang = $product->name;
        $nama_instansi = $instansi->name;
        $keterangan = $productout->keterangan;
        $file_name = $productout->file;
        $pathDownload = base_url('/productout/download/'). $file_name;
        
        if ($qty_out == 0 && $product->jenis_id != 2) {
            $data = array('error_qty' => $qty_out);
        } else {
            $param_out = array(
                'status'        => 'CO',
                'updated'       => date('Y-m-d H:i:s')
            );
            $data_product = array(
                'qtyavailable'  => $qtyAvailable - $qty_out,
                'updatedby'     => $this->session->userdata('userid'),
                'updated'       => date('Y-m-d H:i:s')
            );
            $dataApi = array(
                'kode_barang'       => $kode_barang,
                'nama_barang'       => $nama_barang,
                'instansi'          => $nama_instansi,
                'jumlah'            => $qty_out,
                'tgl_barang_masuk'  => date("Y-m-d"),
                'keterangan'        => $keterangan,
                'stat'              => 1,
                'pathDownload'      => $pathDownload,
                'key'               => "inv123"
            );

            // Kirim data ke client
            $result = $this->m_productout->saveApi($dataApi);
            if ($result['status'] == true) {
                $where_out = array('tbl_barangkeluar_id' => $id);
                $where_product = array('tbl_barang_id' => $productout->tbl_barang_id);
                $this->m_product->update($data_product, $where_product);
                $this->m_productout->update($param_out, $where_out);
                $data = array('success' => 'berhasil');
            } else {
                $data = array('error' => 'tidak dapat mengirim data keclient');
            }
        }        
        echo json_encode($data);
    }

    public function download($file_name)
    {
        $url = 'upload/nodin/' . $file_name . '';
        force_download($url, NULL);
    }

    public function delete($id)
    {
        $item = $this->m_productout->detail($id)->row();
        if ($item->file != null) {
            $target = './upload/nodin/' . $item->file;
            unlink($target); //replace data lama
        }
        $data = $this->m_productout->delete($id);
        echo json_encode($data);
    }

    public function rpt_invoice($id)
    {
        $data = $this->m_productout->invoicePOut($id);
        $trx = date("Y", strtotime($data->datetrx));
        $id = "rpt";
        $value = $this->m_productout->totalInstituteOut($id, $data->tbl_instansi_id, $trx);

        // create new PDF document
        $pdf = new POPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('System Logistics');
        $pdf->SetTitle('Report Product Out');
        $pdf->SetSubject('Product Out');
        $pdf->SetKeywords('PDF, logistik, system, produk, keluar');

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
        $pdf->AddPage('L', 'A5');

        // -- set new background ---
        if ($data->status != 'CO') {
            // get the current page break margin
            $bMargin = $pdf->getBreakMargin();
            // get current auto-page-break mode
            $auto_page_break = $pdf->getAutoPageBreak();
            // disable auto-page-break
            $pdf->SetAutoPageBreak(false, 0);
            // set bacground image
            $img_file = K_PATH_IMAGES . 'drafted.png';
            $pdf->Image($img_file, 0, 0, 130, '', 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
            // restore auto-page-break status
            $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
            // set the starting point for the page content
            $pdf->setPageMark();
        }

        // set a position
        $pdf->SetXY(5, 15);

        $page_head = '<table>
            <tr>
                <td>
                    <table cellspacing="5" style="float:right; width:100%">
                        <tr>
                            <td width="90px">Name Institute</td>
                            <td width="5px">:</td>
                            <td width="72%">' . $data->instansi . '</td>
                        </tr>
                        <tr>
                            <td width="90px">Phone</td>
                            <td width="5px">:</td>
                            <td width="72%">' . $data->phone . '</td>
                        </tr>
                        <tr>
                            <td width="90px">Address</td>
                            <td width="5px">:</td>
                            <td width="100%">' . $data->address . '</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table cellspacing="5" style="float:right; width:100%">
                        <tr>
                            <td width="105px">Document No</td>
                            <td width="5px">:</td>
                            <td width="50%">' . $data->documentno . '</td>
                        </tr>
                        <tr>
                            <td width="105px">Date Transaction</td>
                            <td width="5px">:</td>
                            <td width="50%">' . date("d-M-y", strtotime($data->datetrx)) . '</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>';

        $pdf->writeHTML($page_head, true, false, false, false, '');

        $pdf->SetXY(7, 50);
        if ($data->status != 'CO') {
            $remain = $data->budget_ins - $data->amount;
        } else {
            $remain = $data->budget_ins - $value->amount;
        }
        $page_col = '<table border="1" style="width:100%">
            <tr align="center">
                <th width="5%">No</th>
                <th width="20%">Name Product</th>
                <th width="10%">Qty</th>
                <th width="20%">Unit Price</th>
                <th width="20%">Amount</th>
                <th width="30%">Description</th>
            </tr>
            <tr>
                <td align="center" width="5%">1</td>
                <td width="20%">' . $data->value . "-" . $data->barang . '</td>
                <td align="right" width="10%">' . $data->qtyentered . '</td>
                <td align="right" width="20%">' . rupiah($data->unitprice) . '</td>
                <td align="right" width="20%">' . rupiah($data->amount) . '</td>
                <td width="30%">' . $data->keterangan . '</td>
            </tr>
            <tr>
                <td align="right" width="85%">Total Budget 1 Year</td>
                <td align="right">' . rupiah($data->budget_ins) . '</td>
            </tr>
            <tr>
                <td align="right" width="85%">Spending</td>
                <td align="right">' . rupiah($data->amount) . '</td>
            </tr>
            <tr>
                <td align="right" width="85%">Remaining Budget</td>
                <td align="right">' . rupiah($remain) . '</td>
            </tr>
        </table>';

        $pdf->writeHTML($page_col, true, false, false, false, '');

        //Close and output PDF document
        $pdf->Output('Report Product Out', 'I');
    }
}