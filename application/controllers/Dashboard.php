<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Auth_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('log_model');

        $this->load->helper('format');
        $this->load->helper('userlog');
        $this->load->helper('encrypt');
        $this->load->helper('datetime');
    }

    public function index()
    {

        $login_type = $this->session->userdata('login_type');
        $page_data['login_type']   = $login_type;
        $data['page_active']       = array('Dashboard');
        $data['page_name']         = 'dashboard';
        $data['jumlah_user']        = $this->user_model->countUserByLevel();
        $data['jumlah_admin']       = $this->user_model->countUserByLevel('Administrator');
        $data['jumlah_pegawai']     = $this->user_model->countUserByLevel('Pegawai');
        $data['jumlah_kunjungan']   = $this->log_model->countLog();

        $this->load->view('index', $data);
    }
}
