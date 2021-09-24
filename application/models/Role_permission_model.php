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
}