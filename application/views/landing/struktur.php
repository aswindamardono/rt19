<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#064e3b">
  <meta name="description" content="Struktur Organisasi Pengurus RT-19 Orchid Regency Sidoarjo">
  <title>Struktur Organisasi — RT-19 Orchid Regency</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>?v=<?= @filemtime(FCPATH.'assets/css/custom.css') ?: time() ?>">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Inter', 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
      background: linear-gradient(135deg, #ecfdf5 0%, #f0fdfa 30%, #f8fafc 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ===== Navbar ===== */
    .str-nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.75rem 1.5rem;
      background: rgba(255,255,255,0.92);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: 0 1px 3px rgba(0,0,0,0.06);
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 1px solid rgba(16,185,129,0.08);
    }
    .str-nav-left {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .str-nav-back {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      color: var(--emerald-700);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.88rem;
      padding: 0.4rem 0.8rem;
      border-radius: 8px;
      transition: all 0.2s ease;
    }
    .str-nav-back:hover {
      background: var(--emerald-50);
      color: var(--emerald-800);
      text-decoration: none;
    }
    .str-nav-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.05rem;
      color: var(--emerald-900);
    }
    .str-nav-actions {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .str-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      padding: 0.45rem 0.85rem;
      border-radius: 8px;
      font-size: 0.82rem;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
    }
    .str-btn-outline {
      background: white;
      color: var(--emerald-700);
      border: 1.5px solid var(--emerald-200);
    }
    .str-btn-outline:hover {
      background: var(--emerald-50);
      border-color: var(--emerald-400);
      color: var(--emerald-800);
      text-decoration: none;
    }

    /* ===== Header ===== */
    .str-header {
      text-align: center;
      padding: 2rem 1.5rem 1rem;
    }
    .str-header h1 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.8rem;
      color: var(--emerald-900);
      margin: 0 0 0.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.6rem;
    }
    .str-header h1 i { color: var(--emerald-600); font-size: 1.4rem; }
    .str-header p {
      color: #64748b;
      font-size: 0.95rem;
      max-width: 500px;
      margin: 0 auto;
    }
    @media (min-width: 768px) {
      .str-header h1 { font-size: 2.2rem; }
      .str-header { padding: 2.5rem 1.5rem 1.5rem; }
    }

    /* ===== Chart Area ===== */
    .str-chart-area {
      flex: 1;
      overflow-x: auto;
      overflow-y: auto;
      padding: 1rem 2rem 2rem;
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }

    /* ===== Pure CSS Org Tree ===== */
    .org-tree, .org-tree ul, .org-tree li {
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .org-tree {
      display: table;
      margin: 0 auto;
    }
    .org-tree ul {
      display: table;
      padding-top: 30px;
      position: relative;
    }
    .org-tree li {
      display: table-cell;
      vertical-align: top;
      text-align: center;
      padding: 0 10px;
      position: relative;
    }

    /* Connector lines */
    .org-tree li::before,
    .org-tree li::after {
      content: '';
      position: absolute;
      top: 0;
      height: 30px;
      width: 50%;
      border-top: 2.5px solid var(--emerald-300);
    }
    .org-tree li::before {
      right: 50%;
      border-right: 2.5px solid var(--emerald-300);
    }
    .org-tree li::after {
      left: 50%;
    }
    .org-tree li:first-child::before { border: 0 none; }
    .org-tree li:last-child::after   { border: 0 none; }
    .org-tree li:only-child::before,
    .org-tree li:only-child::after   { display: none; }

    /* Vertical line from parent to children */
    .org-tree ul::before {
      content: '';
      display: block;
      position: absolute;
      top: 0;
      left: 50%;
      width: 2.5px;
      height: 30px;
      margin-left: -1.25px;
      background: var(--emerald-300);
    }

    /* Root node: no lines above */
    .org-tree > li::before,
    .org-tree > li::after { display: none; }

    /* ===== Animations ===== */
    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(25px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    /* ===== Card Node ===== */
    .org-node {
      display: inline-block;
      background: white;
      border-radius: 16px;
      padding: 1.25rem 1rem 1rem;
      text-align: center;
      box-shadow: 0 4px 16px rgba(0,0,0,0.06);
      border: 1.5px solid rgba(16,185,129,0.1);
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      position: relative;
      min-width: 140px;
      max-width: 180px;
      margin: 0 auto 20px;
      animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
      opacity: 0; /* Ensures it's invisible before animation starts */
    }
    .org-node::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 4px;
      background: var(--gradient-primary);
      border-radius: 16px 16px 0 0;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .org-node:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 32px rgba(16,185,129,0.15);
      border-color: var(--emerald-400);
    }
    .org-node:hover::before { opacity: 1; }

    /* Root node special style */
    .org-node.org-root {
      background: linear-gradient(135deg, var(--emerald-600), var(--emerald-700));
      border-color: var(--emerald-700);
      min-width: 170px;
      box-shadow: 0 8px 24px rgba(5, 150, 105, 0.25);
    }
    .org-node.org-root::before { display: none; }
    .org-node.org-root:hover {
      box-shadow: 0 16px 40px rgba(5, 150, 105, 0.3);
    }
    .org-node.org-root .org-node-jabatan,
    .org-node.org-root .org-node-nama { color: white; }
    .org-node.org-root .org-node-nama-empty { color: rgba(255,255,255,0.55); }

    /* Photo / Initial */
    .org-node-photo, .org-node-initial {
      width: 64px; height: 64px;
      border-radius: 50%;
      margin: 0 auto 0.6rem;
      display: flex;
      align-items: center;
      justify-content: center;
      object-fit: cover;
      border: 3px solid white;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    .org-node-initial {
      background: var(--gradient-primary);
      color: white;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.5rem;
    }
    .org-node.org-root .org-node-initial {
      background: rgba(255,255,255,0.2);
      border-color: rgba(255,255,255,0.5);
    }

    /* Text */
    .org-node-jabatan {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.72rem;
      font-weight: 700;
      color: var(--emerald-700);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin: 0 0 0.25rem;
      line-height: 1.3;
    }
    .org-node-nama {
      font-size: 0.88rem;
      font-weight: 600;
      color: var(--emerald-900);
      margin: 0;
      line-height: 1.3;
    }
    .org-node-nama-empty {
      font-size: 0.8rem;
      font-style: italic;
      color: #94a3b8;
      font-weight: 400;
    }

    /* ===== Modal ===== */
    .rt-modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(15,23,42,0.55);
      backdrop-filter: blur(6px);
      -webkit-backdrop-filter: blur(6px);
      z-index: 9000;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.25s ease;
    }
    .rt-modal-overlay.is-open { opacity: 1; pointer-events: auto; }
    .rt-modal-card {
      background: white;
      border-radius: 20px;
      width: 90%;
      max-width: 420px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.2);
      position: relative;
      overflow: hidden;
      transform: translateY(30px) scale(0.95);
      transition: transform 0.3s ease;
    }
    .rt-modal-overlay.is-open .rt-modal-card {
      transform: translateY(0) scale(1);
    }
    .rt-modal-close {
      position: absolute;
      top: 12px; right: 12px;
      background: rgba(255,255,255,0.9);
      border: none;
      border-radius: 50%;
      width: 36px; height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      color: #64748b;
      cursor: pointer;
      z-index: 10;
      transition: all 0.2s ease;
    }
    .rt-modal-close:hover { background: white; color: #1e293b; }
    .rt-modal-head {
      background: var(--gradient-hero);
      padding: 1.5rem 1.5rem 1rem;
      text-align: center;
    }
    .rt-modal-jabatan {
      color: rgba(255,255,255,0.85);
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin: 0;
    }
    .rt-modal-photo {
      width: 90px; height: 90px;
      border-radius: 50%;
      margin: -45px auto 0;
      display: flex;
      align-items: center;
      justify-content: center;
      object-fit: cover;
      border: 4px solid white;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
      position: relative;
      z-index: 2;
    }
    .rt-modal-photo.initial {
      background: var(--gradient-primary);
      color: white;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 2.2rem;
    }
    .rt-modal-body {
      padding: 1rem 1.5rem 1.5rem;
      text-align: center;
    }
    .rt-modal-body h3 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700;
      color: var(--emerald-900);
      font-size: 1.15rem;
      margin: 0.5rem 0 0.75rem;
    }
    .rt-modal-body h3 .muted {
      color: #94a3b8;
      font-style: italic;
      font-weight: 400;
    }
    .rt-modal-meta {
      text-align: left;
    }
    .rt-modal-row {
      display: flex;
      align-items: center;
      gap: 0.65rem;
      padding: 0.6rem 0;
      border-bottom: 1px solid #f1f5f9;
    }
    .rt-modal-row:last-child { border-bottom: none; }
    .rt-modal-row i {
      color: var(--emerald-500);
      font-size: 1rem;
      flex-shrink: 0;
      width: 20px;
      text-align: center;
    }
    .rt-modal-row .lbl {
      font-size: 0.68rem;
      color: #94a3b8;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.04em;
    }
    .rt-modal-row .val {
      font-size: 0.88rem;
      color: var(--emerald-900);
      font-weight: 600;
    }
    .rt-modal-wa-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      margin-top: 1rem;
      padding: 0.6rem 1.3rem;
      background: #25d366;
      color: white;
      border-radius: 999px;
      font-weight: 600;
      font-size: 0.88rem;
      text-decoration: none;
      transition: all 0.2s ease;
    }
    .rt-modal-wa-btn:hover {
      background: #1fb855;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(37,211,102,0.3);
      color: white;
      text-decoration: none;
    }

    /* ===== Footer ===== */
    .str-footer {
      text-align: center;
      padding: 1.25rem;
      color: #64748b;
      font-size: 0.82rem;
      border-top: 1px solid rgba(16,185,129,0.08);
      background: rgba(255,255,255,0.6);
    }

    /* ===== Responsive (Mobile Vertical Tree) ===== */
    @media (max-width: 768px) {
      .str-header h1 { font-size: 1.4rem; }
      .str-header p { font-size: 0.85rem; }
      .str-nav-title { display: none; }
      .str-chart-area { padding: 0.5rem 1rem 1.5rem; justify-content: flex-start; }

      /* Convert tree to vertical list */
      .org-tree, .org-tree ul, .org-tree li {
        display: block;
        position: relative;
      }
      .org-tree { margin: 0; padding-left: 0; }
      .org-tree ul {
        padding-top: 0;
        padding-left: 24px;
        margin-top: -5px;
      }
      .org-tree li {
        text-align: left;
        padding: 5px 0 0 24px;
      }

      /* Hide old horizontal/vertical table lines */
      .org-tree li::before,
      .org-tree li::after,
      .org-tree ul::before {
        display: none !important;
      }

      /* Draw vertical line connecting children */
      .org-tree ul::after {
        content: '';
        position: absolute;
        top: -15px;
        bottom: 40px; /* Stop before the last node's L-shape goes too far down */
        left: 0;
        width: 2.5px;
        background: var(--emerald-300);
      }

      /* L-shape horizontal line for each child */
      .org-tree ul li::before {
        content: '';
        display: block !important;
        position: absolute;
        top: 45px; /* Aligns with middle of child card approx */
        left: 0;
        width: 24px;
        height: 2.5px;
        background: var(--emerald-300);
        border: none;
      }

      /* First child of root shouldn't have top lines if it's the root */
      .org-tree > li { padding-left: 0; }
      .org-tree > li::before { display: none !important; }

      /* Make card horizontal on mobile */
      .org-node {
        display: flex;
        align-items: center;
        text-align: left;
        margin: 0 0 10px 0;
        padding: 0.75rem 1rem;
        min-width: 0;
        max-width: 100%;
        width: 100%;
        gap: 1rem;
      }
      .org-node.org-root {
        min-width: 0;
      }
      .org-node-photo, .org-node-initial {
        margin: 0;
        width: 48px; height: 48px;
        font-size: 1.2rem;
        flex-shrink: 0;
      }
      .org-node-content {
        flex: 1;
      }
      .org-node-jabatan { font-size: 0.65rem; margin-bottom: 0.15rem; }
      .org-node-nama { font-size: 0.82rem; }
    }
  </style>
