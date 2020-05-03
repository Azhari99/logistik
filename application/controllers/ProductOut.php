<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductOut extends CI_Controller {

	public function __construct() {
        parent::__construct();
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
            
            if($value->status == 'CO'){
                $row[] = '<center><span class="label label-success">Completed</span></center>';
                $row[] = '<center>            
                            <a class="btn btn-primary btn-xs" onclick="detailProductOut(' . "'" . $value->tbl_barangkeluar_id . "'" . ')" title="Detail Product Out"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-primary btn-xs"  onclick="printProductOut(' . "'" . $value->tbl_barangkeluar_id . "'" . ')" title="Print Product Out"><i class="fa fa-print"></i></a>
                        </center>';
            } else {
                $row[] = '<center><a href="javascript:void(0)" onclick="completeProductOut('."'".$value->tbl_barangkeluar_id."'".')" title="Proses"><span class="label label-warning">Drafted</span></a></center>';
                $row[] = '<center>            
                            <a class="btn btn-primary btn-xs" href="productout/edit/'.$value->tbl_barangkeluar_id.'" title="Edit"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-danger btn-xs"  onclick="deleteProductOut('."'".$value->tbl_barangkeluar_id."'".')" title="Delete"><i class="fa fa-trash-o"></i></a>
                            <a class="btn btn-primary btn-xs"  onclick="printProductOut('."'".$value->tbl_barangkeluar_id."'".')" title="Print Product Out"><i class="fa fa-print"></i></a>
                        </center>';
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
            $sumProductOut = $this->m_productout->totalQtyProductOut(null, $product, $trxYear);
            $sumInstituteOut = $this->m_productout->totalInstituteOut($institute, $trxYear);

            if ($type_id == 2) {
                $qtyOut = $qty = $unitprice = 0;
                $amount = $budget;
                $instituteOut = $budget + $sumInstituteOut->amount;
                $budgetOut = $budget + $sumProductOut->amount;
            } else {
                $qtyOut = $qty + $sumProductOut->qtyentered;
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
                    $param_out = array(
                        'documentno'        => $code,
                        'datetrx'           => $datetrx,
                        'tbl_barang_id'     => $product,
                        'tbl_instansi_id'   => $institute,
                        'qtyentered'        => $qty,
                        'unitprice'         => $unitprice,
                        'amount'            => $amount,
                        'status'            => 'DR',
                        'keterangan'        => $desc
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
            $sumProductOut = $this->m_productout->totalQtyProductOut(null, $product, $trxYear);
            $sumInstituteOut = $this->m_productout->totalInstituteOut($institute, $trxYear);

            if ($type_id == 2) {
                $qtyOut = $qty = $unitprice = 0;
                $amount = $budget;
                $instituteOut = $budget + $sumInstituteOut->amount;
                $budgetOut = $budget + $sumProductOut->amount;
            } else {
                $qtyOut = $qty + $sumProductOut->qtyentered;
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
                    $param_out = array(
                        'documentno'        => $code,
                        'datetrx'           => $datetrx,
                        'tbl_barang_id'     => $product,
                        'tbl_instansi_id'   => $institute,
                        'qtyentered'        => $qty,
                        'unitprice'         => $unitprice,
                        'amount'            => $amount,
                        'keterangan'        => $desc,
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
        
        if ($qty_out == 0 && $product->jenis_id != 2) {
            $data = array('error_qty' => $qty_out);
        } else {
            $param_out = array(
                'status'        => 'CO',
                'updated'       => date('Y-m-d H:i:s')
            );
            $data_product = array(
                'qtyavailable'  => $qtyAvailable - $qty_out,
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
                'key'               => "inv123"
            );

            //Kirim data ke client
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

    public function delete($id)
    {
        $data = $this->m_productout->delete($id);
        echo json_encode($data);
    }
}