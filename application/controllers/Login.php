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
        $this->load->model('login_model');
        $this->load->helper('userLog');
        $this->load->helper('encrypt');

        $this->load->model('login_model');
        $this->config->load('google', TRUE);
        $this->load->library('google');
    }

    public function index()
    {
        $data['loginURL'] = $this->google->getLoginURL();

        $this->load->view('login', $data);
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

    public function googleOauth()
    {
        if ($this->session->userdata('logged_in') == true) {
            redirect('user/profile/'); // redirect ke profile jika sudah login
        }

        if (isset($_GET['code'])) {
            $this->google->setAccessToken(); // authenticate user with google
            $gpInfo = $this->google->getUserInfo(); // Get user info from google

            /* data untuk di insert ke database */
            $userData['oauth_provider']     = 'google';
            $userData['oauth_uid']          = $gpInfo['id'];
            $userData['email']              = $gpInfo['email'];
            $userData['locale']             = !empty($gpInfo['locale']) ? $gpInfo['locale'] : '';
            $userData['picture']            = !empty($gpInfo['picture']) ? $gpInfo['picture'] : '';

            $this->login_model->checkUser($userData); // insert atau update user data ke database

            $cek = $this->user_model->getUserByEmail($userData['email']);

            $this->session->set_userdata('user_id', $cek[0]->user_id);
            $this->session->set_userdata('logged_in', true);
            $this->session->set_userdata('userData', $userData);

            $this->role();

            redirect('user/profile/');
        }
    }

    public function role()
    {
        $user_id = $this->session->userdata('user_id');
        $cek_role  = $this->user_model->getById($user_id);

        $action = json_decode(json_encode(array_column($cek_role, 'role_id')), true);
        $this->session->set_userdata('role_id', $action);

        // cek permission
        $role_id = $this->session->userdata('role_id');
        $cek_permission = $this->permission_model->getPermissionByRole($role_id);

        $action = json_decode(json_encode(array_column($cek_permission, 'action')), true);

        $this->session->set_userdata('permissions', $action);
    }

    public function logout()
    {
        if ($this->session->userdata('user_id')) {
            $this->log_model->addLog(userLog('Logout', $this->session->userdata('nama') . ' Logout dari System'));
        }
        $this->session->sess_destroy();
        $this->google->logout();
        redirect(base_url() . 'login');
    }
}