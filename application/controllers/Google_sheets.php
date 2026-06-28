<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Google_sheets extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_role([1, 3]); // Super Admin, Bendahara
        $this->load->library('GoogleSheetsService');
    }

    public function sync() {
        if (!$this->googlesheetsservice->is_configured()) {
            $this->session->set_flashdata('error', 'Google Sheets belum dikonfigurasi. Harap atur Credential JSON dan Spreadsheet ID di menu Pengaturan.');
            redirect('keuangan/laporan');
        }

        // Sync Pemasukan
        $pemasukan = $this->db->get('tb_pemasukan')->result();
        $this->googlesheetsservice->syncPemasukan($pemasukan);

        // Sync Pengeluaran
        $pengeluaran = $this->db->get('tb_pengeluaran')->result();
        $this->googlesheetsservice->syncPengeluaran($pengeluaran);

        // Sync Kas Ringkasan
        $this->db->select_sum('nominal');
        $total_pemasukan = $this->db->get('tb_pemasukan')->row()->nominal ?? 0;
        
        $this->db->select_sum('nominal');
        $total_pengeluaran = $this->db->get('tb_pengeluaran')->row()->nominal ?? 0;
        
        $saldo_akhir = $total_pemasukan - $total_pengeluaran;

        $this->googlesheetsservice->syncKas($total_pemasukan, $total_pengeluaran, $saldo_akhir);

        $this->session->set_flashdata('success', 'Sinkronisasi dengan Google Sheets berhasil dilakukan.');
        redirect('keuangan/laporan');
    }
}
