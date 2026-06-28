<div class="row">
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Detail Pengajuan Surat</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 150px">Nama Warga</th>
                        <td><?= $surat->nama_lengkap ?></td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td><?= $surat->nik ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Surat</th>
                        <td><?= $surat->jenis_surat ?></td>
                    </tr>
                    <tr>
                        <th>Keperluan</th>
                        <td><?= $surat->keperluan ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td><?= date('d-m-Y', strtotime($surat->tanggal_pengajuan)) ?></td>
                    </tr>
                    <tr>
                        <th>Status Saat Ini</th>
                        <td>
                            <?php if ($surat->status == 'Diajukan'): ?>
                                <span class="badge badge-warning">Diajukan</span>
                            <?php elseif ($surat->status == 'Diproses'): ?>
                                <span class="badge badge-info">Diproses</span>
                            <?php elseif ($surat->status == 'Selesai'): ?>
                                <span class="badge badge-success">Selesai</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Ditolak</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Dokumen Pendukung</th>
                        <td>
                            <?php if($surat->dokumen_pendukung): ?>
                                <a href="<?= base_url('uploads/dokumen/'.$surat->dokumen_pendukung) ?>" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-file"></i> Lihat File</a>
                            <?php else: ?>
                                <span class="text-muted">Tidak ada dokumen dilampirkan</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Status Surat</h3>
            </div>
            <form action="<?= current_url() ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                
                <div class="card-body">
                    <div class="form-group">
                        <label>Ubah Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Diajukan" <?= $surat->status == 'Diajukan' ? 'selected' : '' ?>>Diajukan (Belum Diproses)</option>
                            <option value="Diproses" <?= $surat->status == 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                            <option value="Selesai" <?= $surat->status == 'Selesai' ? 'selected' : '' ?>>Selesai (Generate PDF)</option>
                            <option value="Ditolak" <?= $surat->status == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                        </select>
                        <small class="text-muted">Jika diubah menjadi "Selesai", sistem akan otomatis meng-generate PDF Surat yang ditandatangani Ketua RT.</small>
                    </div>
                    <div class="form-group">
                        <label>Catatan / Alasan Penolakan</label>
                        <textarea name="catatan" class="form-control" rows="4"><?= $surat->catatan ?></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Update</button>
                    <a href="<?= base_url('surat') ?>" class="btn btn-default">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
