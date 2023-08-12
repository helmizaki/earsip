<?php
function tanggal($tgl)
{
	if ($tgl != "") return "'" . $tgl->format('Y-m-d') . "'";
	else return "NULL";
}

function kosong($str)
{
	if (IS_OBJECT($str)) {
		return tanggal($str);
	} else {
		if ($str != "") return '"' . STR_REPLACE('"', "'", $str) . '"';
		else return "NULL";
	}
}
function hitung_umur($tanggal_lahir)
{
	$birthDate = new DateTime($tanggal_lahir);
	$today = new DateTime("today");
	if ($birthDate > $today) {
		exit("0 tahun 0 bulan 0 hari");
	}
	$y = $today->diff($birthDate)->y;
	$m = $today->diff($birthDate)->m;
	$d = $today->diff($birthDate)->d;
	return $y . " tahun " . $m . " bulan ";
}
function rupiah($angka, $format = NULL)
{
	if ($angka == 0) {
		if ($format == NULL) {
			return "-";
		} else {
			return $format;
		}
	} else {
		return number_format($angka, 0, ',', '.');
	}
}

function bilangan($str)
{
	$hasil = intval(str_replace(".", "", $str));
	return $hasil;
}

function jenis_kelamin($str)
{
	if ($str == "Pria") return "L";
	else return "P";
}

function flag($str)
{
	if ($str == '') return "";
	else {
		$array['D'] = "Delete";
		$array['I'] = "Insert";
		$array['U'] = "Update";
		$array['A'] = "Approved";
		return $array[$str];
	}
}

function flag_color($str)
{
	if ($str != 'A') $style = "class=bg-warning";
	else $style = "";

	return $style;
}

function is_active($str)
{
	if (!$str) $style = "bg-warning";
	else $style = "";

	return $style;
}

function is_active2($str)
{
	if ($str) $style = "success";
	else $style = "danger";

	return $style;
}

function jenis_usulan($int)
{
	$array[1] = "<span class='badge bg-gradient-blooker'>APS</span>";
	$array[2] = "<span class='badge bg-gradient-deepblue'>REGULER</span>";

	return $array[$int];
}

function tahap($int)
{
	$array[1] = "Usulan";
	$array[2] = "Rapat Dirjen";
	$array[3] = "Rapat MARI";

	return $array[$int];
}

function tahap_proses_tpm($tahap, $proses)
{
	$hasil = "";

	$array[0] = "Proses";
	$array[1] = "Tolak";
	$array[2] = "Tunda";
	$array[3] = "Setujui";

	if ($tahap == 3) $keterangan_proses = " (" . $array[$proses] . ")";
	else $keterangan_proses = "";

	return tahap($tahap) . $keterangan_proses;
}

