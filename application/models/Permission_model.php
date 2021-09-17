<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Permission_model extends CI_Model
{

    public function getPermission()
    {
        $query = $this->db->get('permission');
        return $query;
    }
}
