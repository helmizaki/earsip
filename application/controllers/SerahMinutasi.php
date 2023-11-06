<?php
defined('BASEPATH') or exit('No direct script access allowed');



class SerahMinutasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Serah_Berkas_PPPANMUD_model');
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
        $data['list_pp'] = $this->Serah_Berkas_PPPANMUD_model->data_pp();
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('footer');
        $this->load->view('cetak_penyerahan_minutasi', $data);
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


    public function list_minutasi()
    {

        $value = $this->input->post('value'); // Mendapatkan nilai dari tombol


        $data = $this->Serah_Berkas_PPPANMUD_model->get_list_minutasi($value); // Memanggil model untuk mengambil data dari database

        echo json_encode($data); // Mengembalikan data dalam format JSON
    }

    public function get_BAP()
    {

        $value = $this->input->post('value'); // Mendapatkan nilai dari tombol


        $data = $this->Serah_Berkas_PPPANMUD_model->get_list_BAP($value); // Memanggil model untuk mengambil data dari database

        echo json_encode($data); // Mengembalikan data dalam format JSON
    }



    public function get_data()
    {
        $data = $this->Serah_Berkas_PPPANMUD_model->get_data();
        $response_data = [];

        foreach ($data as $row) {

            $response_data[] = $row;
        }

        // Send the JSON response with data and matched information
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['data' => $response_data]));
    }

    public function CetakKeWord()
    {
        require APPPATH . 'third_party/PhpExcel/PhpExcel.php';

        $dataGut = $this->Serah_Berkas_PPPANMUD_model->get_panmudGut();
        $dataHuk = $this->Serah_Berkas_PPPANMUD_model->get_panmudHuk();
        $dataPer = $this->Serah_Berkas_PPPANMUD_model->get_panmudPer();
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
        // Panggil class PHPExcel nya
        $objPHPExcel = new PHPExcel();
        // Membaca file Excel yang sudah ada
        $objPHPExcel = PHPExcel_IOFactory::load('template/serah/serah_berkas.xlsx');
        $worksheet = $objPHPExcel->getActiveSheet();
        $selected_items = $this->input->post('selected_items');
        $pilihDari = $this->input->post('pilih_dari');
        $pilihMenuju = $this->input->post('pilih_menuju');
        $tanggal_serah = $this->input->post('tanggal_serah');
        $tanggal_indonesia = $this->tanggal_indonesia($tanggal_serah);
        $awalan = 'Pada hari ini ' . $tanggal_indonesia . ' bertempat di Ruang kepaniteraan Pengadilan Agama Ngawi, kami yang bertanda tangan di bawah ini :';


        $worksheet->setCellValue('A4', $awalan);

        $worksheet->setCellValue('B6', $pilihDari);
        //$worksheet->setCellValue('B' . $row, $item['nomor_perkara']);

        // Menggunakan variabel row untuk mengawasi baris saat mengisi data
        $row = 17;
        $no = 1;

        $worksheet->getStyle('D')->getNumberFormat()->setFormatCode('dd/mm/yyyy');

        foreach ($selected_items as $item) {
            $worksheet->setCellValue('A' . $row, $no);
            $worksheet->setCellValue('B' . $row, $item['nomor_perkara']);
            $worksheet->setCellValue('C' . $row, $item['jenis_perkara']);
            $worksheet->setCellValue('D' . $row, $item['status_putusan']);
            // Mengatur garis tepi untuk sel-sel B, C, dan D di baris saat ini
            $cellRange = 'A' . $row . ':E' . $row;
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
        $worksheet->setCellValue('B' . $roww, 'Panitera Pengganti');
        $worksheet->setCellValue('B' . $newrow, $pilihDari);
        if ($pilihMenuju === 'Panmud Hukum') {
            if (!empty($dataHukArray)) {
                $worksheet->getStyle('D' . $newrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $worksheet->setCellValue('D' . $roww, $dataHukArray[0]['jabatan']);
                $worksheet->setCellValue('D' . $newrow, $dataHukArray[0]['nama']);
                $worksheet->setCellValue('B9', $dataHukArray[0]['nama']);
                $worksheet->setCellValue('B10', $dataHukArray[0]['jabatan']);
            }
        } elseif ($pilihMenuju === 'Panmud Gugatan') {
            if (!empty($dataGutArray)) {
                $worksheet->getStyle('D' . $newrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $worksheet->setCellValue('D' . $roww, $dataGutArray[0]['jabatan']);
                $worksheet->setCellValue('D' . $newrow, $dataGutArray[0]['nama']);
                $worksheet->setCellValue('B9', $dataGutArray[0]['nama']);
                $worksheet->setCellValue('B10', $dataGutArray[0]['jabatan']);
            }
        } elseif ($pilihMenuju === 'Panmud Permohonan') {
            if (!empty($dataPerArray)) {
                $worksheet->getStyle('D' . $newrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $worksheet->setCellValue('D' . $roww, $dataPerArray[0]['jabatan']);
                $worksheet->setCellValue('D' . $newrow, $dataPerArray[0]['nama']);
                $worksheet->setCellValue('B9', $dataPerArray[0]['nama']);
                $worksheet->setCellValue('B10', $dataPerArray[0]['jabatan']);
            }
        }





        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('template/serah/SerahMinutasi.xlsx');

        // Kirim respons JSON ke AJAX
        $response = array(
            'success' => true,
            'message' => 'File Excel berhasil dibuat.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