function format_tanggal($str1, $str2)
{
	if (substr($str2, 2, 1) == "/" or substr($str2, 2, 1) == "-") //Tanggal Nya Di Balik Dulu kalo jenis nya xx/xx/xxxx
	{
		$str2 	= substr($str2, 6, 4) . "-" . substr($str2, 3, 2) . "/" . substr($str2, 0, 2);
	}

	if ($str2 != NULL and $str2 != "0000-00-00") {
		$dd		= substr($str2, 8, 2);
		$mm 	= substr($str2, 5, 2);
		$yyyy 	= substr($str2, 0, 4);
		switch ($mm) {
			case "1":
				$mmm = 'Jan';
				break;
			case "2":
				$mmm = 'Feb';
				break;
			case "3":
				$mmm = 'Mar';
				break;
			case "4":
				$mmm = 'Apr';
				break;
			case "5":
				$mmm = 'Mei';
				break;
			case "6":
				$mmm = 'Jun';
				break;
			case "7":
				$mmm = 'Jul';
				break;
			case "8":
				$mmm = 'Agu';
				break;
			case "9":
				$mmm = 'Sep';
				break;
			case "10":
				$mmm = 'Okt';
				break;
			case "11":
				$mmm = 'Nov';
				break;
			case "12":
				$mmm = 'Des';
				break;
		}
		switch ($mm) {
			case 1:
				$mmmm = 'Januari';
				break;
			case 2:
				$mmmm = 'Februari';
				break;
			case 3:
				$mmmm = 'Maret';
				break;
			case 4:
				$mmmm = 'April';
				break;
			case 5:
				$mmmm = 'Mei';
				break;
			case 6:
				$mmmm = 'Juni';
				break;
			case 7:
				$mmmm = 'Juli';
				break;
			case 8:
				$mmmm = 'Agustus';
				break;
			case 9:
				$mmmm = 'September';
				break;
			case 10:
				$mmmm = 'Oktober';
				break;
			case 11:
				$mmmm = 'November';
				break;
			case 12:
				$mmmm = 'Desember';
				break;
		}

		switch (date("w", strtotime($str2))) {
			case "0":
				$w = 'Minggu';
				$h = "Mg";
				break;
			case "1":
				$w = 'Senin';
				$h = "Sn";
				break;
			case "2":
				$w = 'Selasa';
				$h = "Sl";
				break;
			case "3":
				$w = 'Rabu';
				$h = "Rb";
				break;
			case "4":
				$w = 'Kamis';
				$h = "Km";
				break;
			case "5":
				$w = "Jum'at";
				$h = "Jm";
				break;
			case "6":
				$w = 'Sabtu';
				$h = "Sb";
				break;
		}

		switch ($str1) {
			case "wdmy":
				return $h . ', ' . $dd . ' ' . substr($mmmm, 0, 3) . ' ' . substr($yyyy, 2, 2);
				break;
			case "wddmmmmyyyyhis":
				return $w . ', ' . $dd . ' ' . $mmmm . ' ' . $yyyy . ' ' . substr($str2, 11, 8);
				break;
			case "wddmmmmyyyy":
				return $w . ', ' . $dd . ' ' . $mmmm . ' ' . $yyyy;
				break;
			case "ddmmmmyyyy":
				return $dd . ' ' . $mmmm . ' ' . $yyyy;
				break;
			case "ddmmmm":
				return $dd . ' ' . $mmmm;
				break;
			case "wddmmmm":
				return $w . ', ' . $dd . ' ' . $mmmm;
				break;
			case "ddmmmyy":
				return $dd . ' ' . $mmm . ' ' . substr($yyyy, 2, 2);
				break;
			case "ddmmmyyyy":
				return $dd . ' ' . $mmm . ' ' . $yyyy;
				break;
			case "wddmmyy":
				return $h . ', ' . $dd . '/' . $mm . '/' . substr($yyyy, 2, 2);
				break;
			case "ddmmyy":
				return $dd . '/' . $mm . '/' . substr($yyyy, 2, 2);
				break;
			case "ddmmyyyy":
				return $dd . '/' . $mm . '/' . $yyyy;
				break;
			case "dmmmmyyyy":
				return intval($dd)." ".$mmmm." ".$yyyy;
				break;
			case "dd-mm-yyyy":
				return $dd . '-' . $mm . '-' . $yyyy;
				break;
			case "mmmm":
				return $mmmm;
				break;
			case "yyyy":
				return $yyyy;
				break;
			case "yyyymmdd":
				return $yyyy . '/' . $mm . '/' . $dd;
				break;
			case "w":
				return $w;
				break;
			case "his":
				return substr($str2, 11, 8);
				break;
			default:
				return 'Format Salah';
				break;
		}
	} else {
		return "";
	}
}

function nama_bulan($nomor)
{
	$b = "";
	switch ($nomor) {
		case "1":
			$b = 'Januari';
			break;
		case "2":
			$b = 'Februari';
			break;
		case "3":
			$b = 'Maret';
			break;
		case "4":
			$b = 'April';
			break;
		case "5":
			$b = 'Mei';
			break;
		case "6":
			$b = 'Juni';
			break;
		case "7":
			$b = 'Juli';
			break;
		case "8":
			$b = 'Agustus';
			break;
		case "9":
			$b = 'September';
			break;
		case "10":
			$b = 'Oktober';
			break;
		case "11":
			$b = 'November';
			break;
		case "12":
			$b = 'Desember';
			break;
	}
	return $b;
}

