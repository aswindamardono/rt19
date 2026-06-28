<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $title ?></h3>
    </div>
    <div class="card-body">
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <?php 
            $is_edit = isset($inventaris);
            $action_url = $is_edit ? base_url('inventaris/edit/'.$inventaris->id_inventaris) : base_url('inventaris/tambah');
        ?>

        <?= form_open_multipart($action_url) ?>
            <div class="form-group mb-3">
                <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= form_error('nama_barang') ? 'is-invalid' : '' ?>" id="nama_barang" name="nama_barang" value="<?= set_value('nama_barang', $is_edit ? $inventaris->nama_barang : '') ?>">
                <div class="invalid-feedback">
                    <?= form_error('nama_barang') ?>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="jumlah">Jumlah <span class="text-danger">*</span></label>
                <input type="number" class="form-control <?= form_error('jumlah') ? 'is-invalid' : '' ?>" id="jumlah" name="jumlah" value="<?= set_value('jumlah', $is_edit ? $inventaris->jumlah : '') ?>" min="1">
                <div class="invalid-feedback">
                    <?= form_error('jumlah') ?>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="kondisi">Kondisi <span class="text-danger">*</span></label>
                <select class="form-control <?= form_error('kondisi') ? 'is-invalid' : '' ?>" id="kondisi" name="kondisi">
                    <option value="">-- Pilih Kondisi --</option>
                    <?php 
                        $kondisi_opts = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
                        $current_kondisi = set_value('kondisi', $is_edit ? $inventaris->kondisi : '');
                        foreach($kondisi_opts as $opt): 
                    ?>
                        <option value="<?= $opt ?>" <?= $current_kondisi == $opt ? 'selected' : '' ?>><?= $opt ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= form_error('kondisi') ?>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= set_value('keterangan', $is_edit ? $inventaris->keterangan : '') ?></textarea>
            </div>

            <div class="form-group mb-4">
                <label for="foto">Foto Barang</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/png, image/jpeg, image/gif">
                <small class="form-text text-muted">Format yang diizinkan: JPG, JPEG, PNG, GIF. Maksimal ukuran: 2MB.</small>
                <?php if($is_edit && $inventaris->foto): ?>
                    <div class="mt-2">
                        <p class="mb-1">Foto Saat Ini:</p>
                        <img src="<?= base_url('assets/img/inventaris/'.$inventaris->foto) ?>" alt="Foto" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="<?= base_url('inventaris') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        <?= form_close() ?>
    </div>
</div>
