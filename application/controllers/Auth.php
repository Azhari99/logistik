<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_users');
    }

    public function index() 
    {
        isLogin();
    	$this->load->view('auth/vLogin');
    }

    public function process()
    {
        $post = $this->input->post(null, TRUE);
        if(isset($post['login'])) {
            $result = $this->m_users->checkLogin($post);
            if($result == true) {
                echo "<script>
                    alert('Selamat, login berhasil');
                    window.location = '".site_url('web')."';
                </script>";
            } else {
                echo "<script>
                    alert('Login gagal, username / password salah');
                    window.location = '" . site_url('auth') . "';
                </script>";
            }
        }
    }

    public function logout() 
    {
        $params = array('userid', 'username', 'name', 'level');
        $this->session->unset_userdata($params);
        redirect('auth');
    }
}