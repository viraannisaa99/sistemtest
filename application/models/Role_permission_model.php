<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role_permission_model extends CI_Model
{
    function insert_batch($result)
    {
        $this->db->insert_batch('role_permission', $result);
    }

    function insert($result)
    {
        $this->db->insert('role_permission', $result);
    }

    function delete($role_id)
    {
        return $this->db->delete('role_permission', array('role_id' => $role_id));
    }

    function getById($id)
    {
        $this->db->select('p.permission_id, p.action, rl.nama_role, rp.role_id');
        $this->db->from('permission p');
        $this->db->join('role_permission rp', 'rp.permission_id = p.permission_id');
        $this->db->join('role rl', 'rl.role_id = rp.role_id');
        $this->db->where('rp.role_id', $id);

        return $this->db->get()->result();
    }
}