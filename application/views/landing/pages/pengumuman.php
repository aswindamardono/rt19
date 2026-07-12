<!-- Pengumuman Page -->
<div class="pub-page" data-aos="fade-up" data-aos-duration="500">
<div class="pub-page-header">
  <h1><i class="fas fa-bullhorn"></i> Pengumuman Warga</h1>
  <p>Informasi terbaru dari pengurus RT-19</p>
</div>

<div class="pub-ann-grid">
  <?php if (!empty($pengumuman)): ?>
    <?php foreach ($pengumuman as $i => $p):
      $foto_arr = [];
      $has_img = false;
      if (!empty($p->gambar)) {
          $decoded = json_decode($p->gambar, true);
          if (is_array($decoded) && count($decoded) > 0) {
              foreach ($decoded as $img) {
                  if (is_file(FCPATH.'uploads/pengumuman/'.$img)) {
                      $foto_arr[] = base_url('uploads/pengumuman/'.$img);
                      $has_img = true;
                  }
              }
          } else {
              if (is_file(FCPATH.'uploads/pengumuman/'.$p->gambar)) {
                  $foto_arr[] = base_url('uploads/pengumuman/'.$p->gambar);
                  $has_img = true;
              }
          }
      }
      $foto_url = $has_img ? $foto_arr[0] : '';
      
      $js_data = json_encode([
        'judul' => $p->judul,
        'tanggal' => date('d M Y', strtotime($p->tanggal_publish)),
        'isi' => $p->isi,
        'foto' => $foto_arr
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

</div> <!-- Close pub-page BEFORE the modal -->

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
var currentAnnSlide = 0;
function showAnnSlide(n) {
    var track = document.getElementById("annSliderTrack");
    if (!track) return;
    var slidesCount = track.children.length;
    if (slidesCount === 0) return;
    
    if (n >= slidesCount) currentAnnSlide = 0;
    if (n < 0) currentAnnSlide = slidesCount - 1;
    
    var offset = -(currentAnnSlide * 100);
    track.style.transform = "translateX(" + offset + "%)";
}
function nextAnnSlide() {
    currentAnnSlide++;
    showAnnSlide(currentAnnSlide);
}
function prevAnnSlide() {
    currentAnnSlide--;
    showAnnSlide(currentAnnSlide);
}

function openAnnModal(p) {
  var modal = document.getElementById('annModal');
  var photo = document.getElementById('annModalPhoto');
  var title = document.getElementById('annModalTitle');
  var date = document.getElementById('annModalDate');
  var content = document.getElementById('annModalContent');

  if (p.foto && p.foto.length > 0) {
      if (p.foto.length === 1) {
          photo.innerHTML = '<img src="' + p.foto[0] + '" style="width:100%; height:auto; object-fit:contain; max-height:300px;" alt="Foto Pengumuman">';
      } else {
          var html = '<div style="position:relative; width:100%; background-color:#f8f9fa; overflow:hidden; display:flex; align-items:center; min-height:200px;">';
          html += '<div id="annSliderTrack" style="display:flex; width:100%; transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1); transform: translateX(0%);">';
          p.foto.forEach(function(f, idx) {
              html += '<div style="flex: 0 0 100%; min-width: 100%; text-align: center;">';
              html += '<img src="' + f + '" style="max-width:100%; max-height:300px; object-fit:contain; vertical-align:middle;" alt="Foto Pengumuman">';
              html += '</div>';
          });
          html += '</div>';
          html += '<button onclick="prevAnnSlide()" style="position:absolute; top:50%; left:10px; transform:translateY(-50%); background:rgba(0,0,0,0.5); color:white; border:none; width:36px; height:36px; border-radius:50%; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center; z-index:10; transition:background 0.2s;">&#10094;</button>';
          html += '<button onclick="nextAnnSlide()" style="position:absolute; top:50%; right:10px; transform:translateY(-50%); background:rgba(0,0,0,0.5); color:white; border:none; width:36px; height:36px; border-radius:50%; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center; z-index:10; transition:background 0.2s;">&#10095;</button>';
          html += '</div>';
          photo.innerHTML = html;
          currentAnnSlide = 0;
      }
      photo.style.display = 'block';
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
