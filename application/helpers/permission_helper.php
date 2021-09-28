<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function hasPermission($permission = '')
{
    $CI = get_instance();

    return in_array($permission, $CI->session->userdata('permissions'));
}

function isAdmin()
{
    $CI = get_instance();

    return in_array(1, $CI->session->userdata('role_id'));
}