</head>
<body>

<!-- ===== Navbar ===== -->
<nav class="str-nav">
  <div class="str-nav-left">
    <a href="<?= base_url() ?>" class="str-nav-back">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <span class="str-nav-title">RT-19 Orchid Regency</span>
  </div>
  <div class="str-nav-actions">
    <a href="<?= base_url('auth') ?>" class="str-btn str-btn-outline">
      <i class="fas fa-sign-in-alt"></i> Login
    </a>
  </div>
</nav>

<!-- ===== Header ===== -->
<div class="str-header">
  <h1><i class="fas fa-sitemap"></i> Struktur Organisasi</h1>
  <p>Susunan pengurus RT-19 Orchid Regency Sidoarjo — klik kartu untuk melihat detail pengurus</p>
</div>

<!-- ===== Chart ===== -->
<div class="str-chart-area">
<?php if (!empty($struktur)):
  // Build tree from flat array
  $nodes_by_id = [];
  $children_map = [];
  foreach ($struktur as $s) {
    $nodes_by_id[$s->id] = $s;
    $pid = $s->parent_id ?: 0;
    if (!isset($children_map[$pid])) $children_map[$pid] = [];
    $children_map[$pid][] = $s->id;
  }

  // Find roots
  $roots = [];
  foreach ($struktur as $s) {
    $pid = $s->parent_id ?: 0;
    if ($pid == 0 || !isset($nodes_by_id[$pid])) {
      $roots[] = $s->id;
    }
  }

  // Recursive render
  function render_org_node_full($id, $nodes_by_id, $children_map, $is_root = false, &$delay_counter = 0) {
    $s = $nodes_by_id[$id];
    $foto_path = !empty($s->foto) ? FCPATH.'uploads/struktur/'.$s->foto : null;
    $has_foto  = $foto_path && is_file($foto_path);
    $foto_url  = $has_foto ? base_url('uploads/struktur/'.$s->foto) : '';
    $initial   = strtoupper(mb_substr($s->nama ?: $s->jabatan, 0, 1));
    $nama_display = !empty($s->nama) ? htmlspecialchars($s->nama) : '<span class="org-node-nama-empty">(belum diisi)</span>';
    $root_class = $is_root ? ' org-root' : '';
    $kids = isset($children_map[$id]) ? $children_map[$id] : [];

    // Calculate animation delay for cascade effect (0.1s per node)
    $delay = $delay_counter * 0.08;
    $delay_counter++;

    echo '<li>';
    echo '<div class="org-node'.$root_class.'" style="animation-delay: '.$delay.'s;" onclick="openStrukturModal({';
    echo "jabatan:'".addslashes($s->jabatan)."',";
    echo "nama:'".addslashes($s->nama ?: '')."',";
    echo "no_hp:'".addslashes($s->no_hp ?: '')."',";
    echo "deskripsi:'".addslashes($s->deskripsi ?: '')."',";
    echo "foto:'".$foto_url."',";
    echo "initial:'".$initial."'";
    echo '})">';

    if ($has_foto) {
      echo '<img src="'.$foto_url.'" alt="'.htmlspecialchars($s->nama ?: $s->jabatan).'" class="org-node-photo">';
    } else {
      echo '<div class="org-node-initial">'.$initial.'</div>';
    }
    echo '<div class="org-node-content">';
    echo '<p class="org-node-jabatan">'.htmlspecialchars($s->jabatan).'</p>';
    echo '<p class="org-node-nama">'.$nama_display.'</p>';
    echo '</div>';
    echo '</div>';

    if (!empty($kids)) {
      echo '<ul>';
      foreach ($kids as $child_id) {
        render_org_node_full($child_id, $nodes_by_id, $children_map, false, $delay_counter);
      }
      echo '</ul>';
    }
    echo '</li>';
  }
