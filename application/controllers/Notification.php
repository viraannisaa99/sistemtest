<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Notification extends Middleware
{
    function __construct()
    {
        parent::__construct(); // constructor false

        $this->load->model('user_model');
        $this->load->model('role_model');
        $this->load->model('log_model');
        $this->load->model('user_role_model');
        $this->load->model('permission_model');
        $this->load->model('notif_model');

        $this->load->helper('permission');
        $this->load->helper('format');
        $this->load->helper('userlog');
        $this->load->helper('encrypt');
        $this->load->helper('datetime');
        $this->load->helper('constraint');

        $this->config->load('pagination', TRUE);
        $this->load->library('pagination');
    }

    public function index()
    {
        $page_data['page_function']   = __FUNCTION__;
        $page_data['page_active']     = array('Notification');
        $page_data['page_name']       = 'notification';
        $page_data['page_title']      = 'Notification';


        $this->load->view('index', $page_data);
    }

    public function totalNotif()
    {
        $total = $this->notif_model->total_rows();
        $result['total'] = $total;
        echo json_encode($result);
        die;
    }

    public function listNotif()
    {
        $data = array();
        $list = $this->notif_model->select();

        foreach ($list as $row) {
            $judul[] = $row->judul;
        }

        if (empty($list)) {
            $judul = "No new notification";
        }

        $data = array("judul" => $judul);

        echo json_encode($data);
        die;
    }

    public function isRead()
    {
        $this->db->query("UPDATE notif SET baca = 1 WHERE baca=0");
    }

    public function pagination()
    {
        $dt    = $this->notif_model->getAllNotif();
        $start = $this->input->post('start');
        $data  = array();
        foreach ($dt['data'] as $row) {
            $th1 = ++$start . '.';
            $th2 = $row->judul;
            $th3 = $row->tipe;
            $th4 = $row->link;
            $th5 = $row->tanggal;
            $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5));
        }

        $dt['data'] = $data;
        echo json_encode($dt);
        die;
    }

    public function export()
    {
        $data['tgl_a'] = $this->input->post('tgl_a');
        $data['tgl_b'] = $this->input->post('tgl_b');
        
        $allLog = $this->notif_model->getNotifByDate($data['tgl_a'], $data['tgl_b']);
        
        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Judul')
            ->setCellValue('C1', 'Tipe')
            ->setCellValue('D1', 'Tanggal');

        $kolom = 2;
        $nomor = 1;
        foreach ($allLog as $log) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $log->judul)
                ->setCellValue('C' . $kolom, $log->tipe)
                ->setCellValue('D' . $kolom, date('j F Y', strtotime($log->tanggal)));

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Log.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

        $this->load->view('log', $data);
    }

}