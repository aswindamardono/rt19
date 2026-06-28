<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login');
        } else {
            $this->_login();
        }
    }

    private function _login() {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $user = $this->Auth_model->get_user_by_username($username);

        if ($user) {
            if (password_verify($password, $user->password)) {
                $data = [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'nama_lengkap' => $user->nama_lengkap,
                    'role_id' => $user->role_id,
                    'nama_role' => $user->nama_role,
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($data);
                
                $this->Auth_model->update_last_login($user->id);
                $this->Auth_model->log_activity($user->id, 'Login ke sistem', 'Auth');

                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Password salah!');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', 'Username tidak ditemukan atau akun tidak aktif!');
            redirect('auth');
        }
    }

    public function logout() {
        $user_id = $this->session->userdata('user_id');
        if($user_id) {
            $this->Auth_model->log_activity($user_id, 'Logout dari sistem', 'Auth');
        }
        
        $this->session->sess_destroy();
        redirect('auth');
    }
}
