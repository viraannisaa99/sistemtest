<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log_model extends CI_Model
{

    function count()
    {
        $this->db->select('count(*) as total');
        $this->db->from('log');

        return $this->db->get();
    }

    function add($data)
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
        if (!isAdmin()) {
            $this->db->where('pg.user_id', $this->session->userdata('user_id'));
        }
        return $this->db->get()->result();
    }

    public function logGraph()
    {
        $this->db->select('tgl, count(*) as total');
        $this->db->from('log');
        $this->db->group_by('WEEK(tgl)');
        return $this->db->get()->result();
    }

    public function userLogGraph()
    {
        $this->db->select('rl.nama_role, count(lg.log_id) as total');
        $this->db->from('log lg');
        $this->db->join('users pg', 'pg.user_id = lg.user_id');
        $this->db->join('user_role ur', 'pg.user_id = ur.user_id');
        $this->db->join('role rl', 'rl.role_id = ur.role_id');
        $this->db->group_by('rl.role_id');
        return $this->db->get()->result();
    }

    function getAllLog()
    {
        $start = $this->input->post('start_d');
        $end = $this->input->post('end_d');

        $this->datatables->select('  
                            lg.log_id,
                            lg.jenis_aksi,
                            lg.keterangan,
                            lg.tgl,
                            lg.user_id');
        $this->datatables->from('log lg');

        if (!empty($start && $end)) {
            $this->datatables->where("DATE(lg.tgl) BETWEEN '$start' AND '$end'"); // if date filter not null then use where
        }

        return $this->datatables->generate();
    }

    function getLogByDate($start, $end)
    {
        $this->db->join('users pg', 'pg.user_id = lg.user_id');
        $this->db->from('log lg');
        $this->db->where('DATE(lg.tgl) >=', $start);
        $this->db->where('DATE(lg.tgl) <=', $end);
        $this->db->where('pg.user_id', $this->session->userdata('user_id'));
        $this->db->order_by('DATE(lg.tgl)');

        return $this->db->get()->result();
    }
}
