<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function userHasPermissions($permission = '')
{
    $CI = get_instance();

    return in_array($permission, $CI->session->userdata('permissions'));
}
