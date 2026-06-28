<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $user_id;
    protected $role_id;
    protected $data = [];

    public function __construct() {
        parent::__construct();

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth');
        }

        $this->user_id = $this->session->userdata('user_id');
        $this->role_id = $this->session->userdata('role_id');
        
        $this->data['user_id'] = $this->user_id;
        $this->data['role_id'] = $this->role_id;
    }

    protected function check_role($allowed_roles = []) {
        if (!in_array($this->role_id, $allowed_roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini!');
            redirect('dashboard');
        }
    }

    protected function render($view, $data = []) {
        $data = array_merge($this->data, $data);
        $data['content'] = $view;
        $this->load->view('layout/wrapper', $data);
    }
}
