<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iuran_model extends CI_Model {

    public function get_datatables() {
        $this->db->select('i.*, w.nama_lengkap, w.nik, w.rt');
        $this->db->from('tb_iuran i');
        $this->db->join('tb_warga w', 'w.id = i.warga_id');
        
        $column_search = array('w.nama_lengkap', 'w.nik', 'i.bulan', 'i.tahun', 'i.status');
        $i = 0;
        foreach ($column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        $column_order = array(null, 'w.nama_lengkap', 'i.bulan', 'i.tahun', 'i.nominal', 'i.status', 'i.tanggal_bayar', null);
        if (isset($_POST['order'])) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('i.id', 'desc');
        }

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            
        return $this->db->get()->result();
    }

    public function count_filtered() {
        $this->db->from('tb_iuran i');
        $this->db->join('tb_warga w', 'w.id = i.warga_id');
        return $this->db->count_all_results();
    }

    public function count_all() {
        $this->db->from('tb_iuran');
        return $this->db->count_all_results();
    }

    public function get_by_id($id) {
        $this->db->select('i.*, w.nama_lengkap');
        $this->db->from('tb_iuran i');
        $this->db->join('tb_warga w', 'w.id = i.warga_id');
        $this->db->where('i.id', $id);
        return $this->db->get()->row();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('tb_iuran', $data);
    }

    public function generate_tagihan_bulanan($bulan, $tahun, $nominal) {
        // Ambil semua warga aktif
        $this->db->where('status_aktif', 1);
        $warga = $this->db->get('tb_warga')->result();

        $count = 0;
        foreach($warga as $w) {
            // Cek apakah tagihan sudah ada
            $this->db->where('warga_id', $w->id);
            $this->db->where('bulan', $bulan);
            $this->db->where('tahun', $tahun);
            $exist = $this->db->get('tb_iuran')->row();

            if(!$exist) {
                $this->db->insert('tb_iuran', [
                    'warga_id' => $w->id,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'nominal' => $nominal,
                    'status' => 'Belum Bayar'
                ]);
                $count++;
            }
        }
        return $count;
    }

    public function get_tunggakan() {
        $this->db->select('i.*, w.nama_lengkap, w.rt, w.no_hp');
        $this->db->from('tb_iuran i');
        $this->db->join('tb_warga w', 'w.id = i.warga_id');
        $this->db->where('i.status', 'Belum Bayar');
        // Filter: hanya tunggakan untuk bulan-bulan sebelum bulan ini ATAU bulan ini jika sudah lewat tanggal batas_bayar (misal tgl 10)
        
        $current_year = date('Y');
        $current_month = date('n');
        $current_day = date('j');
        
        // Asumsi batas bayar = 10
        $batas_bayar = 10;
        
        if ($current_day > $batas_bayar) {
            // Semua bulan <= current_month
            $this->db->where("(i.tahun < $current_year OR (i.tahun = $current_year AND i.bulan <= $current_month))", NULL, FALSE);
        } else {
            // Hanya bulan < current_month
            $this->db->where("(i.tahun < $current_year OR (i.tahun = $current_year AND i.bulan < $current_month))", NULL, FALSE);
        }

        return $this->db->get()->result();
    }
}
