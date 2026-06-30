<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iuran extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_role([1, 3, 6]); // Super Admin, Bendahara, Pengurus
        $this->load->model('Iuran_model');
        $this->load->model('Keuangan_model');
    }

    public function index() {
        $data['title'] = 'Data Iuran Bulanan';
        
        $data['custom_js'] = "
        <script>
            var table;
            $(document).ready(function() {
                $('#modalGenerate').appendTo('body');
                $('#modalBayar').appendTo('body');
                table = $('#table-iuran').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'order': [],
                    'ajax': {
                        'url': '".base_url('iuran/datatable')."',
                        'type': 'POST',
                        'data': function(d) {
                            d.".$this->security->get_csrf_token_name()." = '".$this->security->get_csrf_hash()."';
                        }
                    },
                    'columnDefs': [
                        { 'targets': [ 0, -1 ], 'orderable': false }
                    ]
                });

                $('#modalBayar').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var nama = button.data('nama');
                    var nominal = button.data('nominal');
                    
                    var modal = $(this);
                    modal.find('#id_iuran').val(id);
                    modal.find('#nama_warga').val(nama);
                    modal.find('#nominal_iuran').val(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(nominal));
                });
            });
        </script>
        ";
        
        $this->render('iuran/index', $data);
    }

    public function datatable() {
        $list = $this->Iuran_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        
        $months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        foreach ($list as $row) {
            $no++;
            $r = array();
            $r[] = $no;
            $r[] = $row->nama_lengkap;
            $r[] = $months[$row->bulan] . ' ' . $row->tahun;
            $r[] = 'Rp ' . number_format($row->nominal, 0, ',', '.');
            
            if ($row->status == 'Lunas') {
                $r[] = '<span class="badge badge-success">Lunas</span>';
                $r[] = date('d-m-Y', strtotime($row->tanggal_bayar));
                
                $btn = '';
                if (in_array($this->role_id, [1, 3])) {
                    $btn .= '<a href="'.base_url('iuran/delete/'.$row->id).'" class="btn btn-sm btn-danger ml-1" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data iuran ini?\')"><i class="fas fa-trash"></i></a>';
                }
                $r[] = $btn;
            } else {
                $r[] = '<span class="badge badge-danger">Belum Bayar</span>';
                $r[] = '-';
                $btn = '';
                if (in_array($this->role_id, [1, 3])) {
                    $btn .= '<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalBayar" data-id="'.$row->id.'" data-nama="'.$row->nama_lengkap.'" data-nominal="'.$row->nominal.'"><i class="fas fa-money-bill"></i> Bayar</button>';
                    $btn .= '<a href="'.base_url('iuran/delete/'.$row->id).'" class="btn btn-sm btn-danger ml-1" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data iuran ini?\')"><i class="fas fa-trash"></i></a>';
                }
                $r[] = $btn;
            }

            $data[] = $r;
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Iuran_model->count_all(),
            'recordsFiltered' => $this->Iuran_model->count_filtered(),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function generate() {
        $this->check_role([1, 3]);
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        
        // Asumsi nominal default di ambil dari pengaturan, tapi hardcode 50000 dulu
        $nominal = 50000; 

        $generated = $this->Iuran_model->generate_tagihan_bulanan($bulan, $tahun, $nominal);
        
        $this->session->set_flashdata('success', "$generated tagihan berhasil di-generate untuk bulan $bulan tahun $tahun.");
        redirect('iuran');
    }

    public function bayar() {
        $this->check_role([1, 3]);
        $id = $this->input->post('id');
        $metode_bayar = $this->input->post('metode_bayar');
        $tanggal_bayar = $this->input->post('tanggal_bayar') ?: date('Y-m-d');
        
        $iuran = $this->Iuran_model->get_by_id($id);
        if ($iuran && $iuran->status == 'Belum Bayar') {
            // Update Iuran
            $data = [
                'status' => 'Lunas',
                'metode_bayar' => $metode_bayar,
                'tanggal_bayar' => $tanggal_bayar,
                'created_by' => $this->user_id
            ];
            $this->Iuran_model->update($id, $data);

            // Insert into Pemasukan
            $pemasukan = [
                'tanggal' => $tanggal_bayar,
                'kategori' => 'Iuran Bulanan',
                'keterangan' => 'Iuran Bpk/Ibu ' . $iuran->nama_lengkap . ' Bln ' . $iuran->bulan . '/' . $iuran->tahun,
                'nominal' => $iuran->nominal,
                'created_by' => $this->user_id
            ];
            $this->Keuangan_model->insert_pemasukan($pemasukan);

            $this->session->set_flashdata('success', 'Pembayaran berhasil diproses dan dicatat ke Pemasukan Kas.');
        } else {
            $this->session->set_flashdata('error', 'Pembayaran gagal diproses.');
        }
        redirect('iuran');
    }

    public function delete($id) {
        $this->check_role([1, 3]);
        
        $this->Iuran_model->delete($id);
        
        $this->session->set_flashdata('success', 'Data iuran berhasil dihapus.');
        redirect('iuran');
    }

    public function tunggakan() {
        $data['title'] = 'Daftar Tunggakan Iuran';
        $data['tunggakan'] = $this->Iuran_model->get_tunggakan();

        $this->render('iuran/tunggakan', $data);
    }
}
