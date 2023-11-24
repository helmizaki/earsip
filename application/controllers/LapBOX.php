<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LapBOX extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('is_logged_in') == FALSE) {
            redirect('login');
        }
        $this->load->model('Lap_box_model');
    }


    public function index()
    {
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('footer');
        $this->load->view('laporan_box');
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

    public function show_list()
    {
        $tgl_start = $this->input->post('tgl_start');
        $tgl_finish =  $this->input->post('tgl_finish');

        // Panggil method dari model untuk mengambil data
        $data['result'] = $this->Lap_box_model->get_data($tgl_start, $tgl_finish);

        $json_data = json_encode($data['result']);

        // Mengirimkan data sebagai respons JSON
        header('Content-Type: application/json');
        echo $json_data;
    }

    public function cetak_laporan()
    {
        $tgl_start = $this->input->post('tgl_start');
        $tgl_finish =  $this->input->post('tgl_finish');
        $data = $this->Laporan_minutasi_mod->data_laporan($tgl_start, $tgl_finish);
        require APPPATH . 'third_party/PhpExcel/PhpExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel = PHPExcel_IOFactory::load('template/laporan/laporan.xlsx');
        $worksheet = $objPHPExcel->getActiveSheet();
        $tanggal_awal = $this->tanggal_indonesia($tgl_start);
        $tanggal_akhir = $this->tanggal_indonesia($tgl_finish);
        $awalan =  $tanggal_awal . ' S / D ' . $tanggal_akhir;
        // Menggunakan metode dari library TanggalHelper.php
        // $tanggal_indonesia = $this->tanggal_indonesia($tanggal_penyerahan);
        $worksheet->setCellValue('A2', $awalan);

        $worksheet->getStyle('F')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
        $row = 8;
        $no = 1;
        foreach ($data as $item) {
            $worksheet->setCellValue('A' . $row, $no);
            $worksheet->setCellValue('B' . $row, $item->nomor_perkara);
            $worksheet->setCellValue('C' . $row, $item->jenis_perkara_nama);
            $worksheet->setCellValue('D' . $row, $item->nama_gelar);
            $worksheet->setCellValue('E' . $row, $item->nama);
            $tgl_masuk = PHPExcel_Shared_Date::PHPToExcel(strtotime($item->tanggal_masuk));
            $worksheet->setCellValue('F' . $row, $tgl_masuk);
            $tgl_validasi = PHPExcel_Shared_Date::PHPToExcel(strtotime($item->tanggal_validasi));
            $worksheet->setCellValue('G' . $row, $tgl_validasi);
            $worksheet->setCellValue('H' . $row, $item->tanggal_box);

            // Mengatur garis tepi untuk sel-sel B, C, dan D di baris saat ini
            $cellRange = 'A' . $row . ':H' . $row;
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
        $objWriter->save('template/laporan/laporan_minutasi.xlsx');

        // Kirim respons JSON ke AJAX
        $response = array(
            'success' => true,
            'message' => 'File Excel berhasil dibuat.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
