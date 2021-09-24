<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Middleware extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // $uri = explode("/", $_SERVER['REQUEST_URI']);
        // echo $uri[2];
        // die;
    }
}