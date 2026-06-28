<div class="card">
    <div class="card-header bg-info text-white">
        <h3 class="card-title"><?= $pengumuman->judul ?></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 text-muted mb-3">
                <i class="far fa-calendar-alt"></i> Dipublish tanggal: <?= date('d F Y', strtotime($pengumuman->tanggal_publish)) ?>
                <span class="float-right text-<?= $pengumuman->is_active ? 'success' : 'secondary' ?>">
                    <i class="fas fa-circle"></i> <?= $pengumuman->is_active ? 'Aktif' : 'Tidak Aktif' ?>
                </span>
            </div>
            
            <?php if($pengumuman->gambar): ?>
            <div class="col-md-12 mb-4 text-center">
                <img src="<?= base_url('uploads/pengumuman/'.$pengumuman->gambar) ?>" class="img-fluid rounded" style="max-height: 400px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            </div>
            <?php endif; ?>
            
            <div class="col-md-12">
                <p style="white-space: pre-wrap; font-size: 1.1em; line-height: 1.6;"><?= $pengumuman->isi ?></p>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="<?= base_url('pengumuman') ?>" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
</div>
