<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function variabel($string,$perkara_id){
		$CI = get_instance();
		$CI->load->model('abt/Abt_model');
		$variabel = $CI->Abt_model->get_variabel($string);
		if($variabel){
		foreach ($variabel as $var){
				$data		  = $CI->Abt_model->data_variabel_detil($perkara_id,$var)['value'];
				$data 		  = str_replace("DATA_TIDAK_ADA","...",$data);
				$data 		  = str_replace("TIDAK_BISA_LOAD","...",$data);
				$var_string[] = '#'.$var.'#';
				$value[]	  = $data;}}
		else{
				$var_string[] = NULL;
				$value[]	  = NULL;}
		return str_replace($var_string,$value,$string);		
	}

function getBulan2($bln){
				switch ($bln){
					case 0: 
						return " ";
						break;
					case 1: 
						return " Jan. ";
						break;
					case 2:
						return " Feb. ";
						break;
					case 3:
						return " Mar. ";
						break;
					case 4:
						return " Apr. ";
						break;
					case 5:
						return " Mei ";
						break;
					case 6:
						return " Jun. ";
						break;
					case 7:
						return " Jul. ";
						break;
					case 8:
						return " Ags. ";
						break;
					case 9:
						return " Sep. ";
						break;
					case 10:
						return " Okt. ";
						break;
					case 11:
						return " Nov. ";
						break;
					case 12:
						return " Des. ";
						break;
				}
			}
			
function tgl_indo3($tanggal){
$day = date('D', strtotime($tanggal));
$dayList = array(
	'Sun' => 'Minggu',
	'Mon' => 'Senin',
	'Tue' => 'Selasa',
	'Wed' => 'Rabu',
	'Thu' => 'Kamis',
	'Fri' => 'Jumat',
	'Sat' => 'Sabtu');
$tgl = substr($tanggal,8,2);
$bulan = getBulan2(substr($tanggal,5,2));
$tahun = substr($tanggal,0,4);
return $dayList[$day].',<br>'.$tgl.$bulan.$tahun;}
			
function tgl_indo4($tanggal){
$day = date('D', strtotime($tanggal));
$dayList = array(
	'Sun' => 'Minggu',
	'Mon' => 'Senin',
	'Tue' => 'Selasa',
	'Wed' => 'Rabu',
	'Thu' => 'Kamis',
	'Fri' => 'Jumat',
	'Sat' => 'Sabtu');
$tgl = substr($tanggal,8,2);
$bulan = getBulan2(substr($tanggal,5,2));
$tahun = substr($tanggal,0,4);
return $dayList[$day].', '.$tgl.$bulan.$tahun;}

function tgl_php3($tgl){
	if(empty($tgl)){return NULL;}
		$tgl = DateTime::createFromFormat('Y-m-d H:i:s', $tgl);
		$tgl = date_format($tgl, "d/m/Y");
		return $tgl;
	}


function tgl_view ($tgl) {
	return substr($tgl,8,2).substr($tgl,4,4).substr($tgl,0,4);}

function spaces_remove($str){
	return str_replace(' ','%20',$str);}

function cekstring($string,$key){
	if (strpos(strtolower($string),strtolower($key))!==FALSE){
		return TRUE;}
	else {
		return FALSE;}}
	
function filesize_formatted($sizes)	{	
			$units = array( 'kb', 'mb', 'gb');
			$power = $sizes > 0 ? floor(log($sizes, 1024)) : 0;	
			return number_format($sizes / pow(1024, $power), 0, '.', ',') . ' ' . $units[$power];
			}

function array_search_inner ($array, $attr, $val, $strict = FALSE) {
  if (!is_array($array)) return FALSE;
  foreach ($array as $key => $inner) {
    if (!is_array($inner)) return FALSE;
    if (!isset($inner[$attr])) continue;
    if ($strict) {
      if ($inner[$attr] === $val) return $key;
    } else {
      if ($inner[$attr] == $val) return $key;
    }
  }
  return NULL;
}


function pesan(){
	return "<h1 align=center>Untuk pengguna linux jalankan perintah <br><br>chown -R apache:apache /var/www/html/</h1>";
}	

?>