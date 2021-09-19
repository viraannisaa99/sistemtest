<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log_model extends CI_Model
{

    function getLogToday()
    {
        $this->db->join('user pg', 'pg.user_id = lg.user_id');
        $this->db->order_by('lg.log_id', 'desc');
        $this->db->where('lg.status', 1);
        $this->db->where('lg.tgl', date('Y-m-d'));
        $this->db->from('log lg');
        return $this->db->get()->result();
    }

    function countLog()
    {
        $this->db->select('count(*) as total');
        $this->db->from('log');

        $hasil = $this->db->get()->result();
        return $hasil;
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

    function addLog_transact($data)
    {
        $this->db->insert('log', $data);
    }

    // function getAllLog()
    // {
    //     return $this->datatables
    //         ->select('  
    //         lg.log_id,
    //         pg.nama,
    //         lg.jenis_aksi,
    //         lg.keterangan,
    //         lg.tgl
    //     ')
    //         ->from('log lg')
    //         ->join('user pg', 'pg.user_id = lg.user_id', 'left')
    //         ->where('pg.status = 1 and lg.status=1')
    //         ->generate();
    // }


    function getLog($limit, $start)
    {
        $this->db->join('user pg', 'pg.user_id = lg.user_id');
        $this->db->from('log lg');
        $this->db->order_by('lg.tgl', 'desc');
        $this->db->limit($limit, $start);

        return $this->db->get()->result();
    }

    function countAllLog()
    {
        return $this->db->get('log')->num_rows();
    }
}
