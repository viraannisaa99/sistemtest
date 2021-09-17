<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Role_model extends CI_Model
{

    function getRoleById($id)
    {
        return $this->db->get_where('role pg', array('pg.role_id' => $id))->result();
    }

    function update($id, $data)
    {
        $this->db->where('role_id', $id);
        $this->db->update('role', $data);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    function add($data)
    {
        $this->db->insert('role', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    public function delete($id)
    {
        return $this->db->delete('role', array('role_id' => $id));
    }

    public function getRoles()
    {
        return $this->db->get('role');
    }

    function getAllRole()
    {
        return $this->datatables
            ->select('  
                rl.role_id,
                rl.nama_role,
                rl.status,
            ')
            ->from('role rl')
            ->where('rl.status = 1')
            ->generate();
    }

    function getRolePagination($limit, $start)
    {
        $query = $this->db->get('role', $limit, $start);
        return $query;
    }

    function getRoleById2($id)
    {
        $this->db->select('rl.nama_role');
        $this->db->from('role rl');
        $this->db->join('user_role ur', 'rl.role_id = ur.role_id');
        $this->db->where('ur.user_id', $id);

        return $this->db->get()->result();
    }
}
