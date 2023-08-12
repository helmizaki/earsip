<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('tgl_sql'))
	{
		function tgl_sql($tgl)
		{
			$tgl = DateTime::createFromFormat('d/m/Y', $tgl);
			$tgl = date_format($tgl, "Y-m-d");
			return $tgl;
		}
	}
	
	if ( ! function_exists('tgl_php'))
	{
		function tgl_php($tgl)
		{
			$tgl = DateTime::createFromFormat('Y-m-d', $tgl);
			$tgl = date_format($tgl, "d/m/Y");
			return $tgl;
		}
	}
	
	if ( ! function_exists('tgl_php2'))
	{
		function tgl_php2($tgl)
		{
			$tgl = DateTime::createFromFormat('Y-m-d H:i:s', $tgl);
			$tgl = date_format($tgl, "d/m/Y");
			return $tgl;
		}
	}
	
	if ( ! function_exists('tgl_indo'))
	{
		function tgl_indo()
		{
			$array_hari = array(1=>'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
			$hari = $array_hari[date('N')];
			
			$array_bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Novemer','Desember');
			$bulan = $array_bulan[date('n')];
			
			$tgl = date('j');
			$thn = date('Y');
			
			$tgl_indonesia = $hari.", ".$tgl." ".$bulan." ".$thn ;
			return $tgl_indonesia;
		}
	}
	
	if ( ! function_exists('tgl_indo2'))
	{
		function tgl_indo2($tgl)
		{
			$ubah = gmdate($tgl, time()+60*60*8);
			$pecah = explode("-",$ubah);
			$tanggal = $pecah[2];
			$bulan = bulan($pecah[1]);
			$tahun = $pecah[0];
			return $tanggal.' '.$bulan.' '.$tahun;
		}
	}
	if ( ! function_exists('tgl_indo_sar'))
	{
		function tgl_indo_sar($tgl)
		{
			$day = date('D', strtotime($tgl));
			$dayList = array(
			'Sun' => 'Minggu',
			'Mon' => 'Senin',
			'Tue' => 'Selasa',
			'Wed' => 'Rabu',
			'Thu' => 'Kamis',
			'Fri' => 'Jumat',
			'Sat' => 'Sabtu'
			);
			$hari=$dayList[$day];
			
			
			
			$ubah = gmdate($tgl, time()+60*60*8);
			$pecah = explode("-",$ubah);
			$tanggal = $pecah[2];
			$bulan = bulan($pecah[1]);
			$tahun = $pecah[0];
			return $hari.', '.$tanggal.' '.$bulan.' '.$tahun;
		}
	}
	
	if ( ! function_exists('bulan'))
	{
		function bulan($bln)
		{
			switch ($bln)
			{
				case 1:
				return "Januari";
				break;
				case 2:
				return "Februari";
				break;
				case 3:
				return "Maret";
				break;
				case 4:
				return "April";
				break;
				case 5:
				return "Mei";
				break;
				case 6:
				return "Juni";
				break;
				case 7:
				return "Juli";
				break;
				case 8:
				return "Agustus";
				break;
				case 9:
				return "September";
				break;
				case 10:
				return "Oktober";
				break;
				case 11:
				return "November";
				break;
				case 12:
				return "Desember";
				break;
			}
		}
	}
	
	if ( ! function_exists('nama_hari'))
	{
		function nama_hari($tanggal)
		{
			$ubah = gmdate($tanggal, time()+60*60*8);
			$pecah = explode("-",$ubah);
			$tgl = $pecah[2];
			$bln = $pecah[1];
			$thn = $pecah[0];
			
			$nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
			$nama_hari = "";
			if($nama=="Sunday") {$nama_hari="Minggu";}
			else if($nama=="Monday") {$nama_hari="Senin";}
			else if($nama=="Tuesday") {$nama_hari="Selasa";}
			else if($nama=="Wednesday") {$nama_hari="Rabu";}
			else if($nama=="Thursday") {$nama_hari="Kamis";}
			else if($nama=="Friday") {$nama_hari="Jumat";}
			else if($nama=="Saturday") {$nama_hari="Sabtu";}
			return $nama_hari;
		}
	}
	
	if ( ! function_exists('hitung_mundur'))
	{
		function hitung_mundur($wkt)
		{
			$waktu=array(	365*24*60*60	=> "tahun",
			30*24*60*60		=> "bulan",
			7*24*60*60		=> "minggu",
			24*60*60		=> "hari",
			60*60			=> "jam",
			60				=> "menit",
			1				=> "detik");
			
			$hitung = strtotime(gmdate ("Y-m-d H:i:s", time () +60 * 60 * 8))-$wkt;
			$hasil = array();
			if($hitung<5)
			{
				$hasil = 'kurang dari 5 detik yang lalu';
			}
			else
			{
				$stop = 0;
				foreach($waktu as $periode => $satuan)
				{
					if($stop>=6 || ($stop>0 && $periode<60)) break;
					$bagi = floor($hitung/$periode);
					if($bagi > 0)
					{
						$hasil[] = $bagi.' '.$satuan;
						$hitung -= $bagi*$periode;
						$stop++;
					}
					else if($stop>0) $stop++;
				}
				$hasil=implode(' ',$hasil).' yang lalu';
			}
			return $hasil;
		}
	}
	// global $token_key;
	// $key = 'm4hk4m4h4gung';
	// $CI = &get_instance();
	// $CI->load->model('Api_monitoring_m', 'app');
	// $token = $CI->app->get_token();
	// $newtoken = $key . $token;
	// $token_key = array('User-Agent: Monitoring_aps', 'token:' . md5($newtoken));
	// print_r(md5($newtoken));exit;
	if ( ! function_exists('post_kirim'))
	{
		
		function post_kirim($url, $data){
			global $token_key;
			$return = array('error'=>true,'text'=>'Gagal Menghubungi Server');
			$ch = curl_init($url);
			curl_setopt( $ch, CURLOPT_POST, 1);
			curl_setopt( $ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, get_token());
			curl_setopt( $ch, CURLOPT_HEADER, 0);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
			if($value = json_decode(curl_exec($ch)))
			{
				$value->error = false;
				// $value['error'] = false;
				return (array) $value;
			}
			else{
				return $return;
			}
		}
	}
	
	if (!function_exists('get_data')) {
		function get_data($url)
		{
			// global $token_key;
			$st = array();
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, get_token());
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$output = curl_exec($ch);
			$_err = curl_errno($ch);
			$_errmsg = curl_error($ch);
			if ($value = json_decode($output, true)) {
				return (array) $value;
				// var_dump($value); die;
				} else {
				$st['status'] = false;
				$st['txt'] = $_errmsg;
				return $st;
			}
		}
	}
	if ( ! function_exists('html_kirim')) {
		function html_kirim($url, $data){
			global $token_key;
			$return = array('error'=>true,'text'=>'Gagal Menghubungi Server');
			$ch = curl_init($url);
			curl_setopt( $ch, CURLOPT_POST, 1);
			curl_setopt( $ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, get_token());
			curl_setopt( $ch, CURLOPT_HEADER, 0);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
			return curl_exec($ch);
		}
	}
	if (!function_exists('html_kirim2')) {
		function html_kirim2($url)
		{
			$st = array();
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, get_token());
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			return curl_exec($ch);
		}
	}
	function MD7($str)
	{
		return MD5("PELAPORAN" . $str . "BADILAG");
	}
	function get_token()
	{
		$key = 'm4hk4m4h4gung';
		$CI = &get_instance();
		$CI->load->model('Api_monitoring_m', 'api_m');
		$token = $CI->api_m->get_token();
		$newtoken = $key . $token;
		$token_key = array('User-Agent: Monitoring_aps', 'token:' . md5($newtoken));
		return $token_key;
	}
	
	function no_skum_tampil($isi)
	{
		if(strlen($isi)==1) {$no_u='0000'.$isi;}
		elseif(strlen($isi)==2) {$no_u='000'.$isi;}
		elseif(strlen($isi)==3) {$no_u='00'.$isi;}
		elseif(strlen($isi)==4) {$no_u='0'.$isi;}
		else {$no_u=$isi;}
		
		return $no_u;
		
	}
	function aka_huruf($x)
			{
				$abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
				if ($x < 12)
				return " " . $abil[$x];
				elseif ($x < 20)
				return aka_huruf($x - 10) . "belas";
				elseif ($x < 100)
				return aka_huruf($x / 10) . " puluh" . aka_huruf($x % 10);
				elseif ($x < 200)
				return " seratus" . aka_huruf($x - 100);
				elseif ($x < 1000)
				return aka_huruf($x / 100) . " ratus" . aka_huruf($x % 100);
				elseif ($x < 2000)
				return " seribu" . aka_huruf($x - 1000);
				elseif ($x < 1000000)
				return aka_huruf($x / 1000) . " ribu" . aka_huruf($x % 1000);
				elseif ($x < 1000000000)
				return aka_huruf($x / 1000000) . " juta" . aka_huruf($x % 1000000);
			}
	function gawe_qrcode($data,$dir)
		{
			$CI = get_instance();
			
			/* Load QR Code Library */
			$CI->load->library('ciqrcode');
			
			/* Data */
			$hex_data   = bin2hex($data);
			//$save_name  = $hex_data.'.png';
			$jen=str_replace(" ","",$data);
			$jen=str_replace(":","_",$jen);
			$save_name  = $jen.'.png';
			
			/* QR Code File Directory Initialize */
			//$dir = 'assets/images/qrcode_kwitansi/';
			if (!file_exists($dir)) {
				mkdir($dir, 0775, true);
			}
			
			/* QR Configuration  */
			$config['cacheable']    = true;
			$config['imagedir']     = $dir;
			$config['quality']      = true;
			$config['size']         = '1024';
			$config['black']        = array(255,255,255);
			$config['white']        = array(255,255,255);
			$CI->ciqrcode->initialize($config);
			
			/* QR Data  */
			$params['data']     = $data;
			$params['level']    = 'L';
			$params['size']     = 10;
			$params['savename'] = FCPATH.$config['imagedir']. $save_name;
			
			$CI->ciqrcode->generate($params);
			
			/* Return Data */
			$return = array(
            'content' => $data,
            'file'    => $dir. $save_name
			);
			return $return;
		}
	//VERSI APS
	function app(){
	return (object)array('versi'=> '1.0');}		