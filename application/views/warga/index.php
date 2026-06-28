<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Warga RT-19</h3>
        <div class="card-tools">
            <a href="<?= base_url('warga/tambah') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Warga
            </a>
            <!-- Optional: Import/Export buttons could be added here -->
        </div>
    </div>
    <div class="card-body">
        <table id="table-warga" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>No KK</th>
                    <th>Nama Lengkap</th>
                    <th>L/P</th>
                    <th>Blok Rumah</th>
                    <th>Status Warga</th>
                    <th>Status KTP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- DataTables will populate this -->
            </tbody>
        </table>
    </div>
</div>
