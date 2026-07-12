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
                $btn .= '<a href="'.base_url('pengumuman/edit/'.$row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a> ';
                $btn .= '<a href="'.base_url('pengumuman/hapus/'.$row->id).'" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')"><i class="fas fa-trash"></i> Hapus</a>';
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
            if (!empty($_FILES['gambar']['name'][0])) {
                $config['upload_path']          = './uploads/pengumuman/';
                $config['allowed_types']        = 'jpg|jpeg|png';
                $config['max_size']             = 10240; // 10MB
                $config['encrypt_name']         = TRUE;

                if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);

                $this->upload->initialize($config);
                
                $uploaded_files = array();
                $filesCount = count($_FILES['gambar']['name']);
                
                for($i = 0; $i < $filesCount; $i++){
                    $_FILES['file']['name']     = $_FILES['gambar']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['gambar']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['gambar']['tmp_name'][$i];
                    $_FILES['file']['error']     = $_FILES['gambar']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['gambar']['size'][$i];
                    
                    if($this->upload->do_upload('file')){
                        $this->_auto_resize_image($this->upload->data('full_path'));
                        $uploaded_files[] = $this->upload->data('file_name');
                    }
                }
                
                if(!empty($uploaded_files)){
                    $insert_data['gambar'] = json_encode($uploaded_files);
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
            if (!empty($_FILES['gambar']['name'][0])) {
                $config['upload_path']          = './uploads/pengumuman/';
                $config['allowed_types']        = 'jpg|jpeg|png';
                $config['max_size']             = 10240; // 10MB
                $config['encrypt_name']         = TRUE;

                if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);

                $this->upload->initialize($config);
                
                $uploaded_files = array();
                $filesCount = count($_FILES['gambar']['name']);
                
                for($i = 0; $i < $filesCount; $i++){
                    $_FILES['file']['name']     = $_FILES['gambar']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['gambar']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['gambar']['tmp_name'][$i];
                    $_FILES['file']['error']     = $_FILES['gambar']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['gambar']['size'][$i];
                    
                    if($this->upload->do_upload('file')){
                        $this->_auto_resize_image($this->upload->data('full_path'));
                        $uploaded_files[] = $this->upload->data('file_name');
                    }
                }

                if(!empty($uploaded_files)){
                    // Hapus gambar lama
                    if ($data['pengumuman']->gambar) {
                        $old_files = json_decode($data['pengumuman']->gambar, true);
                        if(is_array($old_files)) {
                            foreach($old_files as $of) {
                                if (file_exists('./uploads/pengumuman/' . $of)) {
                                    unlink('./uploads/pengumuman/' . $of);
                                }
                            }
                        } else {
                            if (file_exists('./uploads/pengumuman/' . $data['pengumuman']->gambar)) {
                                unlink('./uploads/pengumuman/' . $data['pengumuman']->gambar);
                            }
                        }
                    }
                    $update_data['gambar'] = json_encode($uploaded_files);
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

    public function hapus($id) {
        $this->check_role([1, 4]); // Admin, Sekretaris
        
        $pengumuman = $this->Pengumuman_model->get_by_id($id);
        if (!$pengumuman) show_404();
        
        // Hapus gambar jika ada
        if ($pengumuman->gambar) {
            $old_files = json_decode($pengumuman->gambar, true);
            if(is_array($old_files)) {
                foreach($old_files as $of) {
                    if (file_exists('./uploads/pengumuman/' . $of)) {
                        unlink('./uploads/pengumuman/' . $of);
                    }
                }
            } else {
                if (file_exists('./uploads/pengumuman/' . $pengumuman->gambar)) {
                    unlink('./uploads/pengumuman/' . $pengumuman->gambar);
                }
            }
        }
        
        $this->Pengumuman_model->delete($id);
        
        $this->session->set_flashdata('success', 'Pengumuman berhasil dihapus.');
        redirect('pengumuman');
    }
}
