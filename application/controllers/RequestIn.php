<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RequestIn extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_requestin');
        $this->load->model('m_product');
        $this->load->model('m_institute');
    }

    public function index() 
    {
    	$this->template->load('overview', 'request_in/vRIn');
    }

    public function getAll() 
    {
        $list = $this->m_requestin->list();
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
            } else {
                $row[] = "-";
            }
            
            $row[] = $value->keterangan;
            
            if($value->status == 'CO'){
                $row[] = '<center><span class="label label-success">Completed</span></center>';
                $row[] = '<center>            
                            <a class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
                        </center>';
            } else {
                $row[] = '<center><a href="javascript:void(0)" onclick="completeProductRIn('."'".$value->tbl_permintaan_id."'".')" title="Proses"><span class="label label-warning">Drafted</span></a></center>';
                $row[] = '<center>            
                            <a class="btn btn-primary btn-xs" href="requestin/edit/'.$value->tbl_permintaan_id.'" title="Edit"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-danger btn-xs"  onclick="deleteProductRIn('."'".$value->tbl_permintaan_id."'".')" title="Delete"><i class="fa fa-trash-o"></i></a>
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
        $data['code'] = $this->m_requestin->generateCode();
    	$this->template->load('overview', 'request_in/addRIn', $data);
    }
    
    public function actAdd()
    {
        $this->form_validation->set_rules('request_in','product','required');
        $this->form_validation->set_rules('institute_out','institute','required');
        $this->form_validation->set_rules('datetrx_out','date transaction','required');
        
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        $code = $this->input->post('code_out');
        $product = $this->input->post('request_in');
        $institute = $this->input->post('institute_out');
        $date = explode('/', $this->input->post('datetrx_out'));
        $qty = $this->input->post('qty_out');
        $desc = $this->input->post('desc_out');

        $trxDay =  $date[0];
        $trxMonth =  $date[1];
        $trxYear =  $date[2];
        $datetrx = ($trxYear.'-'.$trxMonth.'-'.$trxDay);

        $produtDetail = $this->m_product->getByID($product);
        if ($this->form_validation->run() == FALSE) {
            $data['product'] = $this->m_product->listProduct();
            $data['institute'] = $this->m_institute->listInstitute();
            $data['code'] = $this->m_requestin->generateCode();
            $this->template->load('overview', 'request_in/addRIn', $data);

        } else {
            if ($qty <= $produtDetail->qtyavailable) {
                $param_out = array(
                                'documentno'        => $code,
                                'datetrx'           => $datetrx,
                                'tbl_barang_id'     => $product,
                                'tbl_instansi_id'   => $institute,
                                'qtyentered'        => $qty,
                                'status'            => 'DR',
                                'keterangan'        => $desc
                        );
                $this->m_requestin->save($param_out);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                    '</button>'.
                    'Data berhasil disimpan</div>');
                }
                echo "<script>window.location='".site_url('requestin')."';</script>";
            } else {
                $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade in" role="alert">'.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                '</button>'.
                'Total Quantity product : '.$produtDetail->qtyavailable.'</div>');
                echo "<script>window.location='".site_url('requestin')."';</script>";
            }
        }
    }

    public function edit($id)
    {
        $data['request_in_id'] = $id;
        $data['product'] = $this->m_product->listProduct();
        $data['institute'] = $this->m_institute->listInstitute();
        $this->template->load('overview', 'request_in/editRIn', $data);
    }

    public function get_data_edit()
    {
        $request_in_id = $this->input->post('id');
        $data = $this->m_requestin->detail($request_in_id)->result();
        echo json_encode($data);
    }

    public function actEdit()
    {
        $this->form_validation->set_rules('request_in','product','required');
        $this->form_validation->set_rules('institute_out','institute','required');
        $this->form_validation->set_rules('datetrx_out','date transaction','required');
        
        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        $request_in_id = $this->input->post('request_in_id');
        $code = $this->input->post('code_out');
        $product = $this->input->post('request_in');
        $institute = $this->input->post('institute_out');
        $date = explode('/', $this->input->post('datetrx_out'));
        $qty = $this->input->post('qty_out');
        $desc = $this->input->post('desc_out');

        $trxDay =  $date[0];
        $trxMonth =  $date[1];
        $trxYear =  $date[2];
        $datetrx = ($trxYear.'-'.$trxMonth.'-'.$trxDay);
        
        $produtDetail = $this->m_product->detail($product);
        if ($this->form_validation->run() == FALSE) {
            $data['request_in_id'] = $request_in_id;
            $data['product'] = $this->m_product->listProduct();
            $data['institute'] = $this->m_institute->listInstitute();
            $this->template->load('overview', 'request_in/editRIn', $data);

        } else {
            if ($qty <= $produtDetail->qtyavailable) {
                $param_out = array(
                                'documentno'        => $code,
                                'datetrx'           => $datetrx,
                                'tbl_barang_id'     => $product,
                                'tbl_instansi_id'   => $institute,
                                'qtyentered'        => $qty,
                                'status'            => 'DR',
                                'keterangan'        => $desc,
                                'updated'           => date('Y-m-d H:i:s')
                        );
                $where_out = array('tbl_permintaan_id' => $request_in_id);
                $this->m_requestin->update($param_out, $where_out);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                    '</button>'.
                    'Data berhasil diubah</div>');
                }
                echo "<script>window.location='".site_url('requestin')."';</script>";
            } else {
                $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade in" role="alert">'.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                '</button>'.
                'Total Quantity product : '.$produtDetail->qtyavailable.'</div>');
                
                echo "<script>window.location='".site_url('requestin')."';</script>";
            }
        }
    }

    public function actComplete($id)
    {
        $get_detail = $this->m_requestin->detail($id)->row();
        $product = $this->m_product->detail($get_detail->tbl_barang_id)->row();
        $instansi = $this->m_institute->detail($get_detail->tbl_instansi_id)->row();
        $qty_product = $product->qtyavailable;
        $qty_out = $get_detail->qtyentered;
        $kode_barang = $product->value;
        $nama_barang = $product->name;
        $nama_instansi = $instansi->name;
        $keterangan = $get_detail->keterangan;
        
        if ($qty_out <= $qty_product) {
            $param_out = array(
                    'status' => 'CO'
                );
            $data_product = array(
                        'qtyavailable'  =>  $qty_product - $qty_out,
                        'updated'       => date('Y-m-d H:i:s')
                    );
            $dataApi = array(
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'instansi' => $nama_instansi,
                'jumlah' => $qty_out,
                'tgl_barang_masuk' => date("Y-m-d"),
                'keterangan' => $keterangan,
                'stat' => 1,
                'key' => "inv123"
            );

            $where_out = array('tbl_permintaan_id' => $id);
            $where_product = array('tbl_barang_id' => $get_detail->tbl_barang_id);
            $this->m_product->update($data_product, $where_product);
            $this->m_requestin->update($param_out, $where_out);
            $this->m_requestin->saveApi($dataApi);
            $data = array('success' => 'berhasil');
        } else {
            $data = array('error' => 'Qty barang tidak mencukupi');
        }
        echo json_encode($data);
    }

    public function delete($id)
    {
        $data = $this->m_requestin->delete($id);
        echo json_encode($data);
    }
}