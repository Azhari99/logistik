<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_type');
    }

    public function index() 
    {
    	$this->template->load('overview', 'type/vType');
    }

    public function getAll() 
    {
        $list = $this->m_type->list();
        $number = 1;
        $data = array();
        foreach ($list as $value) {
            $row = array();
            $row[] = $number++;
            $row[] = $value->value;
            $row[] = $value->name;
            if($value->isactive == 'Y'){
                $row[] = '<center><span class="label label-success">Aktif</span></center>';
            } else {
                $row[] = '<center><span class="label label-danger">Nonaktif</span></center>';
            }

            $level = $this->session->userdata('level');
            if ($level == 2 || $level == 3) {
            $row[] = '<center>            
                <a class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>            
                </center>';
            } else {
                $row[] = '<center>            
                <a class="btn btn-primary btn-xs" href="type/edit/' . $value->tbl_jenis_id . '" title="Edit"><i class="fa fa-edit"></i></a>            
                </center>';
            }
            // <a class="btn btn-danger btn-xs"  onclick="deleteType('."'".$value->tbl_jenis_id."'".')"title="Delete"><i class="fa fa-trash-o"></i></a>
            $data[] = $row;
        }
        $result = array('data' => $data );
        echo json_encode($result);
    }

    public function add() 
    {   
        $data['code'] = $this->m_type->generateCode();
    	$this->template->load('overview', 'type/addType', $data);
    }

    public function edit($id)
    {   
        $data['type_id'] = $id;
        $this->template->load('overview', 'type/editType', $data);
    }

    public function get_type_edit()
    {
        $type_id = $this->input->post('type_id');
        $data = $this->m_type->detail($type_id)->result();
        echo json_encode($data);
    }

    public function actAdd()
    {   
        $this->form_validation->set_rules('name_type','name', 
                                        'required|is_unique[tbl_jenis_logistik.name]',
                                        array(
                                            'is_unique' => 'This %s already exists.'
                                        ));

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $data['code'] = $this->m_type->generateCode();
            $this->template->load('overview', 'type/addType', $data);
        } else {
            $this->m_type->save();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                    '</button>'.
                    'Data berhasil disimpan</div>');
            }
            echo "<script>window.location='".site_url('type')."';</script>";
        }
    }

    public function actEdit()
    {
        $id = $this->input->post('id_jenis');
        $this->form_validation->set_rules('name_type','name', 'required|callback_type_check');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $data['type_id'] = $id;
            $this->template->load('overview', 'type/editType', $data);
        } else {
            $this->m_type->update();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                    '</button>'.
                    'Data berhasil diubah</div>');
            }
            echo "<script>window.location='".site_url('type')."';</script>";
        }
    }

    public function type_check()
    {
        $post = $this->input->post(null, TRUE);
        $sql = $this->db->query("SELECT * FROM tbl_jenis_logistik WHERE name = '$post[name_type]' AND tbl_jenis_logistik_id != '$post[id_jenis]'");
        if ($sql->num_rows() > 0) {
            $this->form_validation->set_message('type_check', 'This %s already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function actDelete($id)
    {
        $data = $this->m_type->delete($id);
        echo json_encode($data);
    }

    public function getType()
    {
        $data = $this->m_type->listType();
        echo json_encode($data);
    }
}