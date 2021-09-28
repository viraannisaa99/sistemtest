<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Middleware extends CI_Controller
{
    function __construct($isCheckPermission = true)
    {
        parent::__construct();
        $this->load->helper('permission');

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        if ($isCheckPermission) {
            $obj = $this->uri->segment(1); // nama class
            $action = $this->uri->segment(2); // nama function

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

            if (!userHasPermissions($permission)) {
                show_404();
            }
        }
    }

    // public function permission_allowed($perm = '')
    // {
    //     if (!userHasPermissions($perm)) {
    //         redirect('dashboard');
    //     }
    // }
}