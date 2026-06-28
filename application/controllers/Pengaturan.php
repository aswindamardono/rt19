<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_role([1]); // Only Super Admin can access settings
        $this->load->model('Pengaturan_model');
    }

    public function index() {
        $data['title'] = 'Pengaturan Sistem';
        $data['pengaturan'] = $this->Pengaturan_model->get_all();
        
        $this->render('pengaturan/index', $data);
    }

    public function update() {
        if ($this->input->post()) {
            $post_data = $this->input->post();
            
            // Remove CSRF token from data to be saved
            unset($post_data[$this->security->get_csrf_token_name()]);
            
            $update = $this->Pengaturan_model->update_batch($post_data);
            
            if ($update) {
                $this->session->set_flashdata('success', 'Pengaturan berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat memperbarui pengaturan.');
            }
            redirect('pengaturan');
        } else {
            redirect('pengaturan');
        }
    }
}
