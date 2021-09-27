<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function userLog($aksi = '', $ket = '')
{
	$CI = get_instance();
	$log = array(
		'jenis_aksi'  => $aksi,
		'keterangan'  => $ket,
		'tgl'         => date('Y-m-d H:i:s'),
		'user_id' => $CI->session->userdata('user_id'),
		'status'      => 1
	);
	return $log;
}