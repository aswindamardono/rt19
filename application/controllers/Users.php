<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_role([1]); // Only Super Admin
        $this->load->model('User_model');
    }

    public function index() {
        $data['title'] = 'Kelola User';

        $data['custom_js'] = "
        <script>
            var table;
            $(document).ready(function() {
                table = $('#table-users').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'order': [],
                    'ajax': {
                        'url': '".base_url('users/datatable')."',
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

            function hapus_user(id) {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: 'Data user yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '".base_url('users/hapus/')."' + id;
                    }
                })
            }
        </script>
        ";

        $this->render('users/index', $data);
    }

    public function datatable() {
        $list = $this->User_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = htmlspecialchars($user->username);
            $row[] = htmlspecialchars($user->nama_lengkap);
            $row[] = htmlspecialchars($user->email ?: '-');
            $row[] = '<span class="badge badge-info">' . htmlspecialchars($user->nama_role ?: '-') . '</span>';
            $row[] = $user->is_active ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Nonaktif</span>';

            $btn = '<a href="'.base_url('users/edit/'.$user->id).'" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a> ';
            $btn .= '<a href="'.base_url('users/ganti_password/'.$user->id).'" class="btn btn-sm btn-warning" title="Ganti Password"><i class="fas fa-key"></i></a> ';
            // Don't allow deleting own account
            if ($user->id != $this->session->userdata('user_id')) {
                $btn .= '<button type="button" onclick="hapus_user('.$user->id.')" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>';
            }
            $row[] = $btn;

            $data[] = $row;
        }

        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->User_model->count_all(),
            'recordsFiltered' => $this->User_model->count_filtered(),
            'data' => $data,
        );
        echo json_encode($output);
    }

    public function tambah() {
        $data['title'] = 'Tambah User';
        $data['roles'] = $this->User_model->get_all_roles();

        if ($this->input->post()) {
            // Check duplicate username
            $username = $this->input->post('username', TRUE);
            $existing = $this->User_model->get_by_username($username);
            if ($existing) {
                $this->session->set_flashdata('error', 'Username "' . $username . '" sudah digunakan.');
                redirect('users/tambah');
            }

            $insert_data = [
                'username'     => $username,
                'password'     => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                'email'        => $this->input->post('email', TRUE),
                'role_id'      => $this->input->post('role_id', TRUE),
                'is_active'    => 1
            ];

            $this->User_model->insert($insert_data);
            $this->session->set_flashdata('success', 'User berhasil ditambahkan.');
            redirect('users');
        }

        $this->render('users/form', $data);
    }

    public function edit($id) {
        $data['title'] = 'Edit User';
        $data['user'] = $this->User_model->get_by_id($id);
        $data['roles'] = $this->User_model->get_all_roles();

        if (!$data['user']) {
            show_404();
        }

        if ($this->input->post()) {
            // Check duplicate username (exclude self)
            $username = $this->input->post('username', TRUE);
            $existing = $this->User_model->get_by_username($username);
            if ($existing && $existing->id != $id) {
                $this->session->set_flashdata('error', 'Username "' . $username . '" sudah digunakan.');
                redirect('users/edit/' . $id);
            }

            $update_data = [
                'username'     => $username,
                'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
                'email'        => $this->input->post('email', TRUE),
                'role_id'      => $this->input->post('role_id', TRUE),
                'is_active'    => $this->input->post('is_active', TRUE)
            ];

            $this->User_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Data user berhasil diupdate.');
            redirect('users');
        }

        $this->render('users/form', $data);
    }

    public function ganti_password($id) {
        $data['title'] = 'Ganti Password';
        $data['user'] = $this->User_model->get_by_id($id);

        if (!$data['user']) {
            show_404();
        }

        if ($this->input->post()) {
            $password = $this->input->post('password');
            $confirm  = $this->input->post('password_confirm');

            if (strlen($password) < 6) {
                $this->session->set_flashdata('error', 'Password minimal 6 karakter.');
                redirect('users/ganti_password/' . $id);
            }

            if ($password !== $confirm) {
                $this->session->set_flashdata('error', 'Konfirmasi password tidak cocok.');
                redirect('users/ganti_password/' . $id);
            }

            $this->User_model->update($id, [
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ]);

            $this->session->set_flashdata('success', 'Password user "' . $data['user']->username . '" berhasil diubah.');
            redirect('users');
        }

        $this->render('users/password', $data);
    }

    public function hapus($id) {
        $user = $this->User_model->get_by_id($id);
        if (!$user) {
            show_404();
        }

        // Prevent deleting own account
        if ($user->id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus akun sendiri.');
            redirect('users');
        }

        $this->User_model->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus.');
        redirect('users');
    }
}
