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
            ->get_where('permission p', array('rp.role_id' => $id))
            ->result();
    }

    function getRoleByUser($id)
    {
        $this->db->select('rl.nama_role');
        $this->db->from('users pg');
        $this->db->join('user_role ur', 'pg.user_id = ur.user_id');
        $this->db->join('role rl', 'rl.role_id = ur.role_id');
        $this->db->where('pg.user_id', $id);

        return $this->db->get()->result();
    }

    var $order_column = array(null, "nama_role", null, null);

    function getSearch()
    {
        $this->db->select("role_id, nama_role");
        $this->db->from("role");

        $post = $this->input->post();

        if (isset($post["search"]["value"])) {
            $this->db->like("nama_role", $post["search"]["value"]);
        }
        if (isset($post["order"])) {
            $this->db->order_by($this->order_column[$post['order']['0']['column']], $post['order']['0']['dir']);
        } else {
            $this->db->order_by("role_id");
        }
    }

    function datatables()
    {
        $this->getSearch();
        $post = $this->input->post();

        if ($post["length"] != -1) {
            $this->db->limit($post['length'], $post['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function getFiltered()
    {
        $this->getSearch();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getAll()
    {
        $this->db->select("*");
        $this->db->from("role");
        return $this->db->count_all_results();
    }
}