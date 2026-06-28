<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {

    public function insert($data) {
        $this->db->insert('tb_notifikasi', $data);
    }

    public function count_unread($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('status_baca', 0);
        return $this->db->count_all_results('tb_notifikasi');
    }

    public function get_latest($user_id, $limit = 5) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('tb_notifikasi')->result();
    }
    
    public function broadcast_pengumuman($pengumuman_id, $judul) {
        // Ambil semua user_id warga
        $this->db->select('id');
        $this->db->where('role_id', 5);
        $users = $this->db->get('tb_users')->result();
        
        $batch_data = [];
        foreach($users as $user) {
            $batch_data[] = [
                'user_id' => $user->id,
                'judul' => 'Pengumuman Baru: ' . $judul,
                'pesan' => 'Ada pengumuman baru dari pengurus RT, silakan cek dashboard untuk detailnya.',
                'tipe' => 'pengumuman'
            ];
        }
        if(!empty($batch_data)) {
            $this->db->insert_batch('tb_notifikasi', $batch_data);
        }
        
        // Disini bisa ditambahkan fungsi send_email / send_whatsapp API Placeholder
        // $this->send_whatsapp_broadcast($users, $judul);
    }
    
    // Placeholder untuk WhatsApp API
    private function send_whatsapp_broadcast($users, $pesan) {
        // Logika untuk mengirim ke API (misal Fonnte, Wablas, dll)
        // $token = $this->db->get_where('tb_pengaturan', ['key_setting' => 'wa_gateway_token'])->row()->value_setting;
        // curl code here...
        return true;
    }
}