?>
  <ul class="org-tree">
    <?php 
    $global_delay = 0;
    foreach ($roots as $root_id) {
      render_org_node_full($root_id, $nodes_by_id, $children_map, true, $global_delay);
    } 
    ?>
  </ul>
<?php else: ?>
  <div style="text-align:center; padding:4rem 2rem; color:#94a3b8;">
    <i class="fas fa-sitemap" style="font-size:4rem; margin-bottom:1rem; opacity:0.3; display:block;"></i>
    <h3 style="color:#64748b; font-weight:600; margin-bottom:0.5rem;">Struktur belum tersedia</h3>
    <p style="font-size:0.9rem;">Pengurus belum mempublikasikan struktur organisasi.</p>
  </div>
<?php endif; ?>
</div>

<!-- ===== Footer ===== -->
<footer class="str-footer">
  &copy; <?= date('Y') ?> <strong>RT-19 Orchid Regency</strong> Sidoarjo &middot; Sistem Informasi Manajemen RT
</footer>

<!-- ===== Modal ===== -->
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
      rows += '<div class="rt-modal-row">' +
              '<i class="fas fa-phone"></i>' +
              '<div><div class="lbl">Kontak</div>' +
              '<div class="val">' + escapeHtml(p.no_hp) + '</div></div>' +
              '</div>';
    }
    if (p.deskripsi) {
      rows += '<div class="rt-modal-row" style="align-items:flex-start;">' +
              '<i class="fas fa-info-circle" style="margin-top:2px;"></i>' +
              '<div><div class="lbl">Deskripsi</div>' +
              '<div class="val" style="font-weight:500; white-space:pre-line;">' +
              escapeHtml(p.deskripsi) + '</div></div>' +
              '</div>';
    }
    if (!rows) {
      rows = '<div class="rt-modal-row" style="justify-content:center;">' +
             '<i class="fas fa-user-tie"></i>' +
             '<div class="val" style="color:#64748b;">Belum ada informasi tambahan.</div>' +
             '</div>';
    }
    meta.innerHTML = rows;

    if (p.no_hp) {
      var wa = String(p.no_hp).replace(/[^0-9]/g, '').replace(/^0/, '62');
      waSlot.innerHTML =
        '<a class="rt-modal-wa-btn" href="https://wa.me/' + wa + '" target="_blank" rel="noopener">' +
        '<i class="fab fa-whatsapp"></i> Hubungi via WhatsApp</a>';
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

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeStrukturModal();
  });

  function escapeHtml(s) {
    if (s == null) return '';
    return String(s)
      .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;').replace(/'/g, '&#039;');
  }
</script>
</body>
</html>
