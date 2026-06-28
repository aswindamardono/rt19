<!-- Pengumuman Page -->
<div class="pub-page-header">
  <h1><i class="fas fa-bullhorn"></i> Pengumuman Warga</h1>
  <p>Informasi terbaru dari pengurus RT-19</p>
</div>

<div class="pub-ann-grid">
  <?php if (!empty($pengumuman)): ?>
    <?php foreach ($pengumuman as $i => $p):
      $img_path = !empty($p->gambar) ? FCPATH.'uploads/pengumuman/'.$p->gambar : null;
      $has_img  = $img_path && is_file($img_path);
      $foto_url = $has_img ? base_url('uploads/pengumuman/'.$p->gambar) : '';
      $js_data = json_encode([
        'judul' => $p->judul,
        'tanggal' => date('d M Y', strtotime($p->tanggal_publish)),
        'isi' => $p->isi,
        'foto' => $foto_url
      ], JSON_HEX_APOS|JSON_HEX_QUOT);
    ?>
      <article class="ann-card" data-aos="fade-up" data-aos-delay="<?= 100 + $i * 80 ?>" 
               style="cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;"
               onclick='openAnnModal(<?= $js_data ?>)'
               onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='';">
        <?php if ($has_img): ?>
          <img class="ann-card-img"
               src="<?= htmlspecialchars($foto_url) ?>"
               alt="<?= htmlspecialchars($p->judul, ENT_QUOTES) ?>"
               onerror="this.style.display='none'">
        <?php endif; ?>
        <div class="ann-card-body">
          <div class="ann-card-date">
            <i class="far fa-calendar-alt"></i>
            <?= date('d M Y', strtotime($p->tanggal_publish)) ?>
          </div>
          <h3 class="ann-card-title"><?= htmlspecialchars($p->judul, ENT_QUOTES) ?></h3>
          <p><?= nl2br(htmlspecialchars(
                mb_strimwidth(strip_tags($p->isi), 0, 220, '…'),
                ENT_QUOTES
              )) ?></p>
        </div>
      </article>
    <?php endforeach; ?>
  <?php else: ?>
    <div class="pub-empty">
      <i class="far fa-bell-slash"></i>
      <h3>Belum ada pengumuman</h3>
      <p>Pengurus RT belum mempublikasikan pengumuman saat ini.</p>
    </div>
  <?php endif; ?>
</div>

<!-- Modal Detail Pengumuman -->
<div class="rt-modal-overlay" id="annModal" onclick="if(event.target===this) closeAnnModal()">
  <div class="rt-modal-card" style="max-width: 600px;">
    <button class="rt-modal-close" type="button" onclick="closeAnnModal()" style="color:#1e293b; background:rgba(0,0,0,0.05); border:none; top:1rem; right:1rem;">
      <i class="fas fa-times"></i>
    </button>
    <div id="annModalPhoto" style="width:100%; max-height:300px; display:flex; align-items:center; justify-content:center; overflow:hidden; display:none;"></div>
    
    <div class="rt-modal-body" style="padding:1.5rem 1.75rem 2rem; text-align:left;">
      <div style="font-size:0.85rem; color:#64748b; margin-bottom:0.6rem; font-weight:500;" id="annModalDate"></div>
      <h2 id="annModalTitle" style="margin-top:0; margin-bottom:1.25rem; font-size:1.4rem; color:var(--emerald-900); font-family:'Plus Jakarta Sans', sans-serif;"></h2>
      
      <div id="annModalContent" style="color:#475569; font-size:0.95rem; line-height:1.7; white-space:pre-wrap;"></div>
    </div>
  </div>
</div>

<script>
function openAnnModal(p) {
  var modal = document.getElementById('annModal');
  var photo = document.getElementById('annModalPhoto');
  var title = document.getElementById('annModalTitle');
  var date = document.getElementById('annModalDate');
  var content = document.getElementById('annModalContent');

  if (p.foto) {
    photo.innerHTML = '<img src="' + p.foto + '" style="width:100%; height:auto; object-fit:contain; max-height:300px;" alt="Foto Pengumuman">';
    photo.style.display = 'flex';
  } else {
    photo.innerHTML = '';
    photo.style.display = 'none';
  }

  title.textContent = p.judul || '-';
  date.innerHTML = '<i class="far fa-calendar-alt"></i> ' + escapeHtml(p.tanggal);
  content.innerHTML = p.isi || ''; // 'isi' usually comes directly from db (could be html from editor, depending on how you stored it. Assuming we can render it safely or using nl2br/escape if it's plain text. I'll stick to innerHTML if it contains formatting, but let's be safe and use textContent if it's plain). If you use Summernote in admin, use innerHTML.

  modal.classList.add('is-open');
  document.body.style.overflow = 'hidden';
}

function closeAnnModal() {
  document.getElementById('annModal').classList.remove('is-open');
  document.body.style.overflow = '';
}

if (typeof escapeHtml !== 'function') {
  function escapeHtml(s) {
    if (s == null) return '';
    return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  }
}
</script>
