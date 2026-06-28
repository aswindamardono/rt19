<!-- Struktur Organisasi Page -->
<div class="pub-page" data-aos="fade-up" data-aos-duration="500">
<div class="pub-page-header">
  <h1><i class="fas fa-sitemap"></i> Struktur Organisasi</h1>
  <p>Susunan pengurus RT-19 Orchid Regency &mdash; klik kartu untuk melihat detail</p>
</div>

<?php if (!empty($struktur)): ?>
<div class="orgchart-wrapper" data-aos="fade-up" data-aos-delay="100">
  <?php
  // Build hierarchy tree
  function build_tree_public($items, $parent_id = null) {
    $branch = [];
    foreach ($items as $item) {
      if ($item->parent_id == $parent_id) {
        $children = build_tree_public($items, $item->id);
        $item->children = $children;
        $branch[] = $item;
      }
    }
    return $branch;
  }

  function render_tree_public($nodes, $base_url, $is_root_level = true) {
    if (empty($nodes)) return;

    if ($is_root_level) {
      echo '<div class="org-tree-list">';
    } else {
      echo '<div class="org-tree-children">';
    }

    foreach ($nodes as $node) {
      $is_root = ($node->parent_id === null || $node->parent_id == 0);
      $root_cls = $is_root ? ' org-root' : '';
      $has_foto = !empty($node->foto) && file_exists(FCPATH . 'uploads/struktur/' . $node->foto);
      $foto_url = $has_foto ? $base_url . 'uploads/struktur/' . $node->foto : '';
      $initial  = !empty($node->nama) ? mb_strtoupper(mb_substr($node->nama, 0, 1)) : '?';
      $js_data  = json_encode([
        'jabatan'   => $node->jabatan ?? '',
        'nama'      => $node->nama ?? '',
        'no_hp'     => $node->no_hp ?? '',
        'deskripsi' => $node->deskripsi ?? '',
        'foto'      => $foto_url,
        'initial'   => $initial
      ], JSON_HEX_APOS|JSON_HEX_QUOT);

      echo '<div class="org-tree-node">';
      echo '<div class="org-card' . $root_cls . '" onclick=\'openStrukturModal(' . $js_data . ')\'>';
      if ($has_foto) {
        echo '<img class="org-avatar" src="' . htmlspecialchars($foto_url) . '" alt="">';
      } else {
        echo '<div class="org-avatar">' . $initial . '</div>';
      }
      
      echo '<div class="org-info">';
      echo '<div class="org-title">' . htmlspecialchars($node->jabatan ?? '-') . '</div>';
      if (!empty($node->nama)) {
        echo '<div class="org-name">' . htmlspecialchars($node->nama) . '</div>';
      } else {
        echo '<div class="org-name org-name-empty">(belum diisi)</div>';
      }
      echo '</div>'; // close .org-info
      echo '</div>'; // close .org-card

      if (!empty($node->children)) {
        render_tree_public($node->children, $base_url, false);
      }
      
      echo '</div>'; // close .org-tree-node
    }

    echo '</div>';
  }

  $tree = build_tree_public($struktur);
  render_tree_public($tree, base_url());
  ?>
</div>
<?php else: ?>
<div class="pub-empty" data-aos="fade-up">
  <i class="fas fa-sitemap"></i>
  <h3>Belum ada data struktur</h3>
  <p>Data struktur organisasi belum ditambahkan.</p>
</div>
<?php endif; ?>

<!-- Modal: Detail Pengurus -->
<div class="rt-modal-overlay" id="strukturModal" onclick="if(event.target===this) closeStrukturModal()">
  <div class="rt-modal-card" role="dialog" aria-modal="true" aria-labelledby="modalJabatan">
    <button class="rt-modal-close" type="button" onclick="closeStrukturModal()" aria-label="Tutup">
      <i class="fas fa-times"></i>
    </button>
    <div class="rt-modal-head">
      <p class="rt-modal-jabatan" id="modalJabatan">&mdash;</p>
    </div>
    <div id="modalPhotoSlot"></div>
    <div class="rt-modal-body">
      <h3 id="modalNama">&mdash;</h3>
      <div class="rt-modal-meta" id="modalMeta"></div>
      <div id="modalWaSlot"></div>
    </div>
  </div>
</div>

<script>
function openStrukturModal(p) {
  var modal     = document.getElementById('strukturModal');
  var jabatan   = document.getElementById('modalJabatan');
  var nama      = document.getElementById('modalNama');
  var meta      = document.getElementById('modalMeta');
  var photoSlot = document.getElementById('modalPhotoSlot');
  var waSlot    = document.getElementById('modalWaSlot');

  jabatan.textContent = p.jabatan || '-';

  if (p.foto) {
    photoSlot.innerHTML = '<img class="rt-modal-photo" src="' + p.foto + '" alt="">';
  } else {
    photoSlot.innerHTML = '<div class="rt-modal-photo initial">' +
      (p.initial || '?').replace(/[<>&"]/g, '') + '</div>';
  }

  if (p.nama) {
    nama.innerHTML = escapeHtml(p.nama);
  } else {
    nama.innerHTML = '<span class="muted">Belum diisi</span>';
  }

  var rows = '';
  if (p.no_hp) {
    rows += '<div class="rt-modal-row"><i class="fas fa-phone"></i><div><div class="lbl">Kontak</div><div class="val">' + escapeHtml(p.no_hp) + '</div></div></div>';
  }
  if (p.deskripsi) {
    rows += '<div class="rt-modal-row" style="align-items:flex-start;"><i class="fas fa-info-circle" style="margin-top:2px;"></i><div><div class="lbl">Deskripsi</div><div class="val" style="font-weight:500; white-space:pre-line;">' + escapeHtml(p.deskripsi) + '</div></div></div>';
  }
  if (!rows) {
    rows = '<div class="rt-modal-row" style="justify-content:center;"><i class="fas fa-user-tie"></i><div class="val" style="color:#64748b;">Belum ada informasi tambahan.</div></div>';
  }
  meta.innerHTML = rows;

  if (p.no_hp) {
    var wa = String(p.no_hp).replace(/[^0-9]/g, '').replace(/^0/, '62');
    waSlot.innerHTML = '<a class="rt-modal-wa-btn" href="https://wa.me/' + wa + '" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i> Hubungi via WhatsApp</a>';
  } else {
    waSlot.innerHTML = '';
  }

  modal.classList.add('is-open');
  document.body.style.overflow = 'hidden';
}

function closeStrukturModal() {
  var modal = document.getElementById('strukturModal');
  modal.classList.remove('is-open');
  document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeStrukturModal();
});

function escapeHtml(s) {
  if (s == null) return '';
  return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}
</script>
</div>
