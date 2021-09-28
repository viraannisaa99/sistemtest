<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log_model extends CI_Model
{

    function countLog()
    {
        $this->db->select('count(*) as total');
        $this->db->from('log');

        return $this->db->get();
    }

    function addLog($data)
    {
        $this->db->insert('log', $data);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getLog($limit, $start)
    {
        $this->db->join('users pg', 'pg.user_id = lg.user_id');
        $this->db->from('log lg');
        $this->db->order_by('lg.tgl', 'desc');
        $this->db->limit($limit, $start);

        $this->load->helper('permission');
        if (!userIsAdmin()) {
            $this->db->where('pg.user_id', $this->session->userdata('user_id'));
        }
        return $this->db->get()->result();
    }

    // function countAllLog()
    // {
    //     return $this->db->get('log')->num_rows();
    // }
}