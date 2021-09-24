<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model
{
    function countUserByLevel($nama_role = "")
    {
        $this->db->select('count(*) as total');
        $this->db->from('user_role ur');
        $this->db->join('role rl', 'rl.role_id = ur.role_id');
        $this->db->join('users pg', 'pg.user_id = ur.user_id');
        $this->db->where('pg.status = 1');

        if ($nama_role)
            $this->db->where_in('rl.nama_role', $nama_role);

        $hasil = $this->db->get()->result();
        return $hasil;
    }

    function getUserByUsernameByPass($username, $pass)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where(array('username' => $username, 'password' => $pass, 'status' => 1));

        return $this->db->get()->result();
    }

    function getUserByEmail($email)
    {
        $this->db->select('user_id, nama');
        $this->db->from('users');
        $this->db->where(array('email' => $email));

        return $this->db->get();
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

    function update($id, $data)
    {
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    function add($data)
    {
        $this->db->insert('users', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    function delete($id)
    {
        return $this->db->delete('users', array('user_id' => $id));
    }

    function getAllUser()
    {
        return $this->datatables
            ->select('  
                pg.user_id,
                pg.nama,
                pg.email,
                pg.username,
                pg.status,
            ')
            ->from('users pg')
            ->where('pg.status = 1')
            ->generate();
    }
}