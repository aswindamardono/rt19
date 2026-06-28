<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan_model extends CI_Model {

    // Pemasukan
    public function get_pemasukan_datatables() {
        $this->db->from('tb_pemasukan');
        
        $column_search = array('kategori', 'keterangan');
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

        $column_order = array(null, 'tanggal', 'kategori', 'keterangan', 'nominal', null);
        if (isset($_POST['order'])) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'desc');
        }

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            
        return $this->db->get()->result();
    }

    public function count_filtered_pemasukan() {
        $this->db->from('tb_pemasukan');
        return $this->db->count_all_results();
    }

    public function count_all_pemasukan() {
        $this->db->from('tb_pemasukan');
        return $this->db->count_all_results();
    }

    public function insert_pemasukan($data) {
        $this->db->insert('tb_pemasukan', $data);
        return $this->db->insert_id();
    }

    public function delete_pemasukan($id) {
        $this->db->where('id', $id);
        $this->db->delete('tb_pemasukan');
    }

    // Pengeluaran
    public function get_pengeluaran_datatables() {
        $this->db->from('tb_pengeluaran');
        
        $column_search = array('kategori', 'keterangan');
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

        $column_order = array(null, 'tanggal', 'kategori', 'keterangan', 'nominal', null);
        if (isset($_POST['order'])) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id', 'desc');
        }

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            
        return $this->db->get()->result();
    }

    public function count_filtered_pengeluaran() {
        $this->db->from('tb_pengeluaran');
        return $this->db->count_all_results();
    }

    public function count_all_pengeluaran() {
        $this->db->from('tb_pengeluaran');
        return $this->db->count_all_results();
    }

    public function insert_pengeluaran($data) {
        $this->db->insert('tb_pengeluaran', $data);
        return $this->db->insert_id();
    }

    public function delete_pengeluaran($id) {
        $this->db->where('id', $id);
        $this->db->delete('tb_pengeluaran');
    }

    // Laporan Keuangan
    public function get_laporan($start_date, $end_date) {
        $this->db->select("tanggal, kategori, keterangan, nominal, 'pemasukan' as jenis");
        $this->db->from('tb_pemasukan');
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $query1 = $this->db->get_compiled_select();

        $this->db->select("tanggal, kategori, keterangan, nominal, 'pengeluaran' as jenis");
        $this->db->from('tb_pengeluaran');
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query($query1 . " UNION " . $query2 . " ORDER BY tanggal ASC");
        return $query->result();
    }
}
