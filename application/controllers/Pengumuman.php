<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengumuman extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pengumuman_model');
        $this->load->model('Notifikasi_model');
    }

    public function index() {
        $data['title'] = 'Pengumuman RT';
        
        $data['custom_js'] = "
        <script>
            var table;
            $(document).ready(function() {
                table = $('#table-pengumuman').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'order': [],
                    'ajax': {
                        'url': '".base_url('pengumuman/datatable')."',
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
        </script>
        ";
        
        $this->render('pengumuman/index', $data);
    }

    public function datatable() {
        $list = $this->Pengumuman_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        
        foreach ($list as $row) {
            $no++;
            $r = array();
            $r[] = $no;
            $r[] = date('d-m-Y', strtotime($row->tanggal_publish));
            $r[] = $row->judul;
            $r[] = $row->penulis;
            
            $status = $row->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-secondary">Tidak Aktif</span>';
            $r[] = $status;
            
            $btn = '<a href="'.base_url('pengumuman/detail/'.$row->id).'" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Detail</a> ';
            
            if (in_array($this->role_id, [1, 4])) { // Admin atau Sekretaris
                $btn .= '<a href="'.base_url('pengumuman/edit/'.$row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>';
            }

            $r[] = $btn;
            $data[] = $r;
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Pengumuman_model->count_all(),
            'recordsFiltered' => $this->Pengumuman_model->count_filtered(),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function tambah() {
        $this->check_role([1, 4]); // Admin, Sekretaris
        
        $data['title'] = 'Buat Pengumuman Baru';

        if ($this->input->post()) {
            $insert_data = [
                'judul' => $this->input->post('judul', TRUE),
                'isi' => $this->input->post('isi', TRUE),
                'tanggal_publish' => date('Y-m-d'),
                'is_active' => $this->input->post('is_active', TRUE) ? 1 : 0,
                'created_by' => $this->user_id
            ];

            // Handle image upload
            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path']          = './uploads/pengumuman/';
                $config['allowed_types']        = 'jpg|jpeg|png';
                $config['max_size']             = 10240; // 10MB
                $config['encrypt_name']         = TRUE;

                if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);

                $this->upload->initialize($config);

                if ($this->upload->do_upload('gambar')) {
                    $this->_auto_resize_image($this->upload->data('full_path'));
                    $insert_data['gambar'] = $this->upload->data('file_name');
                }
            }

            $id_pengumuman = $this->Pengumuman_model->insert($insert_data);
            
            // Broadcast notifikasi jika aktif
            if ($insert_data['is_active']) {
                $this->Notifikasi_model->broadcast_pengumuman($id_pengumuman, $insert_data['judul']);
            }

            $this->session->set_flashdata('success', 'Pengumuman berhasil dipublish.');
            redirect('pengumuman');
        }

        $this->render('pengumuman/form', $data);
    }

    public function edit($id) {
        $this->check_role([1, 4]); // Admin, Sekretaris
        
        $data['title'] = 'Edit Pengumuman';
        $data['pengumuman'] = $this->Pengumuman_model->get_by_id($id);
        
        if (!$data['pengumuman']) show_404();

        if ($this->input->post()) {
            $update_data = [
                'judul' => $this->input->post('judul', TRUE),
                'isi' => $this->input->post('isi', TRUE),
                'is_active' => $this->input->post('is_active', TRUE) ? 1 : 0
            ];

            // Handle image upload
            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path']          = './uploads/pengumuman/';
                $config['allowed_types']        = 'jpg|jpeg|png';
                $config['max_size']             = 10240; // 10MB
                $config['encrypt_name']         = TRUE;

                if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);

                $this->upload->initialize($config);

                if ($this->upload->do_upload('gambar')) {
                    $this->_auto_resize_image($this->upload->data('full_path'));
                    if ($data['pengumuman']->gambar && file_exists('./uploads/pengumuman/' . $data['pengumuman']->gambar)) {
                        unlink('./uploads/pengumuman/' . $data['pengumuman']->gambar);
                    }
                    $update_data['gambar'] = $this->upload->data('file_name');
                }
            }

            $this->Pengumuman_model->update($id, $update_data);
            
            $this->session->set_flashdata('success', 'Pengumuman berhasil diupdate.');
            redirect('pengumuman');
        }

        $this->render('pengumuman/form', $data);
    }

    public function detail($id) {
        $data['title'] = 'Detail Pengumuman';
        $data['pengumuman'] = $this->Pengumuman_model->get_by_id($id);
        
        if (!$data['pengumuman']) show_404();
        
        $this->render('pengumuman/detail', $data);
    }
}