function tgl_time($str1, $str2)
{
	$temp = explode(' ', $str2);
	$date = $temp[0];
	$time = $temp[1];
	$date = format_tanggal($str1, $date);
	return $date . " - " . $time;
}
function balik_tanggal($tgl, $format = NULL) //Format: dmy 12-01-2017,ymd 2017-01-12
{
	if ($tgl == "") {
		$tgl = "";
	} else {
		if ($format == NULL) {
			if (substr($tgl, 2, 1) == "/" or substr($tgl, 2, 1) == "-") {
				$tgl = substr($tgl, 6, 4) . "-" . substr($tgl, 3, 2) . "-" . substr($tgl, 0, 2);
			} else {
				$tgl = substr($tgl, 8, 2) . "/" . substr($tgl, 5, 2) . "/" . substr($tgl, 0, 4);
			}
		} else {
			if (substr($tgl, 2, 1) == "/" or substr($tgl, 2, 1) == "-") {
				if ($format == "dmy") {
					$tgl = $tgl;
				} else {
					$tgl = substr($tgl, 6, 4) . "/" . substr($tgl, 3, 2) . "/" . substr($tgl, 0, 2);
				}
			} else {
				if ($format == "ymd") {
					$tgl = $tgl;
				} else {
					$tgl = substr($tgl, 0, 4) . "-" . substr($tgl, 5, 2) . "-" . substr($tgl, 8, 2);
				}
			}
		}
	}
	return $tgl;
}

function tanggal_db($tgl)
{
	if ($tgl == "") {
		$tgl = "";
	} else {
		if (substr($tgl, 2, 1) == "/" or substr($tgl, 2, 1) == "-") {
			$tgl = substr($tgl, 6, 4) . "/" . substr($tgl, 3, 2) . "/" . substr($tgl, 0, 2);
		}
	}
	return $tgl;
}

function tanggal_dp($tgl)
{
	if ($tgl == "") {
		$tgl = "";
	} else {
		if (substr($tgl, 4, 1) == "/" or substr($tgl, 4, 1) == "-") {
			$tgl = substr($tgl, 0, 4) . "-" . substr($tgl, 5, 2) . "-" . substr($tgl, 8, 2);
		}
	}
	return $tgl;
}

function clean($str)
{
	return preg_match("/^[a-zA-Z0-9]+$/", $str);
}

