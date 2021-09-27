<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function userNotif($judul = '', $tipe = '', $user_id = '')
{
    $notif = array(
        'judul'   => $judul,
        'tipe'    => $tipe,
        'baca'    => 0,
        'user_id' => $user_id,
        'link'    => site_url('profile/index'),
        'tanggal' => date("Y-m-d H:i:s")
    );

    return $notif;
}