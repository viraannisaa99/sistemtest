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

        $this->config->load('pagination', TRUE);
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['page_function']   = __FUNCTION__;
        $data['page_active']       = array('Log');
        $data['page_name']        = 'log';
        $data['page_title']        = 'Log';

        $config['base_url'] = site_url('log/index');
        $config['total_rows'] = $this->log_model->countAllLog();
        $config['per_page']     = 15;

        $this->pagination->initialize($config);
        $data['start']  = $this->uri->segment(3);
        $data['log']    = $this->log_model->getLog($config['per_page'], $data['start']);
        $data['links'] = $this->pagination->create_links();

        $this->load->view('index', $data);
    }
}