<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductIn extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_productin');
        $this->load->model('m_product');
        $this->load->model('m_budget');
    }

    public function index() 
    {
    	$this->template->load('overview', 'product_in/vPIn');
    }

    public function getAll() 
    {        
        $list = $this->m_productin->list();
        $number = 1;
        $data = array();
        foreach ($list as $value) {
            $row = array();
            $product = $value->value.'-'.$value->name;
            $row[] = $number++;
            $row[] = $value->documentno;
            $row[] = $product;
            $row[] = date('d-m-Y',strtotime($value->datetrx));
            if ($value->jenis_id != 2) {
                $row[] = $value->qtyentered;
            } else {
                $row[] = "-";
            }
            
            $row[] = rupiah($value->amount);
            $row[] = $value->keterangan;
            $row[] = $value->file;

            $level = $this->session->userdata('level');
            if ($level == 2) {
                if ($value->status == 'CO') {
                    $row[] = '<center><span class="label label-success">Completed</span></center>';
                    $row[] = '<center>            
                            <a class="btn btn-primary btn-xs" onclick="detailProductIn(' . "'" . $value->tbl_barangmasuk_id . "'" . ')" title="Detail Product In"><i class="fa fa-eye"></i></a>
                        </center>';
                } else {
                    $row[] = '<center><a href="javascript:void(0)" title="Proses"><span class="label label-warning">Drafted</span></a></center>';
                    $row[] = '';
                }
            } else {
                if ($value->status == 'CO') {
                    $row[] = '<center><span class="label label-success">Completed</span></center>';
                    $row[] = '<center>            
                            <a class="btn btn-primary btn-xs" onclick="detailProductIn(' . "'" . $value->tbl_barangmasuk_id . "'" . ')" title="Detail Product In"><i class="fa fa-eye"></i></a>
                        </center>';
                } else {
                    $row[] = '<center><a href="javascript:void(0)" onclick="completeProductIn(' . "'" . $value->tbl_barangmasuk_id . "'" . ')" title="Proses"><span class="label label-warning">Drafted</span></a></center>';
                    $row[] = '<center>            
                            <a class="btn btn-primary btn-xs" href="productin/edit/' . $value->tbl_barangmasuk_id . '" title="Edit"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-danger btn-xs"  onclick="deleteProductIn(' . "'" . $value->tbl_barangmasuk_id . "'" . ')" title="Delete"><i class="fa fa-trash-o"></i></a>
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
        $data['code'] = $this->m_productin->generateCode();
    	$this->template->load('overview', 'product_in/addPIn', $data);
    }
    
    public function actAdd()
    {
        $this->form_validation->set_rules('product_in','product','required');
        $this->form_validation->set_rules('datetrx_in','date transaction','required');
        
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        $code = $this->input->post('code_in');
        $product = $this->input->post('product_in');
        $date = explode('/', $this->input->post('datetrx_in'));
        $qty = $this->input->post('qty_in');
        $amount = changeFormat($this->input->post('total_in'));
        $unitprice = changeFormat($this->input->post('unitprice_in'));
        $desc = $this->input->post('desc_in');

        $trxDay =  $date[0];
        $trxMonth =  $date[1];
        $trxYear =  $date[2];
        $datetrx = ($trxYear.'-'.$trxMonth.'-'.$trxDay);

       

        if ($this->form_validation->run() == FALSE) {
            $data['product'] = $this->m_product->listProduct();
            $data['code'] = $this->m_productin->generateCode();
            $this->template->load('overview', 'product_in/addPIn', $data);

        } else {
            $product_detail = $this->m_product->detail($product)->row();
            $qtyLimit = $product_detail->qtyentered;
            $budgetProduct = $product_detail->budget;
            $budget_detail = $this->m_budget->getBudget($product_detail->jenis_id, $trxYear);
            $sumProductIn = $this->m_productin->totalQtyProductIn(null, $product, $trxYear);
            $qtyIn = $qty + $sumProductIn->qtyentered;
            $budgetIn = $amount + $sumProductIn->amount;

            if ($budget_detail != null) {
                $budgetYear = $budget_detail->tahun;
                $status = $budget_detail->status;
                // $annBudget = $budget_detail->budget;
                if ($trxYear == $budgetYear && $status == 'O' && $budgetIn <= $budgetProduct && $qtyIn <= $qtyLimit) { //cek barang pertahun
                    if($_FILES['nodin_file_in']['name'] != null) {
                        if($this->upload->do_upload('nodin_file_in')) {
                            $file_name = $this->upload->data('file_name');
                            $param_in = array(                                
                                'documentno'    => $code,
                                'datetrx'       => $datetrx,
                                'tbl_barang_id' => $product,
                                'qtyentered'    => $qty,
                                'unitprice'     => $unitprice,
                                'amount'        => $amount,
                                'status'        => 'DR',
                                'keterangan'    => $desc,
                                'file'          => $file_name,
                                'createdby'     => $this->session->userdata('userid'),
                                'updatedby'     => $this->session->userdata('userid'),
                            );
                            $this->m_productin->save($param_in);
                            if ($this->db->affected_rows() > 0) {
                                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                                '</button>'.
                                'Data berhasil disimpan</div>');
                            }
                            echo "<script>window.location='".site_url('productin')."';</script>";
                        } else {
                            $error = $this->upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                            echo "<script>window.location='" . site_url('productin/add') . "';</script>";
                        }                
                    } else {
                        $param_in = array(
                            'createdby'     => $this->session->userdata('userid'),
                            'updatedby'     => $this->session->userdata('userid'),
                            'documentno'    => $code,
                            'datetrx'       => $datetrx,
                            'tbl_barang_id' => $product,
                            'qtyentered'    => $qty,
                            'unitprice'     => $unitprice,
                            'amount'        => $amount,
                            'status'        => 'DR',
                            'keterangan'    => $desc
                        );
                        $this->m_productin->save($param_in);
                        if ($this->db->affected_rows() > 0) {
                            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                            '</button>'.
                            'Data berhasil disimpan</div>');
                        }
                        echo "<script>window.location='".site_url('productin')."';</script>";
                    }
                } else {
                    if ($status == 'C') {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                        'Closed period, silahkan buka periode budget ' . $budgetYear . '!</div>');
                    } else if ($budgetIn > $budgetProduct) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                        'Budget sudah melebihi : ' . rupiah($budgetProduct) . ' /Tahun </div>');
                    } else if ($qtyIn > $qtyLimit) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                        'Quantity sudah melebihi yang dibutuhkan : ' . $qtyLimit . ' /Tahun </div>');
                    } else {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Error</div>');
                    }
                    echo "<script>window.location='" . site_url('productin/add') . "';</script>";
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Silahkan buat budget tahunan terlebih dahulu !</div>');
                echo "<script>window.location='" . site_url('productin') . "';</script>";
            }
        }
    }

    public function edit($id)
    {
        $data['product_in_id'] = $id;
        $data['product'] = $this->m_product->listProduct();
        $this->template->load('overview', 'product_in/editPin', $data);
    }

    public function get_data_edit()
    {
        $product_in_id = $this->input->post('id');
        $data = $this->m_productin->detail($product_in_id)->result();
        echo json_encode($data);
    }

    public function actEdit()
    {
        $this->form_validation->set_rules('product_in','product','required');
        $this->form_validation->set_rules('datetrx_in','date transaction','required');
        
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        $id_barang_in = $this->input->post('id_barang_in');
        $code = $this->input->post('code_in');
        $product = $this->input->post('product_in');
        $date = explode('/', $this->input->post('datetrx_in'));
        $qty = $this->input->post('qty_in');
        $amount = changeFormat($this->input->post('total_in'));
        $unitprice = changeFormat($this->input->post('unitprice_in'));
        $desc = $this->input->post('desc_in');

        $trxDay =  $date[0];
        $trxMonth =  $date[1];
        $trxYear =  $date[2];
        $datetrx = ($trxYear.'-'.$trxMonth.'-'.$trxDay);        

        if ($this->form_validation->run() == FALSE) {
            $data['product_in_id'] = $id_barang_in;
            $data['product'] = $this->m_product->listProduct();
            $this->template->load('overview', 'product_in/editPin', $data);

        } else {
            $product_detail = $this->m_product->detail($product)->row();
            $qtyLimit = $product_detail->qtyentered;
            $budgetProduct = $product_detail->budget;
            $budget_detail = $this->m_budget->getBudget($product_detail->jenis_id, $trxYear);
            $sumProductIn = $this->m_productin->totalQtyProductIn($id_barang_in, $product, $trxYear);
            $qtyIn = $qty + $sumProductIn->qtyentered;
            $budgetIn = $amount + $sumProductIn->amount;

            if ($budget_detail != null) {
                $budgetYear = $budget_detail->tahun;
                $status = $budget_detail->status;
                // $annBudget = $budget_detail->budget;
                if ($trxYear == $budgetYear && $status == 'O' && $budgetIn <= $budgetProduct && $qtyIn <= $qtyLimit) { //cek barang pertahun                
                    if($_FILES['nodin_file_in']['name'] != null) {
                        if($this->upload->do_upload('nodin_file_in')) {
                            $item = $this->m_productin->detail($id_barang_in)->row();                     
                            if ($item->file != null) {
                                $target = './upload/nodin/'.$item->file;
                                unlink($target); //replace data lama
                            }

                            $file_name = $this->upload->data('file_name');
                            $param_in = array(
                                'documentno'    => $code,
                                'datetrx'       => $datetrx,
                                'tbl_barang_id' => $product,
                                'qtyentered'    => $qty,
                                'unitprice'     => $unitprice,
                                'amount'        => $amount,
                                'status'        => 'DR',
                                'keterangan'    => $desc,
                                'file'          => $file_name,
                                'updatedby'     => $this->session->userdata('userid'),
                                'updated'       => date('Y-m-d H:i:s')
                            );
                            $where_in = array('tbl_barangmasuk_id' => $id_barang_in);

                            $this->m_productin->update($param_in, $where_in);
                            if ($this->db->affected_rows() > 0) {
                                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                                '</button>'.
                                'Data berhasil diubah</div>');
                            }
                            echo "<script>window.location='".site_url('productin')."';</script>";
                        } else {
                            $error = $this->upload->display_errors();
                            $this->session->set_flashdata('error', $error);
                            echo "<script>window.location='" . site_url('productin/edit/' . $id_barang_in) . "'</script>";
                        }
                    } else {
                        $param_in = array(
                            'documentno'    => $code,
                            'datetrx'       => $datetrx,
                            'tbl_barang_id' => $product,
                            'qtyentered'    => $qty,
                            'unitprice'     => $unitprice,
                            'amount'        => $amount,
                            'status'        => 'DR',
                            'keterangan'    => $desc,
                            'updatedby'     => $this->session->userdata('userid'),
                            'updated'       => date('Y-m-d H:i:s')
                        );
                        $where_in = array('tbl_barangmasuk_id' => $id_barang_in);

                        $this->m_productin->update($param_in, $where_in);
                        if ($this->db->affected_rows() > 0) {
                            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                                '</button>'.
                                'Data berhasil diubah</div>');
                        }
                        echo "<script>window.location='".site_url('productin')."';</script>";
                    }                
                } else {
                    if ($status == 'C') {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Closed period, silahkan buka periode budget ' . $budgetYear . '!</div>');
                    } else if ($budgetIn > $budgetProduct) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Budget sudah melebihi : ' . rupiah($budgetProduct) . ' /Tahun </div>');
                    } else if ($qtyIn > $qtyLimit) {
                        $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                            '</button>' .
                            'Quantity sudah melebihi yang dibutuhkan : ' . $qtyLimit . ' /Tahun </div>');
                    }
                    echo "<script>window.location='".site_url('productin/edit/'.$id_barang_in)."'</script>";
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Silahkan buat budget tahunan terlebih dahulu !</div>');
                echo "<script>window.location='" . site_url('productin') . "';</script>";
            }
        }
    }

    public function actComplete($id)
    {
        $get_detail = $this->m_productin->detail($id)->row();
        $qty_in = $get_detail->qtyentered;
        $product = $this->m_product->detail($get_detail->tbl_barang_id)->row();
        $qty = $product->qtyavailable;
        if ($qty_in == 0) {
            $data = array('error_qty' => $qty_in);
        } else {
            $param_in = array(
                    'status' => 'CO'
                );
            $data_product = array(
                'qtyavailable'  => $qty_in + $qty,
                'updatedby'     => $this->session->userdata('userid'),
                'updated'       => date('Y-m-d H:i:s')
            );
            $where_in = array('tbl_barangmasuk_id' => $id);
            $where_product = array('tbl_barang_id' => $get_detail->tbl_barang_id);
            $this->m_product->update($data_product,$where_product);
            $this->m_productin->update($param_in, $where_in);
            $data = array('success' => 'berhasil');
        }        
        echo json_encode($data);
    }

    public function delete($id)
    {
        $item = $this->m_productin->detail($id)->row();                     
        if ($item->file != null) {
            $target = './upload/nodin/'.$item->file;
            unlink($target); //replace data lama
        }
        $data = $this->m_productin->delete($id);
        echo json_encode($data);
    }
}