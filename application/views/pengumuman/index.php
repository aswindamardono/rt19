<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengumuman</h3>
        <div class="card-tools">
            <?php if(in_array($this->session->userdata('role_id'), [1, 4])): ?>
            <a href="<?= base_url('pengumuman/tambah') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-bullhorn"></i> Buat Pengumuman
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <table id="table-pengumuman" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Judul</th>
                    <th>Pembuat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
