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

    function insert_batch($result)
    {
        $this->db->insert_batch('notif', $result);
    }

    function update($id, $data)
    {
        $this->db->where('notif_id', $id);
        $this->db->update('notif', $data);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }

    function count()
    {
        $this->db->from('notif');
        $this->db->where('baca', 0);
        $this->db->where('user_id', $this->session->userdata('user_id'));
        return $this->db->count_all_results();
    }

    function get()
    {
        $this->db->select('judul, link');
        $this->db->from('notif');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->where('baca', 0);
        $this->db->order_by('notif_id', 'desc');
        $this->db->limit(5);

        return $this->db->get()->result();
    }

    function getNotifByDate($start, $end)
    {
        $this->db->join('users pg', 'pg.user_id = nf.user_id');
        $this->db->from('notif nf');
        $this->db->where("DATE(nf.tanggal) BETWEEN '$start' AND '$end'");;
        $this->db->where('pg.user_id', $this->session->userdata('user_id'));
        $this->db->order_by('DATE(nf.tanggal)');

        return $this->db->get()->result();
    }

    function getNotifByDates()
    {
        $start = $this->input->post('start_d');
        $end = $this->input->post('end_d');

        $this->db->join('users pg', 'pg.user_id = nf.user_id');
        $this->db->from('notif nf');

        if (!empty($start && $end)) {
            $this->datatables->where("DATE(nf.tanggal) BETWEEN '$start' AND '$end'"); // if date filter not null then use where
        }

        $this->db->where('pg.user_id', $this->session->userdata('user_id'));
        $this->db->order_by('DATE(nf.tanggal)');

        return $this->db->get()->result();
    }

    function getAllNotif()
    {
        $start = $this->input->post('start_d');
        $end = $this->input->post('end_d');

        $this->datatables->select('  
                nf.judul,
                nf.tipe,
                nf.link,
                nf.tanggal,
                nf.status
            ');
        $this->datatables->from('notif nf');
        $this->datatables->where('nf.user_id', $this->session->userdata('user_id'));

        if (!empty($start && $end)) {
            $this->datatables->where("DATE(nf.tanggal) BETWEEN '$start' AND '$end'"); // if date filter not null then use where
        }

        return $this->datatables->generate();
    }
}
