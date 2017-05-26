<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

function dateEnToId($string='', $format='') { //convert tanggal dalam bahasa Inggris ke Bahasa Indonesia
	$LongMonth = array(
		'en' => array('January','February','March','April','May','June','July','August','September','October','November','December'),
		'id' => array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember')
		);

	$shortMonthId = array(
		'en' => array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'),
		'id' => array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sept','Okt','Nov','Des')
		);
	$newDate = strtotime($string);
	$newDate = date($format, $newDate);
	$newDate = str_replace($LongMonth['en'], $LongMonth['id'], $newDate);
	$newDate = str_replace($shortMonthId['en'], $shortMonthId['id'], $newDate);

	return $newDate;
}
function make_url($string){
	return str_replace(' ', '-', preg_replace('/\s\s+/', ' ',strtolower(preg_replace('/[^a-z_\-0-9 ]/i', '', preg_replace('/\s\s+/', ' ', strip_tags($string))))));
}
function getBulanRomawi(){
	$today = date("m"); 
	$tahun = date("Y");
	if ($today == "01"){
		$bulan = "I";
	}
	elseif ($today == "02"){
		$bulan = "II";
	}
	elseif ($today == "03"){
		$bulan = "III";
	}
	elseif ($today == "04"){
		$bulan = "IV";
	}
	elseif ($today == "05"){
		$bulan = "V";
	}
	elseif ($today == "06"){
		$bulan = "VI";
	}
	elseif ($today == "07"){
		$bulan = "VII";
	}
	elseif ($today == "08"){
		$bulan = "VIII";
	}
	elseif ($today == "09"){
		$bulan = "IX";
	}
	elseif ($today == "10"){
		$bulan = "X";
	}
	elseif ($today == "11"){
		$bulan = "XI";
	}
	elseif ($today == "12"){
		$bulan = "XII";
	}
	else $bulan = $today;
	return $bulan;
}
function toNum($num) {
	$list=array('A' => 0,
		'B' => 1,
		'C' => 2,
		'D' => 3,
		'E' => 4,
		'F' => 5,
		'G' => 6,
		'H' => 7,
		'I' => 8,
		'J' => 9);
	$temp='';
	$arr_num=str_split ($num);
	foreach($arr_num as $data)
	{
		$temp.=array_search($data,$list);
	}
	$num=$temp;
	return $num;
}
function timeToText($string) {
	$result = '';
	$newDate = strtotime($string);
	if(date('Y-m-d', time())==date('Y-m-d', $newDate)) {
		$rem = time()-$newDate;
		if($rem<300) {
			$result = 'Beberapa menit yang lalu';
		} else {
			$hasil = '';
			$time = floor($rem/60);
			$jam = floor($time/60);
			$menit = $time-($jam*60);
			if($jam>0) {
				$hasil = $jam.' jam';
			}
			if($menit>0) {
				$hasil .= ($hasil!=''?' ':'').$menit.' menit';
			}
			if($hasil!='') {
				$result = $hasil.' yang lalu';
			} else {
				$result = '---';
			}
		}
	} else {
		if(date('Y', time())==date('Y', $newDate)) {
			$result = dateEnToId($string, 'd F').' jam '.dateEnToId($string, 'H:i');
		} else {
			$result = dateEnToId($string, 'd F Y').' jam '.dateEnToId($string, 'H:i');
		}
	}
	return $result;
}
function timeToTextNotif($string) {
	$result = '';
	$newDate = strtotime($string);
	if(date('Y-m-d', time())==date('Y-m-d', $newDate)) {
		$rem = time()-$newDate;
		if($rem<300) {
			$result = '0 Menit';
		} else {
			$hasil = '';
			$time = floor($rem/60);
			$jam = floor($time/60);
			$menit = $time-($jam*60);
			if($jam>0) {
				$hasil = $jam.' Jam';
			}
			if($menit>0) {
				$hasil .= ($hasil!=''?' ':''.$menit.' Menit');
			}
			if($hasil!='') {
				$result = $hasil.'';
			} else {
				$result = '---';
			}
		}
	} else {
		if(date('Y', time())==date('Y', $newDate)) {
			$result = dateEnToId($string, 'd F').'';
		} else {
			$result = dateEnToId($string, 'd F Y').'';
		}
	}
	return $result;
}
function passwordEncoder($text) {
	$first = md5($text);
	$second = '';
	for($i=0;$i<strlen($first);++$i) {
		$second .= ($i%2==0)?substr($first, $i,1):'';
	}
	$third = base64_encode($second);
	return md5($third);
}

?>