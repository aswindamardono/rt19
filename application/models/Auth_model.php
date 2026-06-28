<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function get_user_by_username($username) {
        $this->db->select('tb_users.*, tb_role.nama_role');
        $this->db->from('tb_users');
        $this->db->join('tb_role', 'tb_role.id = tb_users.role_id');
        $this->db->where('username', $username);
        $this->db->where('is_active', 1);
        return $this->db->get()->row();
    }

    public function update_last_login($user_id) {
        $this->db->where('id', $user_id);
        $this->db->update('tb_users', ['last_login' => date('Y-m-d H:i:s')]);
    }

    public function log_activity($user_id, $aktivitas, $modul) {
        $data = [
            'user_id' => $user_id,
            'aktivitas' => $aktivitas,
            'modul' => $modul,
            'ip_address' => $this->input->ip_address(),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('tb_log_activity', $data);
    }
}
