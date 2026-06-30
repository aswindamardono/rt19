<!-- Inventaris Barang RT Page -->
<div class="pub-page" data-aos="fade-up" data-aos-duration="500">
<div class="pub-page-header">
  <h1><i class="fas fa-boxes"></i> Inventaris Barang RT</h1>
  <p>Daftar barang inventaris yang dikelola oleh pengurus RT-19</p>
</div>

<div class="pub-inv-grid">
  <?php if (!empty($inventaris)): ?>
    <?php foreach ($inventaris as $i => $inv): 
      $foto_url = !empty($inv->foto) && file_exists(FCPATH . 'assets/img/inventaris/' . $inv->foto) 
                  ? base_url('assets/img/inventaris/' . $inv->foto) : '';
      $js_data = json_encode([
        'nama' => $inv->nama_barang,
        'jumlah' => $inv->jumlah,
        'kondisi' => $inv->kondisi,
        'keterangan' => $inv->keterangan ?? '',
        'foto' => $foto_url
      ], JSON_HEX_APOS|JSON_HEX_QUOT);
    ?>
      <div class="pub-stat" data-aos="fade-up" data-aos-delay="<?= 100 + $i * 60 ?>" 
           style="cursor: pointer; transition: all 0.2s;" 
           onclick='openInvModal(<?= $js_data ?>)'
           onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 25px rgba(16,185,129,0.15)';"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='';">
        <div class="pub-stat-icon" style="background:#ecfdf5; color:var(--emerald-600);">
          <i class="fas fa-box"></i>
        </div>
        <div class="pub-stat-label"><?= htmlspecialchars($inv->nama_barang, ENT_QUOTES) ?></div>
        <div class="pub-stat-value" style="font-size: 1.35rem; color: var(--emerald-800);">
          <?= (int)$inv->jumlah ?>
        </div>
        <div class="pub-stat-period">
          Kondisi: <strong style="color: <?= $inv->kondisi === 'Baik' ? '#059669' : ($inv->kondisi === 'Rusak' ? '#dc2626' : '#d97706') ?>;">
            <?= htmlspecialchars($inv->kondisi, ENT_QUOTES) ?>
          </strong>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="pub-empty" style="grid-column: 1 / -1;">
      <i class="fas fa-box-open"></i>
      <h3>Belum ada data inventaris</h3>
      <p>Data inventaris belum ditambahkan.</p>
    </div>
  <?php endif; ?>
</div>

</div> <!-- Close pub-page BEFORE the modal -->

<!-- Modal Detail Inventaris -->
<div class="rt-modal-overlay" id="invModal" onclick="if(event.target===this) closeInvModal()">
  <div class="rt-modal-card">
    <button class="rt-modal-close" type="button" onclick="closeInvModal()" style="color:#1e293b; background:rgba(0,0,0,0.05); border:none;">
      <i class="fas fa-times"></i>
    </button>
    <div id="invModalPhoto" style="width:100%; height:220px; background:#f8fafc; display:flex; align-items:center; justify-content:center; overflow:hidden;"></div>
    
    <div class="rt-modal-body" style="padding-top:1.5rem;">
      <h3 id="invModalNama" style="margin-bottom:0.5rem; color:var(--emerald-900);"></h3>
      
      <div class="rt-modal-meta" style="margin-top:1.5rem;">
        <div class="rt-modal-row">
          <i class="fas fa-hashtag"></i>
          <div><div class="lbl">Jumlah</div><div class="val" id="invModalJumlah"></div></div>
        </div>
        <div class="rt-modal-row">
          <i class="fas fa-info-circle"></i>
          <div><div class="lbl">Kondisi</div><div class="val" id="invModalKondisi"></div></div>
        </div>
        <div class="rt-modal-row" style="align-items:flex-start; display:none;" id="invModalKetRow">
          <i class="fas fa-align-left" style="margin-top:2px;"></i>
          <div><div class="lbl">Keterangan</div><div class="val" id="invModalKeterangan" style="font-weight:500; white-space:pre-line;"></div></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function openInvModal(p) {
  var modal = document.getElementById('invModal');
  var photo = document.getElementById('invModalPhoto');
  var nama = document.getElementById('invModalNama');
  var jumlah = document.getElementById('invModalJumlah');
  var kondisi = document.getElementById('invModalKondisi');
  var ketRow = document.getElementById('invModalKetRow');
  var keterangan = document.getElementById('invModalKeterangan');

  if (p.foto) {
    photo.innerHTML = '<img src="' + p.foto + '" style="width:100%; height:100%; object-fit:cover;" alt="Foto Barang">';
  } else {
    photo.innerHTML = '<i class="fas fa-box-open" style="font-size:4rem; color:#cbd5e1;"></i>';
  }

  nama.textContent = p.nama || '-';
  jumlah.textContent = p.jumlah + ' Item';
  
  var kColor = p.kondisi === 'Baik' ? '#059669' : (p.kondisi === 'Rusak' ? '#dc2626' : '#d97706');
  kondisi.innerHTML = '<span style="color:' + kColor + ';">' + escapeHtml(p.kondisi) + '</span>';

  if (p.keterangan && p.keterangan.trim() !== '') {
    keterangan.textContent = p.keterangan;
    ketRow.style.display = 'flex';
  } else {
    ketRow.style.display = 'none';
  }

  modal.classList.add('is-open');
  document.body.style.overflow = 'hidden';
}

function closeInvModal() {
  document.getElementById('invModal').classList.remove('is-open');
  document.body.style.overflow = '';
}

function escapeHtml(s) {
  if (s == null) return '';
  return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}
</script>
