<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Budget extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_budget');
        $this->load->model('m_type');
        $this->load->model('m_product');
    }

    public function index() 
    {
        $this->template->load('overview', 'budget/vBudget');
    }

    public function getAll() 
    {
        $list = $this->m_budget->list();
        $data = array();
        foreach ($list as $value) {
            $row = array();
            $budget = $value->budget;
            $year = $value->tahun;
            $type_id = $value->jenis_id;
            $total = $this->m_product->totalBudgetOut($type_id,$year);
            $budgetAvailable = ($budget - $total->budget_total);
            $row[] = $year;
            $row[] = $value->name;
            $row[] = $value->type;
            $row[] = rupiah($budgetAvailable);
            $row[] = rupiah($budget);
            $row[] = $value->keterangan;
            
            if($value->status == 'O') {
                $row[] = '<center><a href="javascript:void(0)" onclick="doPeriode(' . "'" . $value->tbl_anggaran_id . "'" . ')" title="Open Periode"><span class="label label-success">Open</span></a></center>';
            } else {
                $row[] = '<center><a href="javascript:void(0)" onclick="doPeriode(' . "'" . $value->tbl_anggaran_id . "'" . ')" title="Close Periode"><span class="label label-default">Closed</span></a></center>';
            }
            $row[] = '<center>            
                <a class="btn btn-primary btn-xs" href="budget/edit/'.$value->tbl_anggaran_id.'" title="Edit"><i class="fa fa-edit"></i></a>
                <a class="btn btn-danger btn-xs"  onclick="deleteCategory('."'".$value->tbl_anggaran_id."'".')"title="Delete"><i class="fa fa-trash-o"></i></a>
                </center>';
            $data[] = $row;
        }
        $result = array('data' => $data );
        echo json_encode($result);
    }

    public function add() 
    {
        $data['type'] = $this->m_type->listType();
    	$this->template->load('overview', 'budget/addBudget', $data);
    }
    
    public function actAdd()
    {
        $this->form_validation->set_rules('name','name', 'required');
        $this->form_validation->set_rules('year_budget','year', 'required');
        $this->form_validation->set_rules('typelog','type logistics', 'required');
        $this->form_validation->set_rules('an_budget','annual budget', 'required');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $data['type'] = $this->m_type->listType();
            $this->template->load('overview', 'budget/addBudget', $data);
        } else {
            $uri = $this->uri->segment(2);
            $post = $this->input->post();
            $count = $this->m_budget->checkType($post, $uri);
            if ($count->type > 0) {
                $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Type logistics ' . $count->name . ' ditahun '.$post['year_budget'].' sudah ada</div>');
                $data['type'] = $this->m_type->listType();
                $this->template->load('overview', 'budget/addBudget', $data);
            } else {
                $this->m_budget->save();
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade in" role="alert">' .
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                        '</button>' .
                        'Data berhasil disimpan</div>');
                }
                echo "<script>window.location='" . site_url('budget') . "';</script>";
            }            
        }
    }

    public function edit($id)
    {
        $data['budget_id'] = $id;
        $data['type'] = $this->m_type->listType();
        $this->template->load('overview', 'budget/editBudget', $data);
    }

    public function get_budget_edit()
    {
        $budget_id = $this->input->post('budget_id');
        $data = $this->m_budget->detail($budget_id)->result();
        echo json_encode($data);
    }

    public function actEdit()
    {
        $id = $this->input->post('id_budget');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('year_budget', 'year', 'required');
        $this->form_validation->set_rules('typelog', 'type logistics', 'required');
        $this->form_validation->set_rules('an_budget', 'annual budget', 'required');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $data['budget_id'] = $id;
            $data['type'] = $this->m_type->listType();
            $this->template->load('overview', 'budget/editBudget', $data);
        } else {
            $uri = $this->uri->segment(2);
            $post = $this->input->post();
            $count = $this->m_budget->checkType($post, $uri);
            if ($count->type > 0) {
                $this->session->set_flashdata('error', '<div class="alert alert-danger alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Type logistics ' .$count->name. ' ditahun ' . $post['year_budget'] . ' sudah ada</div>');
                $data['budget_id'] = $id;
                $data['type'] = $this->m_type->listType();
                $this->template->load('overview', 'budget/editBudget', $data);
            } else {
                $this->m_budget->update();
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                        '</button>'.
                        'Data berhasil diubah</div>');
                }
                echo "<script>window.location='".site_url('budget')."';</script>";
            }
        }
    }

    public function actDelete($id)
    {
        $data = $this->m_budget->delete($id);
        echo json_encode($data);
    }

    public function getDetail()
    {
        $id = $this->input->post('id');
        $data = $this->m_budget->detail($id)->row();
        echo json_encode($data);
    }

    public function actPeriode()
    {
        $post = $this->input->post();
        $this->m_budget->updatePeriode($post);
        if ($this->db->affected_rows() > 0) {
            $data = true;
        }
        echo json_encode($data);
    }
}