<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Middleware extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('permission');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $whitelist = ['dashboard', 'log', 'notification', 'profile'];
        $obj = $this->uri->segment(1); // nama class
        $action = $this->uri->segment(2); // nama function

        if (!in_array($obj, $whitelist)) {

            $trans = array(
                'edit' => 'update',
                'pagination' => 'show'
            ); // transformasi function, dan samakan pemanggilannya dengan permission

            /**
             * if uri segment 2 kosong, maka berikan akses untuk show
             * else tidak kosong maka cek lagi, apakah ada action dengan nama edit
             * jika ada maka transformasi agar sesuai dengan value di tabel permission
             */
            $action = $action == '' ? 'show' : (isset($trans[$action]) ? $trans[$action] : $action);
            $permission = $obj . "-" . $action; // permission = user-add, user-show

            if (!hasPermission($permission)) {
                show_404(); // show not found if doesn't have access
            }
        }
    }
}
