<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?= $title ?></h3>
    </div>
    
    <form action="<?= current_url() ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" value="<?= isset($warga) ? $warga->nik : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>No KK</label>
                        <input type="text" name="no_kk" class="form-control" value="<?= isset($warga) ? $warga->no_kk : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" class="form-control" required value="<?= isset($warga) ? $warga->nama_lengkap : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin *</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="Laki-laki" <?= (isset($warga) && $warga->jenis_kelamin == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= (isset($warga) && $warga->jenis_kelamin == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status KTP (Tinggal)</label>
                        <select name="tempat_lahir" class="form-control">
                            <option value="">-- Pilih Status KTP --</option>
                            <option value="Warga BerKTP Orchid" <?= (isset($warga) && $warga->tempat_lahir == 'Warga BerKTP Orchid') ? 'selected' : '' ?>>Warga BerKTP Orchid</option>
                            <option value="Warga Non KTP Orchid" <?= (isset($warga) && $warga->tempat_lahir == 'Warga Non KTP Orchid') ? 'selected' : '' ?>>Warga Non KTP Orchid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="<?= isset($warga) ? $warga->tanggal_lahir : '' ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status Warga</label>
                        <select name="alamat" class="form-control" required>
                            <option value="">-- Pilih Status Warga --</option>
                            <option value="Warga Tetap" <?= (isset($warga) && $warga->alamat == 'Warga Tetap') ? 'selected' : '' ?>>Warga Tetap</option>
                            <option value="Warga Kontrak" <?= (isset($warga) && $warga->alamat == 'Warga Kontrak') ? 'selected' : '' ?>>Warga Kontrak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Blok Rumah</label>
                        <input type="text" name="rt" class="form-control" value="<?= isset($warga) ? $warga->rt : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label>No HP / WhatsApp</label>
                        <input type="text" name="no_hp" class="form-control" value="<?= isset($warga) ? $warga->no_hp : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Status Perkawinan</label>
                        <select name="status_perkawinan" class="form-control">
                            <?php 
                            $status_options = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];
                            foreach($status_options as $opt): 
                            ?>
                                <option value="<?= $opt ?>" <?= (isset($warga) && $warga->status_perkawinan == $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" value="<?= isset($warga) ? $warga->pekerjaan : '' ?>">
                    </div>
                    <?php if(isset($warga)): ?>
                    <div class="form-group">
                        <label>Status Aktif</label>
                        <select name="status_aktif" class="form-control">
                            <option value="1" <?= $warga->status_aktif == 1 ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= $warga->status_aktif == 0 ? 'selected' : '' ?>>Tidak Aktif (Pindah/Meninggal)</option>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="<?= base_url('warga') ?>" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
