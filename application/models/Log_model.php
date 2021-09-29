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
        if (!isAdmin()) {
            $this->db->where('pg.user_id', $this->session->userdata('user_id'));
        }
        return $this->db->get()->result();
    }

    public function graph()
    {
        $this->db->select('*');
        $this->db->from('log');
        $this->db->group_by('WEEK(tgl)');
        return $this->db->get()->result();
    }

    public function countGraph()
    {
        $this->db->select('count(*) as total');
        $this->db->from('log');
        $this->db->group_by('WEEK(tgl)');

        return $this->db->get();
    }

    // public function userGraph()
    // {
    //     $this->db->select('*');
    //     $this->db->from('log lg');
    //     $this->db->join('users pg', 'pg.user_id = lg.log_id');
    //     $this->db->group_by('pg.user_id');
    //     return $this->db->get()->result();
    // }

    // public function countUserGraph()
    // {
    //     $this->db->select('count(lg.log_id) as total');
    //     $this->db->from('log lg');
    //     $this->db->join('users pg', 'pg.user_id = lg.user_id');
    //     $this->db->group_by('pg.user_id');

    //     return $this->db->get();
    // }

    public function userGraph()
    {
        $this->db->select('*');
        $this->db->from('log lg');
        $this->db->join('users pg', 'pg.user_id = lg.user_id');
        $this->db->join('user_role ur', 'pg.user_id = ur.user_id');
        $this->db->join('role rl', 'rl.role_id = ur.role_id');
        $this->db->group_by('rl.role_id');
        return $this->db->get()->result();
    }

    public function countUserGraph()
    {
        $this->db->select('count(lg.log_id) as total');
        $this->db->from('log lg');
        $this->db->join('users pg', 'pg.user_id = lg.user_id');
        $this->db->join('user_role ur', 'pg.user_id = ur.user_id');
        $this->db->join('role rl', 'rl.role_id = ur.role_id');
        $this->db->group_by('rl.role_id');

        return $this->db->get();
    }

    function getAllLog()
    {
        return $this->datatables
            ->select('  
                lg.log_id,
                lg.jenis_aksi,
                lg.keterangan,
                lg.tgl,
                lg.user_id,
            ')
            ->from('log lg')
            ->generate();
    }

    function getExportAll()
    {
        $this->db->join('users pg', 'pg.user_id = lg.user_id');
        $this->db->from('log lg');
        $this->db->order_by('lg.tgl', 'desc');

        $this->load->helper('permission');
        if (!isAdmin()) {
            $this->db->where('pg.user_id', $this->session->userdata('user_id'));
        }
        return $this->db->get()->result();
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