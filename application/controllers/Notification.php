<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification extends Middleware
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('role_model');
        $this->load->model('log_model');
        $this->load->model('user_role_model');
        $this->load->model('permission_model');
        $this->load->model('notif_model');

        $this->load->helper('permission');
        $this->load->helper('format');
        $this->load->helper('userlog');
        $this->load->helper('encrypt');
        $this->load->helper('datetime');
        $this->load->helper('constraint');

        $this->config->load('pagination', TRUE);
        $this->load->library('pagination');
    }

    public function index()
    {
        $page_data['page_function']   = __FUNCTION__;
        $page_data['page_active']     = array('Notification');
        $page_data['page_name']       = 'notification';
        $page_data['page_title']      = 'Notification';

        $config['base_url']     = site_url('notification/index');
        $config['total_rows']   = 30;
        $config['per_page']     = 15;

        $this->pagination->initialize($config);
        $page_data['start']  = $this->uri->segment(3);
        $page_data['notif']    = $this->notif_model->getNotif($config['per_page'], $page_data['start']);
        $page_data['links'] = $this->pagination->create_links();

        $this->load->view('index', $page_data);
    }

    public function totalNotif()
    {
        $total = $this->notif_model->total_rows();
        $result['total'] = $total;
        echo json_encode($result);
        die;
    }

    public function listNotif()
    {
        $data = array();
        $list = $this->notif_model->select();

        foreach ($list as $row) {
            $judul[] = $row->judul;
        }

        if (empty($list)) {
            $judul = "No new notification";
        }

        $data = array("judul" => $judul);

        echo json_encode($data);
        die;
    }

    public function isRead()
    {
        $this->db->query("UPDATE notif SET baca = 1 WHERE baca=0");
    }
}