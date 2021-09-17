<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function pagination($table)
{
    $CI = get_instance();
    $CI->load->library('pagination');
    $CI->load->model('role_model');

    $config['base_url'] = site_url('role/index');
    $config['total_rows'] = $CI->db->count_all($table);
    $config['per_page'] = 5;
    $config["uri_segment"] = 3;
    $choice = $config["total_rows"] / $config["per_page"];
    $config["num_links"] = floor($choice);

    $config['first_link']       = 'First';
    $config['last_link']        = 'Last';
    $config['next_link']        = 'Next';
    $config['prev_link']        = 'Prev';
    $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
    $config['full_tag_close']   = '</ul></nav></div>';
    $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
    $config['num_tag_close']    = '</span></li>';
    $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
    $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
    $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
    $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['prev_tagl_close']  = '</span>Next</li>';
    $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
    $config['first_tagl_close'] = '</span></li>';
    $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
    $config['last_tagl_close']  = '</span></li>';

    $CI->pagination->initialize($config);

    $data['page'] = ($CI->uri->segment(3)) ? $CI->uri->segment(3) : 0;

    $data['data'] = $CI->role_model->getRolePagination($config["per_page"], $data['page']);

    $data['pagination'] = $CI->pagination->create_links();
}
