<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warga extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_role([1, 4, 6]); // Super Admin, Sekretaris, Pengurus
        $this->load->model('Warga_model');
    }

    public function index() {
        $data['title'] = 'Data Warga';
        
        $data['custom_js'] = "
        <script>
            var table;
            $(document).ready(function() {
                table = $('#table-warga').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'order': [],
                    'ajax': {
                        'url': '".base_url('warga/datatable')."',
                        'type': 'POST',
                        'data': function(d) {
                            d.".$this->security->get_csrf_token_name()." = '".$this->security->get_csrf_hash()."';
                        }
                    },
                    'columnDefs': [
                        { 'targets': [ 0, -1 ], 'orderable': false }
                    ]
                });
            });

            function hapus_warga(id) {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".base_url('warga/hapus/')."' + id;
                    }
                })
            }
        </script>
        ";
        
        $this->render('warga/index', $data);
    }

    public function datatable() {
        $list = $this->Warga_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $warga) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $warga->nik;
            $row[] = $warga->no_kk;
            $row[] = $warga->nama_lengkap;
            $row[] = $warga->jenis_kelamin;
            $row[] = $warga->rt;
            // Status Warga
            if ($warga->alamat == 'Warga Tetap') {
                $row[] = '<span class="badge badge-primary">Warga Tetap</span>';
            } else if ($warga->alamat == 'Warga Kontrak') {
                $row[] = '<span class="badge badge-warning">Warga Kontrak</span>';
            } else {
                $row[] = '-';
            }

            // Status KTP
            if ($warga->tempat_lahir == 'Warga BerKTP Orchid') {
                $row[] = '<span class="badge badge-success">KTP Orchid</span>';
            } else if ($warga->tempat_lahir == 'Warga Non KTP Orchid') {
                $row[] = '<span class="badge badge-secondary">Diluar Orchid</span>';
            } else {
                $row[] = '-';
            }
            
            $btn = '';
            if (in_array($this->role_id, [1, 4])) {
                $btn = '<a href="'.base_url('warga/edit/'.$warga->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a> ';
                $btn .= '<button type="button" onclick="hapus_warga('.$warga->id.')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>';
            }
            $row[] = $btn;

            $data[] = $row;
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Warga_model->count_all(),
            'recordsFiltered' => $this->Warga_model->count_filtered(),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function tambah() {
        $data['title'] = 'Tambah Warga';

        $this->check_role([1, 4]); // Only Super Admin and Sekretaris can add

        if ($this->input->post()) {
            $insert_data = [
                'nik' => $this->input->post('nik', TRUE),
                'no_kk' => $this->input->post('no_kk', TRUE),
                'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
                'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
                'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'rt' => $this->input->post('rt', TRUE),
                'rw' => $this->input->post('rw', TRUE),
                'no_hp' => $this->input->post('no_hp', TRUE),
                'status_perkawinan' => $this->input->post('status_perkawinan', TRUE),
                'pekerjaan' => $this->input->post('pekerjaan', TRUE),
                'status_aktif' => 1
            ];

            $this->Warga_model->insert($insert_data);
            $this->session->set_flashdata('success', 'Data warga berhasil ditambahkan.');
            redirect('warga');
        }

        $this->render('warga/form', $data);
    }

    public function edit($id) {
        $data['title'] = 'Edit Warga';
        $data['warga'] = $this->Warga_model->get_by_id($id);

        if (!$data['warga']) {
            show_404();
        }

        $this->check_role([1, 4]); // Only Super Admin and Sekretaris can edit

        if ($this->input->post()) {
            $update_data = [
                'nik' => $this->input->post('nik', TRUE),
                'no_kk' => $this->input->post('no_kk', TRUE),
                'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                'jenis_kelamin' => $this->input->post('jenis_kelamin', TRUE),
                'tempat_lahir' => $this->input->post('tempat_lahir', TRUE),
                'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'rt' => $this->input->post('rt', TRUE),
                'rw' => $this->input->post('rw', TRUE),
                'no_hp' => $this->input->post('no_hp', TRUE),
                'status_perkawinan' => $this->input->post('status_perkawinan', TRUE),
                'pekerjaan' => $this->input->post('pekerjaan', TRUE),
                'status_aktif' => $this->input->post('status_aktif', TRUE)
            ];

            $this->Warga_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Data warga berhasil diupdate.');
            redirect('warga');
        }

        $this->render('warga/form', $data);
    }

    public function hapus($id) {
        $this->check_role([1, 4]); // Only Super Admin and Sekretaris can delete
        $this->Warga_model->delete($id);
        $this->session->set_flashdata('success', 'Data warga berhasil dihapus.');
        redirect('warga');
    }
}
