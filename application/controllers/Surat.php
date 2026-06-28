<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Surat extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Surat_model');
    }

    public function index() {
        $data['title'] = 'Surat Menyurat';
        
        $data['custom_js'] = "
        <script>
            var table;
            $(document).ready(function() {
                table = $('#table-surat').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'order': [],
                    'ajax': {
                        'url': '".base_url('surat/datatable')."',
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
        
        $this->render('surat/index', $data);
    }

    public function datatable() {
        $role_id = $this->role_id;
        
        // Asumsi jika role Warga, hanya bisa melihat suratnya sendiri
        $warga_id = null;
        if ($role_id == 5) {
            // Dapatkan warga_id dari user_id
            $warga = $this->db->get_where('tb_warga', ['user_id' => $this->user_id])->row();
            $warga_id = $warga ? $warga->id : 0;
        }

        $list = $this->Surat_model->get_datatables($role_id, $warga_id);
        $data = array();
        $no = $_POST['start'];
        
        foreach ($list as $row) {
            $no++;
            $r = array();
            $r[] = $no;
            $r[] = $row->nomor_surat ?: '-';
            $r[] = date('d-m-Y', strtotime($row->tanggal_pengajuan));
            $r[] = $row->nama_lengkap;
            $r[] = $row->jenis_surat;
            
            if ($row->status == 'Diajukan') {
                $status = '<span class="badge badge-warning">Diajukan</span>';
            } elseif ($row->status == 'Diproses') {
                $status = '<span class="badge badge-info">Diproses</span>';
            } elseif ($row->status == 'Selesai') {
                $status = '<span class="badge badge-success">Selesai</span>';
            } else {
                $status = '<span class="badge badge-danger">Ditolak</span>';
            }
            $r[] = $status;
            
            $btn = '';
            // Aksi untuk Admin / Sekretaris / Ketua RT
            if (in_array($this->role_id, [1, 2, 4])) {
                $btn .= '<a href="'.base_url('surat/proses/'.$row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Detail/Proses</a> ';
            }
            
            // Aksi Download jika selesai
            if ($row->status == 'Selesai' && $row->file_pdf != null) {
                $btn .= '<a href="'.base_url('uploads/surat/'.$row->file_pdf).'" target="_blank" class="btn btn-sm btn-success"><i class="fas fa-download"></i> Unduh</a>';
            }

            $r[] = $btn;
            $data[] = $r;
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Surat_model->count_all($role_id, $warga_id),
            'recordsFiltered' => $this->Surat_model->count_filtered($role_id, $warga_id),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function ajukan() {
        if ($this->role_id != 5 && $this->role_id != 1) { // Hanya warga dan admin bisa
            $this->session->set_flashdata('error', 'Hanya warga yang dapat mengajukan surat.');
            redirect('surat');
        }

        $data['title'] = 'Ajukan Surat Baru';
        
        $warga = $this->db->get_where('tb_warga', ['user_id' => $this->user_id])->row();

        if ($this->input->post()) {
            if(!$warga && $this->role_id == 5) {
                 $this->session->set_flashdata('error', 'Profil warga Anda tidak ditemukan.');
                 redirect('surat');
            }

            $insert_data = [
                'warga_id' => $warga ? $warga->id : 1, // Default ke 1 untuk testing
                'jenis_surat' => $this->input->post('jenis_surat', TRUE),
                'keperluan' => $this->input->post('keperluan', TRUE),
                'tanggal_pengajuan' => date('Y-m-d'),
                'status' => 'Diajukan'
            ];

            // Handle file upload jika ada dokumen pendukung
            if (!empty($_FILES['dokumen_pendukung']['name'])) {
                $config['upload_path']          = './uploads/dokumen/';
                $config['allowed_types']        = 'pdf|jpg|jpeg|png';
                $config['max_size']             = 2048; // 2MB
                $config['encrypt_name']         = TRUE;

                if (!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);

                $this->upload->initialize($config);

                if ($this->upload->do_upload('dokumen_pendukung')) {
                    $insert_data['dokumen_pendukung'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('surat/ajukan');
                }
            }

            $this->Surat_model->insert($insert_data);
            $this->session->set_flashdata('success', 'Surat berhasil diajukan dan sedang diproses.');
            redirect('surat');
        }

        $this->render('surat/ajukan', $data);
    }

    public function proses($id) {
        $this->check_role([1, 2, 4]); // Admin, Ketua RT, Sekretaris
        
        $data['title'] = 'Proses Surat';
        $data['surat'] = $this->Surat_model->get_by_id($id);

        if (!$data['surat']) show_404();

        if ($this->input->post()) {
            $status = $this->input->post('status', TRUE);
            $catatan = $this->input->post('catatan', TRUE);
            
            $update_data = [
                'status' => $status,
                'catatan' => $catatan
            ];

            if ($status == 'Selesai') {
                $nomor_surat = $this->Surat_model->generate_nomor_surat($data['surat']->jenis_surat);
                $update_data['nomor_surat'] = $nomor_surat;
                $update_data['approved_by'] = $this->user_id;
                
                // Update dulu agar DB tahu nomor suratnya
                $this->Surat_model->update($id, $update_data);
                
                // Generate PDF
                $surat_baru = $this->Surat_model->get_by_id($id);
                $file_pdf = $this->generate_pdf($surat_baru);
                
                // Update file pdf
                $this->Surat_model->update($id, ['file_pdf' => $file_pdf]);
            } else {
                $this->Surat_model->update($id, $update_data);
            }

            $this->session->set_flashdata('success', 'Status surat berhasil diupdate.');
            redirect('surat');
        }

        $this->render('surat/proses', $data);
    }

    private function generate_pdf($surat) {
        // Prepare data for template
        $data['surat'] = $surat;
        
        // Load HTML template
        $html = $this->load->view('surat/pdf_template', $data, TRUE);
        
        // Initialize Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Times-Roman');
        $dompdf = new Dompdf($options);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Save file
        $output = $dompdf->output();
        $filename = 'Surat_' . str_replace('/', '_', $surat->nomor_surat) . '.pdf';
        $filepath = FCPATH . 'uploads/surat/';
        
        if (!is_dir($filepath)) mkdir($filepath, 0777, TRUE);
        
        file_put_contents($filepath . $filename, $output);
        
        return $filename;
    }
}
