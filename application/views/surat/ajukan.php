<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Ajukan Surat Pengantar</h3>
    </div>
    
    <form action="<?= current_url() ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        
        <div class="card-body">
            <div class="form-group">
                <label>Jenis Surat</label>
                <select name="jenis_surat" class="form-control" required>
                    <option value="">-- Pilih Jenis Surat --</option>
                    <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                    <option value="Surat Pengantar SKCK">Surat Pengantar SKCK</option>
                    <option value="Surat Pengantar Nikah">Surat Pengantar Nikah</option>
                    <option value="Surat Keterangan Tidak Mampu">Surat Keterangan Tidak Mampu</option>
                    <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
                </select>
            </div>
            <div class="form-group">
                <label>Keperluan</label>
                <textarea name="keperluan" class="form-control" rows="3" required placeholder="Jelaskan keperluan pembuatan surat..."></textarea>
            </div>
            <div class="form-group">
                <label>Dokumen Pendukung (Opsional)</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="dokumen_pendukung" id="customFile" accept=".pdf,.jpg,.jpeg,.png">
                    <label class="custom-file-label" for="customFile">Pilih file (KTP/KK)...</label>
                </div>
                <small class="text-muted">Format: PDF, JPG, PNG. Maks: 2MB.</small>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Ajukan Surat</button>
            <a href="<?= base_url('surat') ?>" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>

<?php 
$data['custom_js'] = "
<script>
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });
</script>
";
?>
