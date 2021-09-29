<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Log extends Middleware
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('log_model');

        $this->load->helper('format');
        $this->load->helper('userlog');
        $this->load->helper('encrypt');
        $this->load->helper('datetime');

        $this->config->load('pagination', TRUE);
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['page_function']   = __FUNCTION__;
        $data['page_active']       = array('Log');
        $data['page_name']        = 'log';
        $data['page_title']        = 'Log';

        $config['base_url'] = site_url('log/index');
        $config['total_rows'] = $this->log_model->countLog()->num_rows();
        $config['per_page']     = 15;

        $this->pagination->initialize($config);
        $data['start']  = $this->uri->segment(3);
        $data['log']    = $this->log_model->getLog($config['per_page'], $data['start']);
        $data['links'] = $this->pagination->create_links();


        $this->load->view('index', $data);
    }

    public function pagination()
    {
        $dt    = $this->log_model->getAllLog();
        $start = $this->input->post('start');
        $data  = array();
        foreach ($dt['data'] as $row) {
            $th1 = ++$start . '.';
            $th2 = $row->jenis_aksi;
            $th3 = $row->keterangan;
            $th4 = $row->tgl;
            $data[] = gathered_data(array($th1, $th2, $th3, $th4));
        }


        $dt['data'] = $data;
        echo json_encode($dt);
        die;
    }

    public function export()
    {
        $allLog = $this->log_model->getLogExport();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Jenis Aksi')
            ->setCellValue('C1', 'Keterangan')
            ->setCellValue('D1', 'Tanggal')
            ->setCellValue('E1', 'User Id');

        $kolom = 2;
        $nomor = 1;
        foreach ($allLog as $log) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $log->jenis_aksi)
                ->setCellValue('C' . $kolom, $log->keterangan)
                ->setCellValue('D' . $kolom, date('j F Y', strtotime($log->tgl)))
                ->setCellValue('E' . $kolom, $log->user_id);

            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Log.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}