<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notif_model extends CI_Model
{
    function add($data)
    {
        $this->db->insert('notif', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
    }

    function update($id, $data)
    {
        $this->db->where('notif_id', $id);
        $this->db->update('notif', $data);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    function select()
    {
        $this->db->select('*');
        $this->db->from('notif');
        $this->db->order_by('notif_id', 'desc');
        $this->db->limit(5);

        return $this->db->get()->result();
    }

    // get total rows
    function total_rows()
    {
        $this->db->from('notif');
        $this->db->where('baca', 0);
        $this->db->where('user_id', $this->session->userdata('user_id'));
        return $this->db->count_all_results();
    }

    function insert_batch($result)
    {
        $this->db->insert_batch('notif', $result);
    }
}
