<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman_model extends CI_Model {

    public function get_datatables() {
        $this->db->select('p.*, u.nama_lengkap as penulis');
        $this->db->from('tb_pengumuman p');
        $this->db->join('tb_users u', 'u.id = p.created_by');

        $column_search = array('p.judul', 'p.isi');
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

        $column_order = array(null, 'p.tanggal_publish', 'p.judul', 'u.nama_lengkap', 'p.is_active', null);
        if (isset($_POST['order'])) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('p.id', 'desc');
        }

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            
        return $this->db->get()->result();
    }

    public function count_filtered() {
        $this->db->from('tb_pengumuman');
        return $this->db->count_all_results();
    }

    public function count_all() {
        $this->db->from('tb_pengumuman');
        return $this->db->count_all_results();
    }

    public function get_active_pengumuman($limit = 5) {
        $this->db->where('is_active', 1);
        $this->db->order_by('tanggal_publish', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('tb_pengumuman')->result();
    }

    public function insert($data) {
        $this->db->insert('tb_pengumuman', $data);
        return $this->db->insert_id();
    }
    
    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('tb_pengumuman', $data);
    }
    
    public function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get('tb_pengumuman')->row();
    }
}
