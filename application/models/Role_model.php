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

    function getPermissionByRole($role_id)
    {
        $this->db->select('p.action');
        $this->db->from('permission p');
        $this->db->join('role_permission rp', 'rp.permission_id = p.permission_id');
        $this->db->where('rp.role_id', $role_id);

        return $this->db->get()->result();
    }

    function getPermissionAction($id)
    {
        return $this->db->join('role_permission rp', 'rp.permission_id = p.permission_id')
            ->join('role rl', 'rl.role_id = rp.role_id')
            ->get_where('permission p', array('rp.role_id' => $id))->result();
    }
}
