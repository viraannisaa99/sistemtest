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
            redirect('user/userProfile/');
        }

        if (isset($_GET['code'])) {
            $this->google->setAccessToken();
            $gpInfo = $this->google->getUserInfo();

            $userData['email']              = $gpInfo['email'];
            $userData['picture']            = !empty($gpInfo['picture']) ? $gpInfo['picture'] : '';

            $cek = $this->user_model->getUserByEmail($userData['email']);

            if ($cek->result()) {
                $cek_email = $cek->num_rows();
                if ($cek_email > 0) {
                    $result = $cek->row_array();
                    $data['modified'] = date("Y-m-d H:i:s");
                    $data['picture']  = $userData['picture'];

                    $this->login_model->update($data, array('user_id' => $result['user_id']));
                    $userID = $result['user_id'];
                }

                $this->session->set_userdata('user_id', $cek->result()[0]->user_id);
                $this->session->set_userdata('nama', $cek->result()[0]->nama);
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('userData', $userData);

                $this->role();

                redirect('user/userProfile/');

                return $userID ? $userID : false;
            } else {
                $this->session->set_flashdata('error', 'Anda Bukan User di Sistem Ini');
                redirect(base_url() . 'login');
            }
        }
    }

    public function role()
    {
        $user_id = $this->session->userdata('user_id');
        $cek_role  = $this->user_model->getById($user_id);

        foreach ($cek_role as $row) {
            $role_id[] = $row->role_id;
            $nama_role[] = $row->nama_role;
        }

        $this->session->set_userdata('role_id', $role_id);
        $this->session->set_userdata('nama_role', $nama_role);

        // cek permission
        $cek_permission = $this->permission_model->getPermissionByRole($role_id);

        foreach ($cek_permission as $row) {
            $action[] = $row->action;
        }
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
