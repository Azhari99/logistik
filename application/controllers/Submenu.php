<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Submenu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_submenu');
        $this->load->model('m_menu');
    }

    public function index()
    {
        $this->template->load('overview', 'submenu/vSub');
    }

    public function getAll()
    {
        $list = $this->m_submenu->list();
        $number = 1;
        $data = array();
        foreach ($list as $value) {
            $row = array();
            $row[] = $number++;
            $row[] = $value->name;
            $row[] = $value->seqno;
            $row[] = $value->name_menu;
            $row[] = $value->url;
            if ($value->isactive == 'Y') {
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
                <a class="btn btn-primary btn-xs" href="submenu/edit/' . $value->tbl_submenu_id . '" title="Edit"><i class="fa fa-edit"></i></a>
                <a class="btn btn-danger btn-xs" onclick="deleteSub(' . "'" . $value->tbl_submenu_id . "'" . ')" title="Delete"><i class="fa fa-trash-o"></i></a>
                </center>';
            }           
            $data[] = $row;
        }
        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function add()
    {
        $data['menu'] = $this->m_menu->getMenu();
        $this->template->load('overview', 'submenu/addSub', $data);
    }

    public function actAdd()
    {
        $this->form_validation->set_rules('name_sub', 'name', 'required|is_unique[tbl_submenu.name]');
        $this->form_validation->set_rules('menu_id', 'parent menu', 'required');
        $this->form_validation->set_rules('line_sub', 'line no', 'required');
        $this->form_validation->set_rules('url_sub', 'line no', 'required');

        $this->form_validation->set_message('is_unique', 'This %s already exists.');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['menu'] = $this->m_menu->getMenu();
            // $data['lineno'] = $this->m_submenu->seqno();
            $this->template->load('overview', 'submenu/addSub', $data);
        } else {
            $this->m_submenu->save();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Data berhasil disimpan</div>');
            }
            echo "<script>window.location='" . site_url('submenu') . "';</script>";
        }
    }

    public function edit($id)
    {
        $data['sub_id'] = $id;
        $data['menu'] = $this->m_menu->getMenu();
        $this->template->load('overview', 'submenu/editSub', $data);
    }

    public function get_sub_edit()
    {
        $sub_id = $this->input->post('sub_id');
        $data = $this->m_submenu->detail($sub_id)->result();
        echo json_encode($data);
    }

    public function actEdit()
    {
        $this->form_validation->set_rules('name_sub', 'name', 'required');
        $this->form_validation->set_rules('menu_id', 'parent menu', 'required');
        $this->form_validation->set_rules('line_sub', 'line no', 'required');
        $this->form_validation->set_rules('url_sub', 'line no', 'required');

        //$this->form_validation->set_message('is_unique', 'This %s already exists.');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['sub_id'] = $id;
            $data['menu'] = $this->m_menu->getMenu();
            $this->template->load('overview', 'submenu/editSub', $data);
        } else {
            $this->m_submenu->update();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Data berhasil diubah</div>');
            }
            echo "<script>window.location='" . site_url('submenu') . "';</script>";
        }
    }

    public function actDelete($id)
    {
        $data = $this->m_submenu->delete($id);
        echo json_encode($data);
    }
}
