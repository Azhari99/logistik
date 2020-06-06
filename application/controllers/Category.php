<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_category');
        $this->load->model('m_type');
    }

    public function index() 
    {
    	$this->template->load('overview', 'category/vCategory');
    }

    public function getAll() 
    {
        $list = $this->m_category->list();
        $number = 1;
        $data = array();
        foreach ($list as $value) {
            $row = array();
            $row[] = $number++;
            $row[] = $value->value;
            $row[] = $value->kategori;
            $row[] = $value->type;

            // if($value->isdefault == 'Y') {
            //     $row[] = '<center><span class="label label-primary">Yes</span></center>';
            // } else {
            //     $row[] = '<center><span class="label label-default">No</span></center>';
            // }

            if($value->isactive == 'Y') {
                $row[] = '<center><span class="label label-success">Aktif</span></center>';
            } else {
                $row[] = '<center><span class="label label-danger">Nonaktif</span></center>';
            }
            $level = $this->session->userdata('level');
            if ($level == 2 || $level == 3) {
                $row[] = '<center>            
                    <a class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>            
                    <a class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash-o"></i></a>
                    </center>';
            } else {
                $row[] = '<center>            
                    <a class="btn btn-primary btn-xs" href="category/edit/'.$value->tbl_kategori_id.'" title="Edit"><i class="fa fa-edit"></i></a>            
                    <a class="btn btn-danger btn-xs" onclick="deleteCategory('."'".$value->tbl_kategori_id."'".')" title="Delete"><i class="fa fa-trash-o"></i></a>
                    </center>';
            }
            $data[] = $row;
        }
        $result = array('data' => $data );
        echo json_encode($result);
    }

    public function add() 
    {
        $data['type'] = $this->m_type->listType();
        $data['code'] = $this->m_category->generateCode();
    	$this->template->load('overview', 'category/addCategory', $data);
    }

    public function edit($id)
    {   
        $data['category_id'] = $id;
        $data['type'] = $this->m_type->listType();
        $this->template->load('overview', 'category/editCategory', $data);
    }

    public function get_category_edit()
    {
        $category_id = $this->input->post('category_id');
        $data = $this->m_category->detail($category_id)->result();
        echo json_encode($data);
    }

    public function actAdd()
    {
        $this->form_validation->set_rules('name_cat','name', 
                                        'required|is_unique[tbl_kategori.name]',
                                        array(
                                            'is_unique' => 'This %s already exists.'
                                        ));

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $data['type'] = $this->m_type->listType();
            $data['code'] = $this->m_category->generateCode();
            $this->template->load('overview', 'category/addCategory', $data);
        } else {
            $this->m_category->save();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                    '</button>'.
                    'Data berhasil disimpan</div>');
            }
            echo "<script>window.location='".site_url('category')."';</script>";
        }
    }

    public function actEdit()
    {
        $id = $this->input->post('id_kategori');
        $this->form_validation->set_rules('name_cat','name','required');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $data['category_id'] = $id;
            $data['type'] = $this->m_type->listType();
            $this->template->load('overview', 'category/editCategory', $data);
        } else {
            $this->m_category->update();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                    '</button>'.
                    'Data berhasil diubah</div>');
            }
            echo "<script>window.location='".site_url('category')."';</script>";
        }
    }

    public function actDelete($id)
    {
        $data = $this->m_category->delete($id);
        echo json_encode($data);
    }
}