<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    var $table = 'tb_users';
    var $column_order = array(null, 'username', 'nama_lengkap', 'email', 'tb_role.nama_role', 'is_active', null);
    var $column_search = array('username', 'nama_lengkap', 'email', 'tb_role.nama_role');
    var $order = array('tb_users.id' => 'desc');

    private function _get_datatables_query() {
        $this->db->from($this->table);
        $this->db->join('tb_role', 'tb_role.id = tb_users.role_id', 'left');

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->select('tb_users.*, tb_role.nama_role');
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_by_id($id) {
        $this->db->select('tb_users.*, tb_role.nama_role');
        $this->db->join('tb_role', 'tb_role.id = tb_users.role_id', 'left');
        $this->db->where('tb_users.id', $id);
        return $this->db->get($this->table)->row();
    }

    public function get_by_username($username) {
        $this->db->where('username', $username);
        return $this->db->get($this->table)->row();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }

    public function get_all_roles() {
        return $this->db->get('tb_role')->result();
    }
}
