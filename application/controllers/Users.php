<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_users');
    }

    public function index() 
    {
    	$this->template->load('overview', 'users/vUser');
    }

    public function getAll() 
    {
        $list = $this->m_users->list();
        $number = 1;
        $data = array();
        foreach ($list as $value) {
            $row = array();
            $row[] = $number++;
            $row[] = $value->value;
            $row[] = $value->name;
            $level = $value->level;
            if ($level == 1) {
                $row[] = 'Admin';
            } else if ($level == 2){
                $row[] = 'Pimpinan';
            } else {
                $row[] = 'User';
            }

            if($value->isactive == 'Y') {
                $row[] = '<center><span class="label label-success">Aktif</span></center>';
            } else {
                $row[] = '<center><span class="label label-danger">Nonaktif</span></center>';
            }
            $row[] = '<center>            
                    <a class="btn btn-primary btn-xs" href="users/edit/'.$value->tbl_user_id.'" title="Edit"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-danger btn-xs"  onclick="deleteUsers('."'".$value->tbl_user_id."'".')"title="Delete"><i class="fa fa-trash-o"></i></a>
                    </center>';
            $data[] = $row;
        }
        $result = array('data' => $data );
        echo json_encode($result);
    }

    public function add() 
    {
    	$this->template->load('overview', 'users/addUser');
    }

    public function actAdd()
    {
        $this->form_validation->set_rules('username','username', 'required|max_length[10]|is_unique[tbl_user.value]');
        $this->form_validation->set_rules('name','name', 'required|is_unique[tbl_user.name]');
        $this->form_validation->set_rules('password','password', 'required');
        $this->form_validation->set_rules('passconf','password confirmation', 'required|matches[password]');
        $this->form_validation->set_rules('level','level', 'required');

        $this->form_validation->set_message('is_unique', 'This %s already exists.');
        $this->form_validation->set_message('max_length', 'This %s maximum 10 character.');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $this->template->load('overview', 'users/addUser');
        } else {
            $this->m_users->save();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                    '</button>'.
                    'Data berhasil disimpan</div>');
            }
            echo "<script>window.location='".site_url('users')."';</script>";
        }
    }

    public function edit($id)
    {   
        $data['users_id'] = $id;
        $this->template->load('overview', 'users/editUser', $data);
    }

    public function get_users_edit()
    {
        $user_id = $this->input->post('user_id');
        $data = $this->m_users->detail($user_id)->result();
        echo json_encode($data);
    }

    public function actEdit()
    {
        $id = $this->input->post('id_user');
        $this->form_validation->set_rules('username', 'username', 'required|max_length[10]|callback_username_check');
        $this->form_validation->set_rules('name', 'name', 'required');
        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('passconf', 'password confirmation', 'required|matches[password]');
        }
        if ($this->input->post('passconf')){
            $this->form_validation->set_rules('passconf', 'password confirmation', 'required|matches[password]');
        }
        $this->form_validation->set_rules('level', 'level', 'required');

        $this->form_validation->set_message('is_unique', 'This %s already exists.');
        $this->form_validation->set_message('max_length', 'This %s maximum 10 character.');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>'); 

        if ($this->form_validation->run() == FALSE) {
            $data['users_id'] = $id;
            $this->template->load('overview', 'users/editUser', $data);
        } else {
            $this->m_users->update();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade in" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>'.
                    '</button>'.
                    'Data berhasil diubah</div>');
            }
            echo "<script>window.location='".site_url('users')."';</script>";
        }
    }

    public function username_check()
    {
        $post = $this->input->post(null, TRUE);
        $sql = $this->db->query("SELECT * FROM tbl_user WHERE value = '$post[username]' AND tbl_user_id != '$post[id_user]'");
        if ($sql->num_rows() > 0) {
            $this->form_validation->set_message('username_check', 'This %s already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function actDelete($id)
    {
        $data = $this->m_users->delete($id);
        echo json_encode($data);
    }
}