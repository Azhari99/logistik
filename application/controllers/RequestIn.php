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
                $row[] = rupiah($value->unitprice);
            } else {
                $row[] = "-";
                $row[] = "-";
            }
            $row[] = rupiah($value->amount);
            $row[] = $value->keterangan;
            $level = $this->session->userdata('level');
            if ($level == 2) {
                if ($value->status == 'CO') {
                    $row[] = '<center><span class="label label-success">Completed</span></center>';
                } else {
                    $row[] = '<center><span class="label label-warning">Drafted</span></center>';
                }
            } else {
                if ($value->status == 'CO') {
                    $row[] = '<center><span class="label label-success">Completed</span></center>';
                } else {
                    $row[] = '<center><a href="javascript:void(0)" onclick="completeProductRIn(' . "'" . $value->tbl_permintaan_id . "'" . ')" title="Proses"><span class="label label-warning">Drafted</span></a></center>';
                }
            }
            $row[] = '<center><a class="btn btn-primary btn-xs" onclick="detailRequestIn(' . "'" . $value->tbl_permintaan_id . "'" . ')" title="Detail Request In"><i class="fa fa-eye"></i></a></center>';

            $data[] = $row;
        }
        $result = array('data' => $data );
        echo json_encode($result);
    }

    public function get_data_edit()
    {
        $request_in_id = $this->input->post('id');
        $data = $this->m_requestin->detail($request_in_id)->result();
        echo json_encode($data);
    }

    public function actComplete($id)
    {
        $get_detail = $this->m_requestin->detail($id)->row();
        $product = $this->m_product->detail($get_detail->tbl_barang_id)->row();
        $instansi = $this->m_institute->detail($get_detail->tbl_instansi_id)->row();
        $documentno = $get_detail->documentno;
        $unitprice = $get_detail->unitprice;
        $amount = $get_detail->amount;
        $qty_product = $product->qtyavailable;
        $qty_out = $get_detail->qtyentered;
        $kode_barang = $product->value;
        $nama_barang = $product->name;
        $nama_instansi = $instansi->name;
        $keterangan = $get_detail->keterangan;
        $documentno = $get_detail->documentno;
        
        if ($qty_out <= $qty_product) {
            $param_out = array(
                    'status' => 'CO'
                );
            $data_product = array(
                        'qtyavailable'  =>  $qty_product - $qty_out,
                        'updatedby'     => $this->session->userdata('userid'),
                        'updated'       => date('Y-m-d H:i:s')
                    );
            $dataApi = array(
                'kode_barang'      => $kode_barang,
                'nama_barang'      => $nama_barang,
                'instansi'         => $nama_instansi,
                'jumlah'           => $qty_out,
                'documentno'       => $documentno,
                'unitprice'        => $unitprice,
                'amount'           => $amount,
                'tgl_barang_masuk' => date("Y-m-d"),
                'keterangan'       => $keterangan,
                'stat'             => 1,
                'pathDownload'      => '',
                'key'              => "inv123"
            );
            $updateApi = array(
                'status' => 'CO',
                'documentno' => $documentno,
                'key' => "inv123"
            );
            $where_out = array('tbl_permintaan_id' => $id);
            $where_product = array('tbl_barang_id' => $get_detail->tbl_barang_id);
            $this->m_product->update($data_product, $where_product);
            $this->m_requestin->update($param_out, $where_out);
            $this->m_requestin->saveApi($dataApi);
            $this->m_requestin->updateApi($updateApi);
            $data = array('success' => 'berhasil');
        } else {
            $data = array('error' => 'Qty barang tidak mencukupi');
        }
        echo json_encode($data);
    }
}