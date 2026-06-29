<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventaris extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
        cek_akses([1, 4, 6]);
        $this->load->model('Inventaris_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Data Inventaris Barang';
        $data['inventaris'] = $this->Inventaris_model->get_all();
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('inventaris/index', $data);
        $this->load->view('layout/footer');
    }

    public function tambah() {
        cek_akses([1, 4]);
        $data['title'] = 'Tambah Inventaris Barang';

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('kondisi', 'Kondisi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar', $data);
            $this->load->view('inventaris/form', $data);
            $this->load->view('layout/footer');
        } else {
            $foto = false;
            if (!empty($_FILES['foto']['name'])) {
                $foto = $this->_upload_foto();
                if (!$foto) {
                    // Jika upload gagal, kembalikan ke form
                    $this->load->view('layout/header', $data);
                    $this->load->view('layout/sidebar', $data);
                    $this->load->view('inventaris/form', $data);
                    $this->load->view('layout/footer');
                    return;
                }
            }
            
            $insert_data = [
                'nama_barang' => $this->input->post('nama_barang', true),
                'jumlah' => $this->input->post('jumlah', true),
                'kondisi' => $this->input->post('kondisi', true),
                'keterangan' => $this->input->post('keterangan', true)
            ];

            if ($foto) {
                $insert_data['foto'] = $foto;
            }

            $this->Inventaris_model->insert($insert_data);
            $this->session->set_flashdata('success', 'Data inventaris berhasil ditambahkan.');
            redirect('inventaris');
        }
    }

    public function edit($id) {
        cek_akses([1, 4]);
        $data['title'] = 'Edit Inventaris Barang';
        $data['inventaris'] = $this->Inventaris_model->get_by_id($id);
        
        if (!$data['inventaris']) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            redirect('inventaris');
        }

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('kondisi', 'Kondisi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layout/header', $data);
            $this->load->view('layout/sidebar', $data);
            $this->load->view('inventaris/form', $data);
            $this->load->view('layout/footer');
        } else {
            $update_data = [
                'nama_barang' => $this->input->post('nama_barang', true),
                'jumlah' => $this->input->post('jumlah', true),
                'kondisi' => $this->input->post('kondisi', true),
                'keterangan' => $this->input->post('keterangan', true)
            ];

            if (!empty($_FILES['foto']['name'])) {
                $foto = $this->_upload_foto();
                if (!$foto) {
                    $this->load->view('layout/header', $data);
                    $this->load->view('layout/sidebar', $data);
                    $this->load->view('inventaris/form', $data);
                    $this->load->view('layout/footer');
                    return;
                }
                // Hapus foto lama jika ada
                if ($data['inventaris']->foto && file_exists(FCPATH . 'assets/img/inventaris/' . $data['inventaris']->foto)) {
                    unlink(FCPATH . 'assets/img/inventaris/' . $data['inventaris']->foto);
                }
                $update_data['foto'] = $foto;
            }

            $this->Inventaris_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Data inventaris berhasil diubah.');
            redirect('inventaris');
        }
    }

    public function hapus($id) {
        cek_akses([1, 4]);
        $inventaris = $this->Inventaris_model->get_by_id($id);
        if ($inventaris) {
            // Hapus foto jika ada
            if ($inventaris->foto && file_exists(FCPATH . 'assets/img/inventaris/' . $inventaris->foto)) {
                unlink(FCPATH . 'assets/img/inventaris/' . $inventaris->foto);
            }
            $this->Inventaris_model->delete($id);
            $this->session->set_flashdata('success', 'Data inventaris berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
        }
        redirect('inventaris');
    }

    private function _upload_foto() {
        $config['upload_path']   = './assets/img/inventaris/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = 2048; // 2MB
        $config['encrypt_name']  = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->upload->initialize($config);

        if ($this->upload->do_upload('foto')) {
            return $this->upload->data('file_name');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors('',''));
            return false;
        }
    }
}
