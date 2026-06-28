<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_model extends CI_Model {

    public function get_all() {
        $query = $this->db->get('tb_pengaturan');
        $result = [];
        foreach ($query->result() as $row) {
            $result[$row->key_setting] = $row->value_setting;
        }
        return $result;
    }

    public function update_batch($data) {
        $this->db->trans_start();
        foreach ($data as $key => $value) {
            $this->db->where('key_setting', $key);
            $this->db->update('tb_pengaturan', ['value_setting' => $value]);
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
