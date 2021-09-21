<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('log_model');
        $this->load->model('permission_model');
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
            $this->session->set_userdata('logged_in', TRUE);
            $this->log_model->addLog(userLog('Login', $cek[0]->nama . ' Login ke System'));

            $this->role();
            redirect(base_url() . 'dashboard');
        } else {
            $this->session->set_flashdata('error', '<br>Username atau Password tidak terdaftar');
            redirect(base_url() . 'login');
        }
    }

    public function role()
    {
        $user_id = $this->session->userdata('user_id');
        $cek  = $this->user_model->getById($user_id);

        $action = json_decode(json_encode(array_column($cek, 'role_id')), true);
        $this->session->set_userdata('role_id', $action);

        $this->check_permission();
    }

    public function check_permission()
    {
        $role_id = $this->session->userdata('role_id');
        $cek = $this->permission_model->getPermissionByRole($role_id);

        $action = json_decode(json_encode(array_column($cek, 'action')), true);

        $this->session->set_userdata('permissions', $action);
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
