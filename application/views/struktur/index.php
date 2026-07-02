<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.75rem;">
    <h3 class="card-title">
      <i class="fas fa-sitemap mr-2 text-success"></i>
      Daftar Pengurus &amp; Struktur
    </h3>
    <div class="card-tools">
      <a href="<?= base_url('struktur/tambah') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Pengurus
      </a>
    </div>
  </div>

  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-bordered table-striped table-hover mb-0" style="width:100%;">
        <thead>
          <tr>
            <th style="width:60px;">Urut</th>
            <th style="width:80px;">Foto</th>
            <th>Jabatan</th>
            <th>Nama Pengurus</th>
            <th>Atasan</th>
            <th>No HP</th>
            <th style="width:100px;">Status</th>
            <th style="width:200px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Build parent lookup
          $by_id = [];
          foreach ($list as $r) $by_id[(int)$r->id] = $r;
          ?>
          <?php if (!empty($list)): ?>
            <?php foreach ($list as $row):
              $foto_path = !empty($row->foto) ? FCPATH . 'uploads/struktur/' . $row->foto : null;
              $has_foto  = $foto_path && is_file($foto_path);
              $initial   = strtoupper(mb_substr($row->nama ?: $row->jabatan, 0, 1));
              $parent    = (!empty($row->parent_id) && isset($by_id[(int)$row->parent_id])) ? $by_id[(int)$row->parent_id] : null;
            ?>
              <tr>
                <td class="text-center"><strong><?= (int)$row->urutan ?></strong></td>
                <td class="text-center">
                  <?php if ($has_foto): ?>
                    <img src="<?= base_url('uploads/struktur/' . $row->foto) ?>"
                         alt="" class="img-preview" style="width:42px;height:42px;border-radius:50%;object-fit:cover;border:2px solid #d1fae5;">
                  <?php else: ?>
                    <div class="rt-avatar" style="margin:0 auto;"><?= htmlspecialchars($initial, ENT_QUOTES) ?></div>
                  <?php endif; ?>
                </td>
                <td><strong><?= htmlspecialchars($row->jabatan, ENT_QUOTES) ?></strong></td>
                <td>
                  <?= !empty($row->nama)
                      ? htmlspecialchars($row->nama, ENT_QUOTES)
                      : '<span class="text-muted"><em>Belum diisi</em></span>' ?>
                </td>
                <td>
                  <?php if ($parent): ?>
                    <span class="badge badge-info"><?= htmlspecialchars($parent->jabatan, ENT_QUOTES) ?></span>
                  <?php else: ?>
                    <span class="badge badge-primary"><i class="fas fa-crown mr-1"></i>Root</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($row->no_hp)):
                    $wa = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $row->no_hp)); ?>
                    <a href="https://wa.me/<?= $wa ?>" target="_blank" class="btn btn-success btn-xs">
                      <i class="fab fa-whatsapp"></i> <?= htmlspecialchars($row->no_hp, ENT_QUOTES) ?>
                    </a>
                  <?php else: ?>
                    <span class="text-muted">&mdash;</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <?php if ($row->is_active): ?>
                    <span class="badge badge-success">Aktif</span>
                  <?php else: ?>
                    <span class="badge badge-secondary">Nonaktif</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="<?= base_url('struktur/edit/' . $row->id) ?>" class="btn btn-info btn-xs" title="Edit">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="<?= base_url('struktur/toggle/' . $row->id) ?>"
                     class="btn btn-warning btn-xs"
                     onclick="return confirm('Ubah status aktif jabatan ini?');"
                     title="Toggle Aktif">
                    <i class="fas fa-power-off"></i>
                  </a>
                  <a href="<?= base_url('struktur/hapus/' . $row->id) ?>"
                     class="btn btn-danger btn-xs"
                     onclick="return confirm('Hapus jabatan ini? Anak-anaknya akan dipindah ke atasan jabatan ini.');"
                     title="Hapus">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center" style="padding:3rem 1rem; color:#94a3b8;">
                <i class="fas fa-sitemap" style="font-size:2.5rem; opacity:0.4; display:block; margin-bottom:0.75rem;"></i>
                Belum ada data struktur.
                <a href="<?= base_url('struktur/tambah') ?>" class="text-success ml-1"><strong>Tambah sekarang</strong></a>.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="card-footer" style="font-size:0.82rem; color:#64748b;">
    <i class="fas fa-info-circle mr-1 text-info"></i>
    Susunan jabatan ditampilkan publik di landing page sesuai urutan.
    Nonaktifkan (toggle) untuk menyembunyikan tanpa menghapus data.
  </div>
</div>
