<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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

        $this->config->load('pagination', TRUE);
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['page_active']        = array('Dashboard');
        $data['page_name']          = 'dashboard';
        $data['page_title']         = 'Dashboard';
        $data['jumlah_user']        = $this->user_model->countUserByLevel();
        $data['jumlah_admin']       = $this->user_model->countUserByLevel('Administrator');
        $data['jumlah_pegawai']     = $this->user_model->countUserByLevel('Pegawai');
        $data['jumlah_kunjungan']   = $this->log_model->count()->result();

        $config['base_url']     = site_url('dashboard/index');
        $config['total_rows']   = 30;
        $config['per_page']     = 15;

        $this->pagination->initialize($config);
        $data['start']  = $this->uri->segment(3);
        $data['log']    = $this->log_model->getLog($config['per_page'], $data['start']);
        $data['links'] = $this->pagination->create_links();

        $this->load->view('index', $data);
    }

    public function weekBar()
    {
        $logGraph          = $this->log_model->logGraph();

        $data = array();
        foreach ($logGraph as $row) {
            $tgl[]  = date('Y-m-d', strtotime($row->tgl));
            $total[] = $row->total;
        }

        $data = array("tgl" => $tgl, "total" => $total);
        echo json_encode($data);
        die;
    }

    public function roleBar()
    {
        $userGraph          = $this->log_model->userLogGraph();

        $data = array();
        foreach ($userGraph as $row) {
            $nama_role[]  = $row->nama_role;
            $total[] = $row->total;
        }

        $data = array("nama_role" => $nama_role, "total" => $total);
        echo json_encode($data);
        die;
    }
}
