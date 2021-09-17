<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends CI_Controller
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
        $data['login_type']  = $login_type;
        $data['page_function']   = __FUNCTION__;
        $data['page_active']       = array('Log');
        $data['page_name']        = 'log';

        $this->load->view('index', $data);
    }

    public function pagination()
    {
        $dt    = $this->log_model->getAllLog();
        $no    = 0;
        $start = $this->input->post('start');
        $data  = array();
        foreach ($dt['data'] as $row) {
            ++$no;
            $th1    = ++$start;
            $th2    = $row->nama;
            $th3    = $row->jenis_aksi;
            $th4    = $row->keterangan;
            $th5    = time_passed(strtotime($row->tgl));
            $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5));
        }
        $dt['data'] = $data;
        echo json_encode($dt);
        die;

        $this->load->view('index', $data);
    }
}
