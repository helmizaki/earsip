<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('is_logged_in')) {
			redirect('login');
		}
	}


	public function index()
	{

		$this->load->model('dashboard_modal');
		$data['arsip'] = $this->dashboard_modal->get_arsip();
		$data['sipp'] = $this->dashboard_modal->get_sipp();
		$this->load->view('header');
		$this->load->view('sidebar');
		$this->load->view('footer');
		$this->load->view('dashboard', $data);
	}

	public function get_data()
	{
		$this->load->model('Putusan_model');
		$data = $this->Putusan_model->get_data(); // Ganti dengan metode yang sesuai dari model Anda

		echo json_encode($data);
	}

	public function get_kolom()
	{
		$this->load->model('dashboard_modal');

		$value = $this->input->post('value'); // Mendapatkan nilai dari tombol


		$data = $this->dashboard_modal->get_kolom($value); // Memanggil model untuk mengambil data dari database

		echo json_encode($data);
	}

	public function simpankedb()
	{
		$this->load->model('dashboard_modal');

		$data = array(
			'perkara_id' => $this->input->post('perkara_id'),
			'tanggal_box' => $this->input->post('tanggal_box')
		);

		$saved = $this->dashboard_modal->simpan_box($data);

		if ($saved['status'] === 'success') {
			$response = array('status' => 'success', 'message' => 'Data berhasil disimpan.');
		} else {
			$response = array('status' => 'error', 'message' => $saved['message']);
		}

		echo json_encode($response);
	}

	function tanggal_indonesia($tanggal)
	{
		//date_default_timezone_set("Asia/Jakarta");
		if ($tanggal == "" or $tanggal == NULL) {
			return '-';
			exit;
		}
		$array_hari = array(
			1 => 'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu',
			'Minggu'
		);
		$hari        = $array_hari[date('N', strtotime($tanggal))];
		$array_bulan = array(
			1 => 'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$bulan        = $array_bulan[date('n', strtotime($tanggal))];
		$tgl = date('j', strtotime($tanggal));
		$thn = date('Y', strtotime($tanggal));
		$tgl_indonesia =  $tgl . " " . $bulan . " " . $thn;
		return $tgl_indonesia;
	}


	public function cetak_laporan()
	{
		$tgl_start = $this->input->post('tgl_start');
		$tgl_finish =  $this->input->post('tgl_finish');
		$this->load->model('dashboard_modal');
		$data = $this->dashboard_modal->data_laporan($tgl_start, $tgl_finish);
		require APPPATH . 'third_party/PhpExcel/PhpExcel.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel = PHPExcel_IOFactory::load('template/box/laporan.xlsx');
		$worksheet = $objPHPExcel->getActiveSheet();
		$tanggal_awal = $this->tanggal_indonesia($tgl_start);
		$tanggal_akhir = $this->tanggal_indonesia($tgl_finish);
		$awalan =  $tanggal_awal . ' S / D ' . $tanggal_akhir;
		// Menggunakan metode dari library TanggalHelper.php
		// $tanggal_indonesia = $this->tanggal_indonesia($tanggal_penyerahan);
		$worksheet->setCellValue('A2', $awalan);

		$worksheet->getStyle('E')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
		$row = 8;
		$no = 1;
		foreach ($data as $item) {
			$worksheet->setCellValue('A' . $row, $no);
			$worksheet->setCellValue('B' . $row, $item->nomor_perkara);
			$worksheet->setCellValue('C' . $row, $item->jenis_perkara_nama);
			$worksheet->setCellValue('D' . $row, $item->nama_gelar);
			$tgl_masuk = PHPExcel_Shared_Date::PHPToExcel(strtotime($item->tanggal_masuk));
			$worksheet->setCellValue('E' . $row, $tgl_masuk);
			$tgl_box = PHPExcel_Shared_Date::PHPToExcel(strtotime($item->tanggal_box));
			$worksheet->setCellValue('F' . $row, $tgl_box);

			// Mengatur garis tepi untuk sel-sel B, C, dan D di baris saat ini
			$cellRange = 'A' . $row . ':F' . $row;
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN, // Ganti dengan style yang sesuai
					),
				),
			);
			$worksheet->getStyle($cellRange)->applyFromArray($styleArray);

			$row++;
			$no++;
		}

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('template/box/laporan_box.xlsx');

		// Kirim respons JSON ke AJAX
		$response = array(
			'success' => true,
			'message' => 'File Excel berhasil dibuat.'
		);
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	public function ListArsip()
	{
		$this->load->model('dashboard_modal');
		$data = $this->dashboard_modal->get_list_arsip(); // Memanggil model untuk mengambil data dari database

		echo json_encode($data); // Mengembalikan data dalam format JSON
	}


}