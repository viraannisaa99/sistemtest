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
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->where('baca', 0);
        $this->db->order_by('notif_id', 'desc');
        $this->db->limit(5);

        return $this->db->get()->result();
    }

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

    function getNotif($limit, $start)
    {
        $this->db->join('users pg', 'pg.user_id = lg.user_id');
        $this->db->from('notif lg');
        $this->db->where('pg.user_id', $this->session->userdata('user_id'));
        $this->db->order_by('lg.tanggal', 'desc');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    function getAllNotif()
    {
        return $this->datatables
            ->select('  
                nf.judul,
                nf.tipe,
                nf.link,
                nf.tanggal,
                nf.status
            ')
            ->from('notif nf')
            ->where('nf.user_id', $this->session->userdata('user_id'))
            ->generate();
    }

    function getNotifByDate($start, $end)
    {
        $this->db->join('users pg', 'pg.user_id = nf.user_id');
        $this->db->from('notif nf');
        $this->db->where('DATE(nf.tanggal) >=', $start);
        $this->db->where('DATE(nf.tanggal) <=', $end);
        $this->db->where('pg.user_id', $this->session->userdata('user_id'));
        $this->db->order_by('DATE(nf.tanggal)');

        return $this->db->get()->result();
    }
}