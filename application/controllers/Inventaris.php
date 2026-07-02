<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventaris extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_role([1, 4, 6]);
        $this->load->model('Inventaris_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Data Inventaris Barang';
        $data['inventaris'] = $this->Inventaris_model->get_all();
        
        $data['custom_js'] = "
        <script>
            $(document).ready(function() {
                $('#table-inventaris').DataTable({
                    'responsive': true,
                    'autoWidth': false,
                    'columnDefs': [
                        { 'orderable': false, 'targets': [1, -1] }
                    ]
                });
            });
        </script>
        ";

        $this->render('inventaris/index', $data);
    }

    public function tambah() {
        $this->check_role([1, 4]);
        $data['title'] = 'Tambah Inventaris Barang';

        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('kondisi', 'Kondisi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->render('inventaris/form', $data);
        } else {
            $foto = false;
            if (!empty($_FILES['foto']['name'])) {
                $foto = $this->_upload_foto();
                if (!$foto) {
                    // Jika upload gagal, kembalikan ke form
                    $this->render('inventaris/form', $data);
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
        $this->check_role([1, 4]);
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
            $this->render('inventaris/form', $data);
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
                    $this->render('inventaris/form', $data);
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
        $this->check_role([1, 4]);
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
        $config['max_size']      = 10240; // 10MB
        $config['encrypt_name']  = TRUE;

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $this->upload->initialize($config);

        if ($this->upload->do_upload('foto')) {
            $this->_auto_resize_image($this->upload->data('full_path'));
            return $this->upload->data('file_name');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors('',''));
            return false;
        }
    }
}
