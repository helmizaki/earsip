<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LapArsip extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('is_logged_in') == FALSE) {
            redirect('login');
        }
        $this->load->model('Lap_Arsip_model');
    }

    public function konversi_bulan($nomor_bulan)
    {
        $bulan_huruf = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $nomor_bulan--; // Kurangi 1 karena array dimulai dari 0

        $bulan_huruf_str = $bulan_huruf[$nomor_bulan];
        return $bulan_huruf_str;
    }


    public function index()
    {
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('footer');
        $this->load->view('laporan_arsip');
    }


    public function CetakKeWord()
    {
        require APPPATH . 'third_party/PhpExcel/PhpExcel.php';
        $bulan = $this->input->post('bulan');
        $tahun =  $this->input->post('tahun');
        $bulan_huruf = $this->konversi_bulan($bulan);
        $blm_box_arr  = $this->Lap_Arsip_model->get_sisa_blm_box($bulan, $tahun);
        $putus_blm_box  = $this->Lap_Arsip_model->get_masuk_box_sudah_putus($bulan, $tahun);
        $sisa_lalu  = $this->Lap_Arsip_model->get_sisa_bln_lalu($bulan, $tahun);
        $putus_masuk_box  = $this->Lap_Arsip_model->get_putus_masuk_box($bulan, $tahun);
        $blm_bht  = $this->Lap_Arsip_model->get_blm_bht($bulan, $tahun);
        $blm_minutasi  = $this->Lap_Arsip_model->get_minutasi($bulan, $tahun);
        $masih_banding  = $this->Lap_Arsip_model->get_banding($bulan, $tahun);
        $blm_ikrar  = $this->Lap_Arsip_model->get_ikrar($bulan, $tahun);

        // Mengambil data sebagai array biasa dari objek

        // Panggil class PHPExcel nya
        $objPHPExcel = new PHPExcel();
        // Membaca file Excel yang sudah ada
        $objPHPExcel = PHPExcel_IOFactory::load('template/Laporan Arsip.xlsx');
        $worksheet = $objPHPExcel->getActiveSheet();

        // Menggunakan variabel row untuk mengawasi baris saat mengisi data
        $worksheet->setCellValue('B9', $bulan_huruf);
        $worksheet->setCellValue('C9', $sisa_lalu->data);
        $worksheet->setCellValue('D9', $blm_box_arr->data);
        $worksheet->setCellValue('F9', $putus_blm_box->data);
        $worksheet->setCellValue('E9', $putus_masuk_box->data);

        //Keterangan
        $worksheet->setCellValue('G9', 'A= ' . $blm_bht->data);
        $worksheet->setCellValue('H9', 'B= ' . $blm_minutasi->data);
        $worksheet->setCellValue('I9', 'C= ' . $masih_banding->data);
        $worksheet->setCellValue('J9', 'D= ' . $blm_ikrar->data);




        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('template/Laporan Arsip Bulanan.xlsx');
        var_dump($blm_box_arr);
    }
}
