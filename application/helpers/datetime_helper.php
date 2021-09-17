<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

	function all_hari($num){
		$hari = array('','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
		return $hari[$num];
	}
	
	function all_bulan(){
		return array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	}

	function all_bulan_short(){
		return array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Okt','Nov','Des');
	}

	function indo_date($date){
		$all_bulan = all_bulan();
		$hari = all_hari(date('w',strtotime($date))+1);
        $tanggal =  date('d',strtotime($date));
        // $bulan = date('F',strtotime($date));
        $bulan = $all_bulan[date('n',strtotime($date))];
        $tahun = date('Y',strtotime($date));
        return $hari.', '.$tanggal.'-'.$bulan.'-'.$tahun;
	}

	function dateConvertToDatabase($data){
		$temp = explode('/',$data);
		return date('Y-m-d',strtotime($temp[1].'/'.$temp[0].'/'.$temp[2]));
	}

	function dateConvert2($data){
		//Cek jika format tanggal sudah Y-m-d H:i:s
			$cek_format = DateTime::createFromFormat("Y-m-d H:i:s", $data);
	        if($cek_format)
	        	return $data;

		$bln = array('January','February','March','April','May','June','July','August','September','October','November','December');
        $temp = explode(' - ',$data);
        
        if($temp[1]){
        	$time = $temp[1];
	        $x = explode(' ',$temp[0]);

	        for($i=0;$i<count($bln);$i++){
	            if($x[1]==$bln[$i]){
	                $x[1] = $i+1;
	                $date = $x[0].'-'.$x[1].'-'.$x[2];
	                break;
	            }
	        }
	        $datetime = $date.' '.$time;
	        return date('Y-m-d H:i:s',strtotime($datetime));
        } else {
        	return $temp[0];
        }
	}

// Time Passed
	function time_passed($timestamp){
	    //type cast, current time, difference in timestamps
	    $timestamp      = (int) $timestamp;
	    $current_time   = time();
	    $diff           = $current_time - $timestamp;
	    
	    //intervals in seconds
	    $intervals      = array (
	        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
	    );
	    
	    //now we just find the difference
	    if ($diff == 0)
	    {
	        return 'just now';
	    }    

	    if ($diff < 60)
	    {
	        return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
	    }       

	    if ($diff >= 60 && $diff < $intervals['hour'])
	    {
	        $diff = floor($diff/$intervals['minute']);
	        return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
	    }        

	    if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
	    {
	        $diff = floor($diff/$intervals['hour']);
	        return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
	    }    

	    if ($diff >= $intervals['day'] && $diff < $intervals['week'])
	    {
	        $diff = floor($diff/$intervals['day']);
	        return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
	    }    

	    if ($diff >= $intervals['week'] && $diff < $intervals['month'])
	    {
	        $diff = floor($diff/$intervals['week']);
	        return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
	    }    

	    if ($diff >= $intervals['month'] && $diff < $intervals['year'])
	    {
	        $diff = floor($diff/$intervals['month']);
	        return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
	    }    

	    if ($diff >= $intervals['year'])
	    {
	        $diff = floor($diff/$intervals['year']);
	        return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
	    }
	}

	function time_check($ts){
	    echo time_passed($ts) . '<br />';
	} 

?>