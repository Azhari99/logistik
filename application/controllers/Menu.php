<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_menu');
    }

    public function index()
    {
        $this->template->load('overview', 'menu/vMenu');
    }

    public function getAll()
    {
        $list = $this->m_menu->list();
        $number = 1;
        $data = array();
        foreach ($list as $value) {
            $row = array();
            $row[] = $number++;
            $row[] = $value->name;
            $row[] = $value->seqno;
            $row[] = $value->url;
            $row[] = $value->icon;
            if ($value->isactive == 'Y') {
                $row[] = '<center><span class="label label-success">Aktif</span></center>';
            } else {
                $row[] = '<center><span class="label label-danger">Nonaktif</span></center>';
            }

            $level = $this->session->userdata('level');
            if ($level == 2 || $level == 3) {
                $row[] = '';
            } else {
                $row[] = '<center>            
                <a class="btn btn-primary btn-xs" href="menu/edit/' . $value->tbl_menu_id . '" title="Edit"><i class="fa fa-edit"></i></a>
                <a class="btn btn-danger btn-xs"  onclick="deleteMenu(' . "'" . $value->tbl_menu_id . "'" . ')"title="Delete"><i class="fa fa-trash-o"></i></a>
                </center>';
            }
            $data[] = $row;
        }
        $result = array('data' => $data);
        echo json_encode($result);
    }

    public function add()
    {
        $data['lineno'] = $this->m_menu->seqno();
        $this->template->load('overview', 'menu/addMenu', $data);
    }

    public function actAdd()
    {
        $this->form_validation->set_rules('name_menu', 'name', 'required|is_unique[tbl_menu.name]');
        $this->form_validation->set_rules('icon_menu', 'icon', 'required');
        $this->form_validation->set_rules('line_menu', 'line no', 'required');

        $this->form_validation->set_message('is_unique', 'This %s already exists.');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['lineno'] = $this->m_menu->seqno();
            $this->template->load('overview', 'menu/addMenu', $data);
        } else {
            $this->m_menu->save();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Data berhasil disimpan</div>');
            }
            echo "<script>window.location='" . site_url('menu') . "';</script>";
        }
    }

    public function edit($id)
    {
        $data['menu_id'] = $id;
        $this->template->load('overview', 'menu/editMenu', $data);
    }

    public function get_menu_edit()
    {
        $menu_id = $this->input->post('menu_id');
        $data = $this->m_menu->detail($menu_id)->result();
        echo json_encode($data);
    }

    public function actEdit()
    {
        $id = $this->input->post('id_menu');
        $this->form_validation->set_rules('name_menu', 'name', 'required|callback_menu_check');
        $this->form_validation->set_rules('icon_menu', 'icon', 'required');
        $this->form_validation->set_rules('line_menu', 'line no', 'required');

        //$this->form_validation->set_message('is_unique', 'This %s already exists.');

        $this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['menu_id'] = $id;
            $this->template->load('overview', 'menu/editMenu', $data);
        } else {
            $this->m_menu->update();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissible fade in" role="alert">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' .
                    '</button>' .
                    'Data berhasil diubah</div>');
            }
            echo "<script>window.location='" . site_url('menu') . "';</script>";
        }
    }

    public function menu_check()
    {
        $post = $this->input->post(null, TRUE);
        $sql = $this->db->query("SELECT * FROM tbl_menu WHERE name = '$post[name_menu]' AND tbl_menu_id != '$post[id_menu]'");
        if ($sql->num_rows() > 0) {
            $this->form_validation->set_message('menu_check', 'This %s already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function actDelete($id)
    {
        $data = $this->m_menu->delete($id);
        echo json_encode($data);
    }
}
