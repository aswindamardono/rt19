<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?= isset($title) ? $title : (isset($pengumuman) ? 'Edit Pengumuman' : 'Buat Pengumuman Baru') ?></h3>
    </div>
    
    <form action="<?= current_url() ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        
        <div class="card-body">
            <div class="form-group">
                <label>Judul Pengumuman</label>
                <input type="text" name="judul" class="form-control" required placeholder="Masukkan judul pengumuman" value="<?= isset($pengumuman) ? htmlspecialchars($pengumuman->judul) : '' ?>">
            </div>
            <div class="form-group">
                <label>Isi Pengumuman</label>
                <textarea name="isi" class="form-control" rows="6" required placeholder="Tuliskan isi pengumuman secara detail..."><?= isset($pengumuman) ? htmlspecialchars($pengumuman->isi) : '' ?></textarea>
            </div>
            <div class="form-group">
                <label>Gambar Lampiran (Opsional)</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="gambar[]" id="customFile" accept=".jpg,.jpeg,.png" multiple>
                    <label class="custom-file-label" for="customFile">Pilih gambar (bisa lebih dari satu)...</label>
                </div>
                <small class="text-muted">Format: JPG, PNG. Maks: 2MB.</small>
            </div>
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1" <?= (isset($pengumuman) && $pengumuman->is_active == 0) ? '' : 'checked' ?>>
                    <label class="custom-control-label" for="customSwitch1">Aktifkan & Kirim Notifikasi ke Warga</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-bullhorn"></i> <?= isset($pengumuman) ? 'Update Pengumuman' : 'Publish Pengumuman' ?></button>
            <a href="<?= base_url('pengumuman') ?>" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>

<?php 
$data['custom_js'] = "
<script>
    $('.custom-file-input').on('change', function() {
        var files = $(this)[0].files;
        var label = 'Pilih gambar (bisa lebih dari satu)...';
        if (files.length == 1) {
            label = files[0].name;
        } else if (files.length > 1) {
            label = files.length + ' file terpilih';
        }
        $(this).siblings('.custom-file-label').addClass('selected').html(label);
    });
</script>
";
?>