function CEKNULL($str)
{
	if ($str == "") return "NULL";
	else return "\"$str\"";
}
function strposa($haystack, $needle = array(), $offset = 0)
{
	if (!is_array($needle)) $needle = array($needle);
	foreach ($needle as $query) {
		if (strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
	}
	return false;
}
function diperbantukan($int)
{
	if ($int == 1) return "Ya";
	else return "Tidak";
}

function opval($operator, $value)
{
	$hasil = "";
	if ($operator == 'IN') {
		$value = "'" . STR_REPLACE("|", "','", $value) . "'";
		$hasil = " $operator ($value)";
	} elseif ($operator == 'BETWEEN') {
		$explode = EXPLODE('|', $value);
		if ($explode[0] > $explode[1])
			$value = "'$explode[1]' AND '$explode[0]'";
		else
			$value = "'$explode[0]' AND '$explode[1]'";
		$hasil = " $operator $value";
	} elseif ($operator == 'LIKE') {
		$hasil = " $operator '%$value%'";
	} else {
		$hasil = " $operator \"$value\"";
	}

	return $hasil;
}

function nip_titik($nip)
{
	$nip = substr($nip, 0, 8) . "." . substr($nip, 8, 6) . "." . substr($nip, 14, 1) . "." . substr($nip, 15, 3);
	return $nip;
}

function nip_tanpa_titik($nip)
{
	$nip = str_replace(".", "", $nip);
	return $nip;
}


function nama_satker_singkat($satker)
{
	$satker = str_replace("Mahkamah Syar`iyah", "MS", $satker);
	$satker = str_replace("Pengadilan Tinggi Agama", "PTA", $satker);
	$satker = str_replace("Pengadilan Agama", "PA", $satker);
	$satker = str_replace("Badan Urusan Administrasi", "BUA", $satker);
	$satker = str_replace("Direktorat Jenderal Badan Peradilan Agama", "DITJEN BADILAG", $satker);
	$satker = str_replace("Direktorat Jenderal Badan Peradilan Umum", "DITJEN BADILUM", $satker);
	$satker = str_replace("Direktorat Jenderal Badan Peradilan Militer Dan Tata Usaha Negara", "DITJEN BADILMILTUN", $satker);
	$satker = str_replace("Badan Penelitian Dan Pengembangan Dan Pendidikan Dan Pelatihan Hukum Dan Peradilan", "BLDK", $satker);
	$satker = str_replace("Badan Pengawasan", "BAWAS", $satker);
	return $satker;
}

function nama_jabatan_singkat($jabatan)
{
	$jabatan = str_replace("Kepala Sub Bagian Umum Dan Keuangan", "Kasubbag Umum dan Keuangan", $jabatan);
	$jabatan = str_replace("Kepala Sub Bagian Kepegawaian, Organisasi, Dan Tata Laksana", "Kasubbag Kepegawaian dan Ortala", $jabatan);
	$jabatan = str_replace("Kepala Sub Bagian Perencanaan Teknologi Informasi, Dan Pelaporan", "Kasubbag PTIP", $jabatan);
	$jabatan = str_replace("Kepala Sub Bagian Kepegawaian Dan Teknologi Informasi", "Kasubbag Kepegawaian dan TI", $jabatan);
	$jabatan = str_replace("Kepala Sub Bagian Rencana Program Dan Anggaran", "Kasubbag  Rencana Program Dan Anggaran", $jabatan);
	$jabatan = str_replace("Kepala Sub Bagian", "Kasubbag", $jabatan);
	return $jabatan;
}

function ya($int)
{
	if ($int == 0) return "Tidak";
	elseif ($int == 1) return "Ya";
	else return "Salah: Value Harus 0 atau 1";
}

function cdn_foto($foto1 = null, $foto2 = null, $size = '120')
{  // MANA YG ADA, FOTO PROFIL ATAU FOTO PEGAWAI
	$img = 'https://freepikpsd.com/file/2019/10/default-png-2-Transparent-Images.png';
	if (!empty($foto1))
		$img = "https://sikep.mahkamahagung.go.id/uploads/foto_pegawai/" . trim($foto1);
	if (!empty($foto2))
		$img = "https://sikep.mahkamahagung.go.id/uploads/foto_formal/" . trim($foto2);
	$cdn = "//images.weserv.nl/?url=" . $img . "&w=" . $size;
	return $cdn;
}
function file_doc($file_doc = null, $folder_doc, $title, $icon = '')
{
	$tooltip = 'data-bs-tooltip="tooltip" data-bs-placement="top" title="' . $title . '"';
	$text_icon 	= 'bx bx-file';
	if ($icon) $text_icon = $icon;
	$link = '';
	if (!empty($file_doc)) {
		$link = '<a class="btn-sm btn-success" href="https://sikep.mahkamahagung.go.id/site/file?filename=' . $file_doc . '&folder=' . $folder_doc . ' " target="_blank" ' . $tooltip . '><i class="' . $text_icon . ' "></i></a>';
	} else {
		$link = '<a class="btn-sm btn-danger"><i class="' . $text_icon . ' " data-bs-tooltip="tooltip" data-bs-placement="top" title="'.$title.' Tidak Tersedia"></i></a>';
	}
	return $link;
}

function jenis_media($value)
	{
		if($value>0)return "Online"; else return "Offline";
	}

function jenis_sertifikat($value)
	{
		if($value>0)return "Ada Sertifikat"; else return "Tidak Ada Sertifikat";
	}
function jenis_pasangan($value)
	{
		if($value == "Pria") return "Suami "; 
		else if($value == "Wanita") return "Istri "; 
		else return "-";
	}
