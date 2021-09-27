<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Middleware extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('permission');

        // if (!$this->session->userdata('logged_in')) {
        //     redirect('login');
        // } else {
        //     if (userHasPermissions('user-show')) {
        //         // $uri = explode("/", $_SERVER['REQUEST_URI']);
        //         // echo $uri[2];
        //         redirect(base_url() . 'user/pagination');
        //     } else {
        //         // redirect(base_url() . 'login');
        //     }
        //     die;
        // }

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
}