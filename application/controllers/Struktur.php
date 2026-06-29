<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Struktur — CRUD struktur organisasi RT-19.
 * Akses: Super Admin (role_id=1) & Sekretaris (role_id=4).
 */
class Struktur extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Struktur_model');
        $this->check_role([1, 4, 6]); // Super Admin, Sekretaris, Pengurus
    }

    public function index() {
        $data['title']    = 'Struktur Organisasi';
        $data['subtitle'] = 'Kelola data pengurus & struktur RT-19';
        $data['list']     = $this->Struktur_model->get_all(false);
        $this->render('struktur/index', $data);
    }

    public function tambah() {
        $this->check_role([1, 4]);
        if ($this->input->method() === 'post') return $this->_save();

        $data['title']    = 'Tambah Pengurus';
        $data['subtitle'] = 'Tambah jabatan / pengurus baru ke struktur';
        $data['row']      = null;
        $data['parents']  = $this->Struktur_model->get_parent_options(null);
        $data['urutan_default'] = $this->Struktur_model->next_urutan();
        $this->render('struktur/form', $data);
    }

    public function edit($id) {
        $this->check_role([1, 4]);
        $row = $this->Struktur_model->get_by_id($id);
        if (!$row) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            redirect('struktur');
        }

        if ($this->input->method() === 'post') return $this->_save($id);

        $data['title']    = 'Edit Pengurus';
        $data['subtitle'] = 'Perbarui data jabatan ' . $row->jabatan;
        $data['row']      = $row;
        $data['parents']  = $this->Struktur_model->get_parent_options($id);
        $this->render('struktur/form', $data);
    }

    public function hapus($id) {
        $this->check_role([1, 4]);
        $row = $this->Struktur_model->get_by_id($id);
        if (!$row) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            redirect('struktur');
        }
        $this->Struktur_model->delete($id);
        $this->session->set_flashdata('success', 'Jabatan "' . $row->jabatan . '" berhasil dihapus.');
        redirect('struktur');
    }

    /** Toggle aktif / nonaktif (tanpa hapus) */
    public function toggle($id) {
        $this->check_role([1, 4]);
        $row = $this->Struktur_model->get_by_id($id);
        if (!$row) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            redirect('struktur');
        }
        $this->Struktur_model->update($id, ['is_active' => $row->is_active ? 0 : 1]);
        $this->session->set_flashdata('success', 'Status "' . $row->jabatan . '" diperbarui.');
        redirect('struktur');
    }

    // -------------------------------------------------- private
    private function _save($id = null) {
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('nama',    'Nama',    'trim|max_length[150]');
        $this->form_validation->set_rules('no_hp',   'No HP',   'trim|max_length[20]');
        $this->form_validation->set_rules('urutan',  'Urutan',  'trim|integer');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors(' ', ' '));
            redirect($id ? 'struktur/edit/' . $id : 'struktur/tambah');
        }

        $data = [
            'jabatan'   => $this->input->post('jabatan',   TRUE),
            'nama'      => $this->input->post('nama',      TRUE) ?: null,
            'no_hp'     => $this->input->post('no_hp',     TRUE) ?: null,
            'deskripsi' => $this->input->post('deskripsi', TRUE) ?: null,
            'urutan'    => (int) ($this->input->post('urutan', TRUE) ?: 0),
            'parent_id' => $this->input->post('parent_id') ? (int)$this->input->post('parent_id') : null,
            'is_active' => $this->input->post('is_active') ? 1 : 0,
        ];

        // Hindari self-parent
        if ($id && (int)$data['parent_id'] === (int)$id) {
            $data['parent_id'] = null;
        }

        // Handle upload foto (opsional)
        if (!empty($_FILES['foto']['name'])) {
            $upload_path = FCPATH . 'uploads/struktur/';
            if (!is_dir($upload_path)) @mkdir($upload_path, 0755, true);

            $config = [
                'upload_path'   => $upload_path,
                'allowed_types' => 'jpg|jpeg|png|webp',
                'max_size'      => 2048,
                'encrypt_name'  => TRUE,
            ];
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto')) {
                $up = $this->upload->data();
                $data['foto'] = $up['file_name'];

                // Hapus foto lama jika edit
                if ($id) {
                    $old = $this->Struktur_model->get_by_id($id);
                    if ($old && !empty($old->foto)) {
                        $oldpath = $upload_path . $old->foto;
                        if (is_file($oldpath)) @unlink($oldpath);
                    }
                }
            } else {
                $this->session->set_flashdata('error', 'Upload foto gagal: ' . $this->upload->display_errors('', ''));
                redirect($id ? 'struktur/edit/' . $id : 'struktur/tambah');
            }
        }

        if ($id) {
            $this->Struktur_model->update($id, $data);
            $this->session->set_flashdata('success', 'Data jabatan berhasil diperbarui.');
        } else {
            $this->Struktur_model->insert($data);
            $this->session->set_flashdata('success', 'Jabatan baru berhasil ditambahkan.');
        }
        redirect('struktur');
    }
}
