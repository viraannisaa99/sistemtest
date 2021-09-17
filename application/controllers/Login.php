<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('log_model');
        $this->load->helper('userLog');
        $this->load->helper('encrypt');
    }
    public function index()
    {
        $this->load->view('login');
    }

    public function oauth()
    {
        $uname    = $this->input->post('username');
        $password = hash('sha512', $this->input->post('password'));
        $cek      = $this->user_model->getUserByUsernameByPass($uname, $password);
        if ($cek) {
            $this->session->set_userdata('user_id', $cek[0]->user_id);
            $this->session->set_userdata('nama', $cek[0]->nama);
            $this->session->set_userdata('login_type', $cek[0]->nama_role);
            $this->session->set_userdata('logged_in', TRUE);
            $this->log_model->addLog(userLog('Login', $cek[0]->nama . ' Login ke System'));

            if ($cek[0]->nama_role == "Administrator") {
                redirect(base_url() . 'dashboard');
            } else {
                redirect(base_url() . 'user');
            }
        } else {
            $this->session->set_flashdata('error', '<br>Username atau Password tidak terdaftar');
            redirect(base_url() . 'login');
        }
    }

    public function logout($param = '')
    {
        if ($this->session->userdata('user_id')) {
            $this->log_model->addLog(userLog('Logout', $this->session->userdata('nama') . ' Logout dari System'));
        }
        $this->session->sess_destroy();
        redirect(base_url() . 'login');
    }
}
