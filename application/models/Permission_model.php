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

    function getPermissionByRole($role_id)
    {
        $this->db->select('p.action');
        $this->db->distinct();
        $this->db->from('permission p');
        $this->db->join('role_permission rp', 'rp.permission_id = p.permission_id');
        $this->db->where_in('rp.role_id', $role_id);

        return $this->db->get()->result();
    }
}
