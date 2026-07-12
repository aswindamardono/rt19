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
            
            <?php if($pengumuman->gambar): 
                $gambar_arr = json_decode($pengumuman->gambar, true);
                if (is_array($gambar_arr) && count($gambar_arr) > 0):
            ?>
            <div class="col-md-12 mb-4">
                <div id="carouselPengumuman" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner text-center" style="background-color: #f8f9fa; border-radius: 8px; padding: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        <?php foreach($gambar_arr as $index => $img): ?>
                        <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                            <img src="<?= base_url('uploads/pengumuman/'.$img) ?>" class="img-fluid rounded" style="max-height: 400px; object-fit: contain;">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if(count($gambar_arr) > 1): ?>
                    <a class="carousel-control-prev" href="#carouselPengumuman" role="button" data-slide="prev" style="filter: invert(100%);">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselPengumuman" role="button" data-slide="next" style="filter: invert(100%);">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="col-md-12 mb-4 text-center">
                <img src="<?= base_url('uploads/pengumuman/'.$pengumuman->gambar) ?>" class="img-fluid rounded img-preview" style="max-height: 400px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            </div>
            <?php endif; endif; ?>
            
            <div class="col-md-12">
                <p style="white-space: pre-wrap; font-size: 1.1em; line-height: 1.6;"><?= $pengumuman->isi ?></p>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="<?= base_url('pengumuman') ?>" class="btn btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
</div>
