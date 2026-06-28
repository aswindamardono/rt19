<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function get_total_warga() {
        $this->db->where('status_aktif', 1);
        return $this->db->count_all_results('tb_warga');
    }

    public function get_total_kk() {
        $this->db->select('no_kk');
        $this->db->where('status_aktif', 1);
        $this->db->group_by('no_kk');
        $query = $this->db->get('tb_warga');
        return $query->num_rows();
    }

    public function get_total_kas() {
        $this->db->select_sum('nominal');
        $pemasukan = $this->db->get('tb_pemasukan')->row()->nominal ?? 0;

        $this->db->select_sum('nominal');
        $pengeluaran = $this->db->get('tb_pengeluaran')->row()->nominal ?? 0;

        return $pemasukan - $pengeluaran;
    }

    public function get_total_tunggakan() {
        $this->db->select_sum('nominal');
        $this->db->where('status', 'Belum Bayar');
        return $this->db->get('tb_iuran')->row()->nominal ?? 0;
    }

    public function get_warga_menunggak() {
        $this->db->select('w.*, SUM(i.nominal) as total_tunggakan, COUNT(i.id) as bulan_menunggak');
        $this->db->from('tb_iuran i');
        $this->db->join('tb_warga w', 'w.id = i.warga_id');
        $this->db->where('i.status', 'Belum Bayar');
        // Only count arrears if past the 10th of the current month, or previous months.
        // Assuming a simpler logic here: all 'Belum Bayar' are arrears if it's past due date.
        // The generator script will create these rows.
        $this->db->group_by('w.id');
        return $this->db->get()->result();
    }

    public function get_monthly_pemasukan($month, $year) {
        $this->db->select_sum('nominal');
        $this->db->where('MONTH(tanggal)', $month);
        $this->db->where('YEAR(tanggal)', $year);
        return $this->db->get('tb_pemasukan')->row()->nominal ?? 0;
    }

    public function get_monthly_pengeluaran($month, $year) {
        $this->db->select_sum('nominal');
        $this->db->where('MONTH(tanggal)', $month);
        $this->db->where('YEAR(tanggal)', $year);
        return $this->db->get('tb_pengeluaran')->row()->nominal ?? 0;
    }
}
