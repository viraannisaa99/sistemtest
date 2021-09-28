<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_role_model extends CI_Model
{

    function insert_batch($result)
    {
        $this->db->insert_batch('user_role', $result);
    }

    function insert($result)
    {
        $this->db->insert('user_role', $result);
    }

    function delete($user_id)
    {
        return $this->db->delete('user_role', array('user_id' => $user_id));
    }

    function select()
    {
        return $this->db->select('*')->from('user_role')->result();
    }

    function getUserByRole($id)
    {
        $this->db->select('ur.user_id, rl.nama_role');
        $this->db->from('role rl');
        $this->db->join('user_role ur', 'ur.role_id = rl.role_id');
        $this->db->where('ur.role_id', $id);

        return $this->db->get()->result();
    }

    function getById($id)
    {
        $this->db->select('pg.*, rl.nama_role, rl.role_id');
        $this->db->from('users pg');
        $this->db->join('user_role ur', 'pg.user_id = ur.user_id');
        $this->db->join('role rl', 'rl.role_id = ur.role_id');
        $this->db->where('pg.user_id', $id);

        return $this->db->get()->result();
    }
}