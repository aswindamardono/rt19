<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pengajuan Surat</h3>
        <div class="card-tools">
            <?php if(in_array($this->session->userdata('role_id'), [1, 5])): ?>
            <a href="<?= base_url('surat/ajukan') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Ajukan Surat
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <table id="table-surat" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Surat</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Nama Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
