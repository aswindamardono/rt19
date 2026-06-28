<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {

    public function get_datatables($role_id, $warga_id = null) {
        $this->db->select('s.*, w.nama_lengkap, w.nik');
        $this->db->from('tb_pengajuan_surat s');
        $this->db->join('tb_warga w', 'w.id = s.warga_id');
        
        if ($role_id == 5) { // Warga
            $this->db->where('s.warga_id', $warga_id);
        }

        $column_search = array('s.nomor_surat', 'w.nama_lengkap', 's.jenis_surat', 's.status');
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

        $column_order = array(null, 's.nomor_surat', 's.tanggal_pengajuan', 'w.nama_lengkap', 's.jenis_surat', 's.status', null);
        if (isset($_POST['order'])) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('s.id', 'desc');
        }

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            
        return $this->db->get()->result();
    }

    public function count_filtered($role_id, $warga_id = null) {
        $this->db->from('tb_pengajuan_surat s');
        $this->db->join('tb_warga w', 'w.id = s.warga_id');
        if ($role_id == 5) {
            $this->db->where('s.warga_id', $warga_id);
        }
        return $this->db->count_all_results();
    }

    public function count_all($role_id, $warga_id = null) {
        $this->db->from('tb_pengajuan_surat s');
        if ($role_id == 5) {
            $this->db->where('s.warga_id', $warga_id);
        }
        return $this->db->count_all_results();
    }

    public function get_by_id($id) {
        $this->db->select('s.*, w.nama_lengkap, w.nik, w.tempat_lahir, w.tanggal_lahir, w.jenis_kelamin, w.pekerjaan, w.alamat, w.rt, w.rw');
        $this->db->from('tb_pengajuan_surat s');
        $this->db->join('tb_warga w', 'w.id = s.warga_id');
        $this->db->where('s.id', $id);
        return $this->db->get()->row();
    }

    public function insert($data) {
        $this->db->insert('tb_pengajuan_surat', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('tb_pengajuan_surat', $data);
    }
    
    public function generate_nomor_surat($jenis_surat) {
        // Contoh: 470/001/RT19/VI/2026
        $romawi = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $bulan = $romawi[date('n')];
        $tahun = date('Y');
        
        $this->db->select('nomor_surat');
        $this->db->where('MONTH(tanggal_pengajuan)', date('m'));
        $this->db->where('YEAR(tanggal_pengajuan)', date('Y'));
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $last_surat = $this->db->get('tb_pengajuan_surat')->row();
        
        $urut = 1;
        if ($last_surat && $last_surat->nomor_surat) {
            $parts = explode('/', $last_surat->nomor_surat);
            if(isset($parts[1])) {
                $urut = (int)$parts[1] + 1;
            }
        }
        
        $urut_str = str_pad($urut, 3, '0', STR_PAD_LEFT);
        $kode = '470'; // Kode surat keterangan
        
        return "$kode/$urut_str/RT19/$bulan/$tahun";
    }
}
