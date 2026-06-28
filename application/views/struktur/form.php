<?php
$is_edit  = !empty($row);
$jabatan  = $is_edit ? $row->jabatan      : '';
$nama     = $is_edit ? $row->nama         : '';
$no_hp    = $is_edit ? $row->no_hp        : '';
$desk     = $is_edit ? $row->deskripsi    : '';
$urut     = $is_edit ? (int)$row->urutan  : (int)($urutan_default ?? 0);
$is_act   = $is_edit ? (int)$row->is_active : 1;
$pid      = $is_edit ? $row->parent_id    : null;
$foto     = $is_edit ? $row->foto         : '';
$foto_url = ($is_edit && !empty($foto) && is_file(FCPATH.'uploads/struktur/'.$foto))
            ? base_url('uploads/struktur/'.$foto) : null;

$parent_options = $parents ?? [];

$suggest = [
  'Ketua RT', 'Wakil Ketua RT', 'Bendahara 1', 'Bendahara 2',
  'Sekretaris 1', 'Sekretaris 2',
  'SIE Pembangunan', 'SIE Keamanan', 'SIE Konsumsi',
  'SIE Seni & Olahraga', 'SIE Pendataan', 'SIE Pendanaan',
  'SIE Perlengkapan & Humas',
];
?>
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fas <?= $is_edit ? 'fa-user-edit' : 'fa-user-plus' ?> mr-2"></i>
      <?= $is_edit ? 'Edit Pengurus' : 'Tambah Pengurus' ?>
    </h3>
  </div>

  <form action="<?= current_url() ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

    <div class="card-body">
      <div class="row">
        <div class="col-md-7">
          <div class="form-group">
            <label>Jabatan <span class="text-danger">*</span></label>
            <input type="text" name="jabatan" class="form-control"
                   list="jabatan-suggest" required maxlength="100"
                   placeholder="Pilih atau ketik jabatan baru..."
                   value="<?= htmlspecialchars($jabatan, ENT_QUOTES) ?>">
            <datalist id="jabatan-suggest">
              <?php foreach ($suggest as $s): ?>
                <option value="<?= htmlspecialchars($s, ENT_QUOTES) ?>">
              <?php endforeach; ?>
            </datalist>
            <small class="text-muted">Bebas diketik &mdash; bisa di luar daftar di atas.</small>
          </div>

          <div class="form-group">
            <label>Nama Pengurus</label>
            <input type="text" name="nama" class="form-control"
                   maxlength="150" placeholder="Nama lengkap pengurus..."
                   value="<?= htmlspecialchars($nama, ENT_QUOTES) ?>">
          </div>

          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label>No HP / WhatsApp</label>
                <input type="text" name="no_hp" class="form-control"
                       maxlength="20" placeholder="081234567890"
                       value="<?= htmlspecialchars($no_hp, ENT_QUOTES) ?>">
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label>Urutan Tampil</label>
                <input type="number" name="urutan" class="form-control"
                       min="0" value="<?= $urut ?>">
                <small class="text-muted">Makin kecil makin atas.</small>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Atasan / Parent</label>
            <select name="parent_id" class="form-control">
              <option value="">— Tidak ada (Root / Ketua) —</option>
              <?php foreach ($parent_options as $opt): ?>
                <option value="<?= (int)$opt->id ?>" <?= ($pid && (int)$pid === (int)$opt->id) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($opt->jabatan, ENT_QUOTES) ?>
                  <?= !empty($opt->nama) ? ' — '.htmlspecialchars($opt->nama, ENT_QUOTES) : '' ?>
                </option>
              <?php endforeach; ?>
            </select>
            <small class="text-muted">
              Pilih jabatan atasan langsung. Kosongkan untuk jabatan tertinggi (mis. Ketua RT).
            </small>
          </div>

          <div class="form-group">
            <label>Deskripsi / Catatan (opsional)</label>
            <textarea name="deskripsi" class="form-control" rows="3"
                      placeholder="Tugas / catatan singkat..."><?= htmlspecialchars($desk, ENT_QUOTES) ?></textarea>
          </div>

          <div class="form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input"
                     id="cb_active" name="is_active" value="1"
                     <?= $is_act ? 'checked' : '' ?>>
              <label class="custom-control-label" for="cb_active">
                Tampilkan di halaman publik
              </label>
            </div>
          </div>
        </div>

        <div class="col-md-5">
          <div class="form-group">
            <label>Foto Pengurus (opsional)</label>
            <div style="background: var(--emerald-50); border: 1.5px dashed var(--emerald-300);
                        border-radius: var(--radius-md); padding: 1.25rem; text-align: center;">
              <?php if ($foto_url): ?>
                <img id="prv" src="<?= $foto_url ?>" alt=""
                     style="width:120px;height:120px;border-radius:50%;object-fit:cover;
                            border:3px solid white; box-shadow: var(--shadow-md); margin-bottom: 0.75rem;">
              <?php else: ?>
                <div id="prv-placeholder" class="rt-avatar"
                     style="width:120px;height:120px;font-size:2.5rem;margin: 0 auto 0.75rem;">
                  <i class="fas fa-user"></i>
                </div>
                <img id="prv" src="" alt=""
                     style="display:none;width:120px;height:120px;border-radius:50%;object-fit:cover;
                            border:3px solid white; box-shadow: var(--shadow-md); margin-bottom: 0.75rem;">
              <?php endif; ?>

              <div class="custom-file">
                <input type="file" class="custom-file-input" id="foto"
                       name="foto" accept="image/*" onchange="previewFoto(this)">
                <label class="custom-file-label" for="foto">Pilih foto...</label>
              </div>
              <small class="text-muted d-block mt-2">JPG / PNG / WebP. Maks 2 MB.</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Simpan
      </button>
      <a href="<?= base_url('struktur') ?>" class="btn btn-default">
        <i class="fas fa-times"></i> Batal
      </a>
    </div>
  </form>
</div>

<script>
  function previewFoto(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        var img = document.getElementById('prv');
        var ph  = document.getElementById('prv-placeholder');
        img.src = e.target.result;
        img.style.display = 'inline-block';
        if (ph) ph.style.display = 'none';
      };
      reader.readAsDataURL(input.files[0]);

      var lbl = input.nextElementSibling;
      if (lbl) lbl.textContent = input.files[0].name;
    }
  }
</script>
