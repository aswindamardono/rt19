<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_role([1, 3]); // Super Admin, Bendahara
        $this->load->model('Keuangan_model');
    }

    // ============================================
    // PEMASUKAN
    // ============================================
    public function pemasukan() {
        $data['title'] = 'Data Pemasukan Kas';
        
        $data['custom_js'] = "
        <script>
            var table;
            $(document).ready(function() {
                $('#modalTambah').appendTo('body');
                table = $('#table-pemasukan').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'order': [],
                    'ajax': {
                        'url': '".base_url('keuangan/pemasukan_datatable')."',
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

            function hapus_pemasukan(id) {
                Swal.fire({
                    title: 'Yakin hapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".base_url('keuangan/hapus_pemasukan/')."' + id;
                    }
                })
            }
        </script>
        ";
        
        $this->render('keuangan/pemasukan', $data);
    }

    public function pemasukan_datatable() {
        $list = $this->Keuangan_model->get_pemasukan_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row) {
            $no++;
            $r = array();
            $r[] = $no;
            $r[] = date('d-m-Y', strtotime($row->tanggal));
            $r[] = $row->kategori;
            $r[] = $row->keterangan;
            $r[] = 'Rp ' . number_format($row->nominal, 0, ',', '.');
            
            $btn = '<button type="button" onclick="hapus_pemasukan('.$row->id.')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>';
            $r[] = $btn;

            $data[] = $r;
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Keuangan_model->count_all_pemasukan(),
            'recordsFiltered' => $this->Keuangan_model->count_filtered_pemasukan(),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function tambah_pemasukan() {
        $data = [
            'tanggal' => $this->input->post('tanggal', TRUE),
            'kategori' => $this->input->post('kategori', TRUE),
            'keterangan' => $this->input->post('keterangan', TRUE),
            'nominal' => str_replace(['Rp', '.', ' '], '', $this->input->post('nominal', TRUE)),
            'created_by' => $this->user_id
        ];

        $this->Keuangan_model->insert_pemasukan($data);
        $this->session->set_flashdata('success', 'Pemasukan berhasil ditambahkan.');
        redirect('keuangan/pemasukan');
    }

    public function hapus_pemasukan($id) {
        $this->Keuangan_model->delete_pemasukan($id);
        $this->session->set_flashdata('success', 'Pemasukan berhasil dihapus.');
        redirect('keuangan/pemasukan');
    }


    // ============================================
    // PENGELUARAN
    // ============================================
    public function pengeluaran() {
        $data['title'] = 'Data Pengeluaran Kas';
        
        $data['custom_js'] = "
        <script>
            var table;
            $(document).ready(function() {
                $('#modalTambah').appendTo('body');
                table = $('#table-pengeluaran').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'order': [],
                    'ajax': {
                        'url': '".base_url('keuangan/pengeluaran_datatable')."',
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

            function hapus_pengeluaran(id) {
                Swal.fire({
                    title: 'Yakin hapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".base_url('keuangan/hapus_pengeluaran/')."' + id;
                    }
                })
            }
        </script>
        ";
        
        $this->render('keuangan/pengeluaran', $data);
    }

    public function pengeluaran_datatable() {
        $list = $this->Keuangan_model->get_pengeluaran_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $row) {
            $no++;
            $r = array();
            $r[] = $no;
            $r[] = date('d-m-Y', strtotime($row->tanggal));
            $r[] = $row->kategori;
            $r[] = $row->keterangan;
            $r[] = 'Rp ' . number_format($row->nominal, 0, ',', '.');
            
            $btn = '<button type="button" onclick="hapus_pengeluaran('.$row->id.')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>';
            $r[] = $btn;

            $data[] = $r;
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Keuangan_model->count_all_pengeluaran(),
            'recordsFiltered' => $this->Keuangan_model->count_filtered_pengeluaran(),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function tambah_pengeluaran() {
        $data = [
            'tanggal' => $this->input->post('tanggal', TRUE),
            'kategori' => $this->input->post('kategori', TRUE),
            'keterangan' => $this->input->post('keterangan', TRUE),
            'nominal' => str_replace(['Rp', '.', ' '], '', $this->input->post('nominal', TRUE)),
            'created_by' => $this->user_id
        ];

        $this->Keuangan_model->insert_pengeluaran($data);
        $this->session->set_flashdata('success', 'Pengeluaran berhasil ditambahkan.');
        redirect('keuangan/pengeluaran');
    }

    public function hapus_pengeluaran($id) {
        $this->Keuangan_model->delete_pengeluaran($id);
        $this->session->set_flashdata('success', 'Pengeluaran berhasil dihapus.');
        redirect('keuangan/pengeluaran');
    }

    // ============================================
    // LAPORAN
    // ============================================
    public function laporan() {
        $data['title'] = 'Laporan Keuangan';
        
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-t');

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['laporan'] = $this->Keuangan_model->get_laporan($start_date, $end_date);

        $this->render('keuangan/laporan', $data);
    }
}
