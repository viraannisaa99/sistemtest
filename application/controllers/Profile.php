<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends Middleware
{
    function __construct()
    {
        parent::__construct(false);

        $this->load->model('user_model');
        $this->load->model('role_model');
        $this->load->model('log_model');
        $this->load->model('user_role_model');
        $this->load->model('permission_model');

        $this->load->helper('permission');
        $this->load->helper('format');
        $this->load->helper('userlog');
        $this->load->helper('encrypt');
        $this->load->helper('datetime');
        $this->load->helper('constraint');

        $this->load->library('pdf');
    }

    public function index()
    {
        $page_data['page_function']   = __FUNCTION__;
        $page_data['page_active']     = array('Profile');
        $page_data['page_name']       = 'profile';
        $page_data['page_title']      = 'Profile';

        $page_data['profile'] = $this->user_model->getProfile()->row();

        $this->load->view('index', $page_data);
    }

    public function edit()
    {
        $dt = $this->user_model->getProfile()->result();

        foreach ($dt as $row) {
            $id[] = $row->id;
        }

        if ($id != $this->session->userdata('user_id')) {
            echo json_encode(array('status' => 'error', 'msg' => 'Anda bukan pemilik user ini'));
        } else {
            echo json_encode($dt);
            die;
        }
    }

    public function update()
    {
        $user_id          = $this->session->userdata('user_id');
        $data['nama']     = $this->input->post('nama');
        $data['email']    = $this->input->post('email');
        $data['username'] = $this->input->post('username');

        $this->user_model->update($user_id, $data);

        $this->log_model->addLog(userLog('Memperbaharui Profile', $data['nama'] . ' Memperbaharui profile nya'));

        echo json_encode(array('status' => 'success', 'msg' => 'User berhasil diperbaharui'));

        die;
    }

    public function export()
    {
        $page_data['profile'] = $this->user_model->getProfile()->row();

        $this->pdf->load_view('exportPdf', $page_data);
    }
}