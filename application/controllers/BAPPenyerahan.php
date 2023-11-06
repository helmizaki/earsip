<?php
defined('BASEPATH') or exit('No direct script access allowed');
class BAPPenyerahan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('BAP_model');
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
        $tgl_indonesia = $hari . " Tanggal " . $tgl . " " . $bulan . " " . $thn;
        return $tgl_indonesia;
    }
    function is_login()
    {
        if ($this->session->userdata('is_logged_in') == NULL or $this->session->userdata('is_logged_in') == "") {
            $this->session->sess_destroy();
            redirect('login');
        }
    }
    public function index()
    {
        $this->is_login();
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('footer');
        $this->load->view('bap_penyerahan');
    }
    public function list_minutasi()
    {
        $value = $this->input->post('value'); // Mendapatkan nilai dari tombol
        $data = $this->List_minutasi->get_list_minutasi($value); // Memanggil model untuk mengambil data dari database
        echo json_encode($data); // Mengembalikan data dalam format JSON
    }
    public function get_BAP()
    {
        $value = $this->input->post('value'); // Mendapatkan nilai dari tombol
        $data = $this->BAP_model->get_list_BAP($value); // Memanggil model untuk mengambil data dari database
        echo json_encode($data); // Mengembalikan data dalam format JSON
    }
    public function get_data()
    {
        $data = $this->BAP_model->get_data(); // Ganti dengan metode yang sesuai dari model Anda
        $response = array(
            'data' => $data
        );
        echo json_encode($response);
    }
    public function CetakKeWord()
    {
        require APPPATH . 'third_party/PhpExcel/PhpExcel.php';
        $dataGut = $this->BAP_model->get_panmudGut();
        $dataHuk = $this->BAP_model->get_panmudHuk();
        $dataPer = $this->BAP_model->get_panmudPer();
        
        // Mengambil data sebagai array biasa dari objek
        $dataGutArray = [];
        $dataHukArray = [];
        $dataPerArray = [];
        foreach ($dataGut as $item) {
            $dataGutArray[] = (array) $item;
        }
        foreach ($dataHuk as $item) {
            $dataHukArray[] = (array) $item;
        }
        foreach ($dataPer as $item) {
            $dataPerArray[] = (array) $item;
        }
        $selected_items = $this->input->post('selected_items');
        // Panggil class PHPExcel nya
        $objPHPExcel = new PHPExcel();
        // Membaca file Excel yang sudah ada
        $objPHPExcel = PHPExcel_IOFactory::load('template/konsep.xlsx');
        $worksheet = $objPHPExcel->getActiveSheet();
        // Menggunakan variabel row untuk mengawasi baris saat mengisi data
        $row = 17;
        $no = 1;
        // Mengatur format tanggal "d/m/Y" untuk kolom tanggal (kolom C)
        $worksheet->getStyle('F')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
        foreach ($selected_items as $item) {
            $worksheet->setCellValue('A' . $row, $no);
            $worksheet->setCellValue('B' . $row, $item['nomor_perkara']);

            $worksheet->setCellValue('C' . $row, $item['jenis_perkara_nama']);
            $worksheet->setCellValue('D' . $row, $item['pp']);
            $worksheet->setCellValue('E' . $row, $item['jenis_putusan']);
            $tgl_min = PHPExcel_Shared_Date::PHPToExcel(strtotime($item['tanggal_minutasi']));
            $worksheet->setCellValue('F' . $row, $tgl_min);

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
            // Anda dapat menambahkan lebih banyak kolom sesuai kebutuhan
            $row++;
            $no++;
        }
        $roww = $row + 2;
        $newrow = $roww + 4;
        $pilihDari = $this->input->post('pilih_dari');
        $pilihMenuju = $this->input->post('pilih_menuju');
        $tanggal_penyerahan = $this->input->post('tanggal_penyerahan');
        $tanggal_indonesia = $this->tanggal_indonesia($tanggal_penyerahan);
        $awalan = 'Pada hari ini ' . $tanggal_indonesia . ' bertempat di Ruang  kepaniteraan Pengadilan Agama Ngawi, kami yang bertanda tangan di bawah ini :';
        // Menggunakan metode dari library TanggalHelper.php
        // $tanggal_indonesia = $this->tanggal_indonesia($tanggal_penyerahan);
        $worksheet->setCellValue('A4', $awalan);
        if ($pilihDari === 'Panmud Hukum') {
            if (!empty($dataHukArray)) {
                $worksheet->getStyle('B' . $newrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $worksheet->setCellValue('B' . $roww, $dataHukArray[0]['jabatan']);
                $worksheet->setCellValue('B' . $newrow, $dataHukArray[0]['nama']);
                $worksheet->setCellValue('B6', $dataHukArray[0]['nama']);
                $worksheet->setCellValue('B7', $dataHukArray[0]['jabatan']);
            }
        } elseif ($pilihDari === 'Panmud Gugatan') {
            if (!empty($dataGutArray)) {
                $worksheet->getStyle('B' . $newrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $worksheet->setCellValue('B' . $roww, $dataGutArray[0]['jabatan']);
                $worksheet->setCellValue('B' . $newrow, $dataGutArray[0]['nama']);
                $worksheet->setCellValue('B6', $dataGutArray[0]['nama']);
                $worksheet->setCellValue('B7', $dataGutArray[0]['jabatan']);
            }
        } elseif ($pilihDari === 'Panmud Permohonan') {
            if (!empty($dataPerArray)) {
                $worksheet->getStyle('B' . $newrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $worksheet->setCellValue('B' . $roww, $dataPerArray[0]['jabatan']);
                $worksheet->setCellValue('B' . $newrow, $dataPerArray[0]['nama']);
                $worksheet->setCellValue('B6', $dataPerArray[0]['nama']);
                $worksheet->setCellValue('B7', $dataPerArray[0]['jabatan']);
            }
        }
        if ($pilihMenuju === 'Panmud Hukum') {
            if (!empty($dataHukArray)) {
                $worksheet->getStyle('E' . $newrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $worksheet->setCellValue('E' . $roww, $dataHukArray[0]['jabatan']);
                $worksheet->setCellValue('E' . $newrow, $dataHukArray[0]['nama']);
                $worksheet->setCellValue('B9', $dataHukArray[0]['nama']);
                $worksheet->setCellValue('B10', $dataHukArray[0]['jabatan']);
            }
        } elseif ($pilihMenuju === 'Panmud Gugatan') {
            if (!empty($dataGutArray)) {
                $worksheet->getStyle('E' . $newrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $worksheet->setCellValue('E' . $roww, $dataGutArray[0]['jabatan']);
                $worksheet->setCellValue('E' . $newrow, $dataGutArray[0]['nama']);
                $worksheet->setCellValue('B9', $dataGutArray[0]['nama']);
                $worksheet->setCellValue('B10', $dataGutArray[0]['jabatan']);
            }
        } elseif ($pilihMenuju === 'Panmud Permohonan') {
            if (!empty($dataPerArray)) {
                $worksheet->getStyle('E' . $newrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $worksheet->setCellValue('E' . $roww, $dataPerArray[0]['jabatan']);
                $worksheet->setCellValue('E' . $newrow, $dataPerArray[0]['nama']);
                $worksheet->setCellValue('B9', $dataPerArray[0]['nama']);
                $worksheet->setCellValue('B10', $dataPerArray[0]['jabatan']);
            }
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('template/berita_acara_penyerahan.xlsx');

        // Kirim respons JSON ke AJAX
        $response = array(
            'success' => true,
            'message' => 'File Excel berhasil dibuat.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}