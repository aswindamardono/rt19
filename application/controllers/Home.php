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

        $prev_time = strtotime('first day of last month');
        $month     = (int) date('n', $prev_time);
        $year      = (int) date('Y', $prev_time);

        $data = [
            'page_title'     => 'Ringkasan Keuangan',
            'active_menu'    => 'keuangan',
            'page_content'   => 'keuangan',
            'total_kas'      => $this->Dashboard_model->get_total_kas(),
            'pemasukan_bln'  => $this->Dashboard_model->get_monthly_pemasukan($month, $year),
            'pengeluaran_bln'=> $this->Dashboard_model->get_monthly_pengeluaran($month, $year),
            'bulan_label'    => $this->_bulan_label($month).' '.$year,
            'last_month'     => $month,
            'last_year'      => $year,
        ];

        $this->load->view('landing/layout', $data);
    }

    /**
     * AJAX Endpoint untuk memuat detail transaksi per bulan & tahun (Pemasukan / Pengeluaran / Semua)
     */
    public function get_transaksi_ajax() {
        $month = (int) ($this->input->get('month') ?: date('n'));
        $year  = (int) ($this->input->get('year') ?: date('Y'));
        $type  = strtolower($this->input->get('type') ?: 'pemasukan');

        if ($month < 1 || $month > 12) {
            $month = (int) date('n');
        }
        if ($year < 2000 || $year > 2100) {
            $year = (int) date('Y');
        }

        $items = [];
        $total_pemasukan = 0;
        $total_pengeluaran = 0;

        if ($type === 'pemasukan' || $type === 'semua') {
            $this->db->select('id, tanggal, kategori, keterangan, nominal, bukti, "pemasukan" as jenis');
            $this->db->from('tb_pemasukan');
            $this->db->where('MONTH(tanggal)', $month);
            $this->db->where('YEAR(tanggal)', $year);
            $this->db->order_by('tanggal', 'DESC');
            $this->db->order_by('id', 'DESC');
            $pemasukan_data = $this->db->get()->result_array();
            foreach ($pemasukan_data as $row) {
                $total_pemasukan += (float) $row['nominal'];
                $items[] = $row;
            }
        }

        if ($type === 'pengeluaran' || $type === 'semua') {
            $this->db->select('id, tanggal, kategori, keterangan, nominal, bukti, "pengeluaran" as jenis');
            $this->db->from('tb_pengeluaran');
            $this->db->where('MONTH(tanggal)', $month);
            $this->db->where('YEAR(tanggal)', $year);
            $this->db->order_by('tanggal', 'DESC');
            $this->db->order_by('id', 'DESC');
            $pengeluaran_data = $this->db->get()->result_array();
            foreach ($pengeluaran_data as $row) {
                $total_pengeluaran += (float) $row['nominal'];
                $items[] = $row;
            }
        }

        if ($type === 'semua') {
            usort($items, function($a, $b) {
                return strcmp($b['tanggal'], $a['tanggal']);
            });
        }

        $bulan_label = $this->_bulan_label($month);

        $response = [
            'status'            => 'success',
            'month'             => $month,
            'year'              => $year,
            'bulan_label'       => $bulan_label,
            'periode_text'      => $bulan_label . ' ' . $year,
            'type'              => $type,
            'total_pemasukan'   => $total_pemasukan,
            'total_pengeluaran' => $total_pengeluaran,
            'count'             => count($items),
            'data'              => $items
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
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
