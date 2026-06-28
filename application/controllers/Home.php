<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home — Landing page publik (tanpa login)
 * Multi-page layout: Keuangan, Struktur, Pengumuman, Inventaris
 */
class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->model('Pengumuman_model');
        $this->load->model('Struktur_model');
        $this->load->model('Inventaris_model');
    }

    /**
     * Halaman utama — Ringkasan Keuangan
     */
    public function index() {
        // Jika sudah login, langsung dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $month = (int) date('n');
        $year  = (int) date('Y');

        $data = [
            'page_title'     => 'Ringkasan Keuangan',
            'active_menu'    => 'keuangan',
            'page_content'   => 'keuangan',
            'total_kas'      => $this->Dashboard_model->get_total_kas(),
            'pemasukan_bln'  => $this->Dashboard_model->get_monthly_pemasukan($month, $year),
            'pengeluaran_bln'=> $this->Dashboard_model->get_monthly_pengeluaran($month, $year),
            'bulan_label'    => $this->_bulan_label($month).' '.$year,
        ];

        $this->load->view('landing/layout', $data);
    }

    /**
     * Halaman Struktur Organisasi
     */
    public function struktur() {
        $data = [
            'page_title'   => 'Struktur Organisasi',
            'active_menu'  => 'struktur',
            'page_content' => 'struktur',
            'struktur'     => $this->Struktur_model->get_all(true),
        ];

        $this->load->view('landing/layout', $data);
    }

    /**
     * Halaman Pengumuman
     */
    public function pengumuman() {
        $data = [
            'page_title'   => 'Pengumuman Warga',
            'active_menu'  => 'pengumuman',
            'page_content' => 'pengumuman',
            'pengumuman'   => $this->Pengumuman_model->get_active_pengumuman(20),
        ];

        $this->load->view('landing/layout', $data);
    }

    /**
     * Halaman Inventaris Barang RT
     */
    public function inventaris() {
        $data = [
            'page_title'   => 'Inventaris Barang RT',
            'active_menu'  => 'inventaris',
            'page_content' => 'inventaris',
            'inventaris'   => $this->Inventaris_model->get_all(),
        ];

        $this->load->view('landing/layout', $data);
    }

    private function _bulan_label($m) {
        $bulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                  7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        return $bulan[(int)$m] ?? '';
    }
}
