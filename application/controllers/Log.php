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
        $this->load->model('role_model');

        $this->load->helper('format');
        $this->load->helper('userlog');
        $this->load->helper('encrypt');
        $this->load->helper('datetime');

        $this->config->load('pagination', TRUE);
        $this->load->library('pagination');
    }

    public function index()
    {
        $data['page_function']    = __FUNCTION__;
        $data['page_active']      = array('Log');
        $data['page_name']        = 'log';
        $data['page_title']       = 'Log';

        $data['nama_role']        = $this->role_model->getRoles()->result();
        $this->load->view('index', $data);
    }

    // public function export()
    // {
    //     $data['start_date'] = $this->input->post('start_date');
    //     $data['end_date'] = $this->input->post('end_date');

    //     $data['allLog'] = $this->log_model->getLogByDate($data['start_date'], $data['end_date']);

    //     $spreadsheet = new Spreadsheet;

    //     $spreadsheet->setActiveSheetIndex(0)
    //         ->setCellValue('A1', 'No')
    //         ->setCellValue('B1', 'Jenis Aksi')
    //         ->setCellValue('C1', 'Keterangan')
    //         ->setCellValue('D1', 'Tanggal')
    //         ->setCellValue('E1', 'User Id');

    //     $kolom = 2;
    //     $nomor = 1;
    //     foreach ($data['allLog'] as $log) {
    //         $spreadsheet->setActiveSheetIndex(0)
    //             ->setCellValue('A' . $kolom, $nomor)
    //             ->setCellValue('B' . $kolom, $log->jenis_aksi)
    //             ->setCellValue('C' . $kolom, $log->keterangan)
    //             ->setCellValue('D' . $kolom, date('j F Y', strtotime($log->tgl)))
    //             ->setCellValue('E' . $kolom, $log->user_id);

    //         $kolom++;
    //         $nomor++;
    //     }

    //     $writer = new Xlsx($spreadsheet);

    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="Log.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');

    //     $this->load->view('log', $data);
    // }

    public function export()
    {
        // $data['start_d'] = $this->input->post('start_d');
        // $data['end_d'] = $this->input->post('end_d');

        $data['start_d'] = "2021-09-18";
        $data['end_d'] = "2021-09-23";

        $data['allLog'] = $this->log_model->getLogByDate($data['start_d'], $data['end_d']);


        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Jenis Aksi')
            ->setCellValue('C1', 'Keterangan')
            ->setCellValue('D1', 'Tanggal')
            ->setCellValue('E1', 'User Id');

        $kolom = 2;
        $nomor = 1;
        foreach ($data['allLog'] as $log) {
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

        echo json_encode($data);
    }

    public function pagination()
    {
        $dt    = $this->log_model->getAllLog();
        $start = $this->input->post('start');
        $data  = array();

        foreach ($dt['data'] as $row) {
            $role = $this->role_model->getRoleByUser($row->user_id);
            $nama_role = json_decode(json_encode(array_column($role, 'nama_role')), true);

            $th1 = ++$start . '.';
            $th2 = $row->jenis_aksi;
            $th3 = $row->keterangan;
            $th4 = date("Y-m-d", strtotime($row->tgl));
            $th5 = implode(", ", $nama_role);
            $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5));
        }

        $dt['data'] = $data;
        echo json_encode($dt);
        die;
    }

    public function filter()
    {
        $this->load->view('test');
    }
}