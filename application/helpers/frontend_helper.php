<?php

if ( ! function_exists('showDate'))
{
	function showDate($date="")
	{						
		$array_hari = array(1=>"Senin","Selasa","Rabu","Kamis","Jumat", "Sabtu","Minggu");
		$array_bulan = array("1" => "Januari", "2" => "Februari", "3" => "Maret", "4" => "April", "5" => "Mei", "6" => "Juni", "7" => "Juli",
			"8" => "Agustus", "9" => "September", "01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
			"08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "December");
		$text = date('d', $date)." ".$array_bulan[date('m', $date)]." ".date('Y', $date);
		return $text;
	}
}

if(!function_exists('qrcode'))
{
	function qrcode()
	{		
		$alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789".date('ymdhis');
		$pass = array();
		$alphaLength = strlen($alphabet) - 1; 
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
}