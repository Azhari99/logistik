<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Institute extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_institute');
        $this->load->model('m_budget');
        $this->load->model('m_productout');
    }

    public function index() 
    {
        $this->template->load('overview', 'institute/vInstitute');
    }

    public function getAll() 
    {
        $list = $this->m_institute->list();
        $number = 1;
        $data = array();
        foreach ($list as $value) {
            $row = array();
            $id_institute = $value->tbl_instansi_id;
            $insOut = $this->m_productout->totalInstituteOut(null, $id_institute, date('Y'));
            $annBudget = $value->budget;
            $remain = $annBudget - $insOut->amount;
            $row[] = $number++;
            $row[] = $value->value;
            $row[] = $value->name;
            $row[] = $value->address;
            $row[] = $value->email;
            $row[] = $value->phone;
            $row[] = rupiah($remain);
            $row[] = rupiah($annBudget);
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
                <a class="btn btn-primary btn-xs" href="institute/edit/' . $value->tbl_instansi_id . '" title="Edit"><i class="fa fa-edit"></i></a>            
                </center>';
            }            
            // <a class="btn btn-danger btn-xs"  onclick="deleteInstitute('."'".$value->tbl_instansi_id."'".')"title="Delete"><i class="fa fa-trash-o"></i></a>
            $data[] = $row;
        }
        $result = array('data' => $data );
        echo json_encode($result);
    }

    public function add() 
    {   
        $data['code'] = $this->m_institute->generateCode();
    	$this->template->load('overview', 'institute/addInstitute', $data);
    }

    public function actAdd()
    {   
        $this->form_validation->set_rules('name_ins','name', 'required|is_unique[tbl_instansi.name]');
        $this->form_validation->set_rules('address_ins','address', 'required');
        $this->form_validation->set_rules('email_ins','email', 'required|valid_email|is_unique[tbl_instansi.email]');

        $this->form_validation->set_message('is_unique', 'This %s already exists.');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $data['code'] = $this->m_institute->generateCode();
            $this->template->load('overview', 'institute/addInstitute', $data);
        } else {
            $currentYear = date('Y');
            $post = $this->input->post(null, TRUE);
            $budget = changeFormat($post['budget_ins']);
            $institue_budget = $this->m_institute->getTotalBudget(null);
            $sumBudget = $budget + $institue_budget->budget;
            $getBudget = $this->m_budget->getAllBudget($currentYear);
            $annBudget = $getBudget->budget;
            if ($sumBudget <= $annBudget) {
                $this->m_institute->save();
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                        '</button>'.
                        'Data berhasil disimpan</div>');
                }
                echo "<script>window.location='".site_url('institute')."';</script>";
            } else {
                if ($annBudget != '') {
                    $this->session->set_flashdata('error', '<div class="alert alert-error alert-dismissible fade in" role="alert">' .
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                        '</button>' .
                        'Anggaran pada tahun '.$currentYear. ' sudah melebihi total anggaran sebesar : '. rupiah($annBudget) . '</div>');
                    
                } else {
                    $this->session->set_flashdata('error', '<div class="alert alert-error alert-dismissible fade in" role="alert">' .
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                        '</button>' .
                        'Anggaran pada tahun ' . $currentYear . ' tidak tersedia </div>');
                }
                echo "<script>window.location='" . site_url('institute/add') . "';</script>";
            }            
        }
    }

    public function edit($id)
    {
        $data['institute_id'] = $id;
        $this->template->load('overview', 'institute/editInstitute', $data);
    }

    public function get_institute_edit()
    {
        $institute_id = $this->input->post('institute_id');
        $data = $this->m_institute->detail($institute_id)->result();
        echo json_encode($data);
    }

    public function actEdit()
    {
        $id = $this->input->post('id_instansi');
        $this->form_validation->set_rules('name_ins', 'name', 'required|callback_ins_check');
        $this->form_validation->set_rules('address_ins', 'address', 'required');
        $this->form_validation->set_rules('email_ins', 'email', 'required|valid_email');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $data['institute_id'] = $id;
            $this->template->load('overview', 'institute/editInstitute', $data);
        } else {
            $currentYear = date('Y');
            $post = $this->input->post(null, TRUE);
            $budget = changeFormat($post['budget_ins']);
            $institue_budget = $this->m_institute->getTotalBudget($id);
            $sumBudget = $budget + $institue_budget->budget;
            $getBudget = $this->m_budget->getAllBudget($currentYear);
            $annBudget = $getBudget->budget;
            if ($sumBudget <= $annBudget) {
                $this->m_institute->update();
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                        '</button>'.
                        'Data berhasil diubah</div>');
                }
                echo "<script>window.location='".site_url('institute')."';</script>";
            } else {
                if ($annBudget != '') {
                    $this->session->set_flashdata('error', '<div class="alert alert-error alert-dismissible fade in" role="alert">' .
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                        '</button>' .
                        'Anggaran pada tahun ' . $currentYear . ' sudah melebihi total anggaran sebesar : ' . rupiah($annBudget) . '</div>');
                } else {
                    $this->session->set_flashdata('error', '<div class="alert alert-error alert-dismissible fade in" role="alert">' .
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                        '</button>' .
                        'Anggaran pada tahun ' . $currentYear . ' tidak tersedia </div>');
                }
                echo "<script>window.location='" . site_url('institute/edit/'.$id) . "';</script>";
            }
        }
    }

    public function ins_check()
    {
        $post = $this->input->post(null, TRUE);
        $sql = $this->db->query("SELECT * FROM tbl_instansi WHERE name = '$post[name_ins]' AND tbl_instansi_id != '$post[id_instansi]'");
        if ($sql->num_rows() > 0) {
            $this->form_validation->set_message('ins_check', 'This %s already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function actDelete($id)
    {
        $data = $this->m_institute->delete($id);
        echo json_encode($data);
    }
}