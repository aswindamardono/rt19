<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#064e3b">
  <meta name="description" content="RT-19 Orchid Regency Sidoarjo — Transparansi keuangan & informasi warga.">
  <title>RT-19 Orchid Regency — Beranda</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>?v=<?= @filemtime(FCPATH.'assets/css/custom.css') ?: time() ?>">

  <style>
    /* ====== Landing-specific (paired with custom.css emerald theme) ====== */
    .landing-body {
      background: #f8fafc;
      min-height: 100vh;
      animation: fadeIn 0.5s ease;
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    .public-nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.85rem 1.25rem;
      background: rgba(255,255,255,0.92);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: var(--shadow-sm);
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 1px solid rgba(16,185,129,0.08);
    }
    .public-nav-logo {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1rem;
      color: var(--emerald-900);
      text-decoration: none;
    }
    .public-nav-logo:hover { color: var(--emerald-900); text-decoration: none; }
    .public-nav-logo img {
      width: 32px; height: 32px;
      border-radius: 8px;
      object-fit: cover;
    }
    .public-nav-cta {
      display: inline-flex;
      align-items: center;
      gap: 0.45rem;
      background: var(--gradient-primary);
      color: white;
      font-weight: 600;
      padding: 0.55rem 1.1rem;
      border-radius: var(--radius-sm);
      text-decoration: none;
      font-size: 0.88rem;
      transition: all var(--transition-normal);
      border: none;
    }
    .public-nav-cta:hover {
      color: white;
      text-decoration: none;
      transform: translateY(-1px);
      box-shadow: var(--shadow-glow);
    }

    /* ===== Hero ===== */
    .public-hero {
      background: var(--gradient-hero);
      padding: 3.5rem 1.5rem 5rem;
      text-align: center;
      color: white;
      position: relative;
      overflow: hidden;
    }
    .public-hero::before {
      content: '';
      position: absolute;
      width: 360px; height: 360px;
      background: radial-gradient(circle, rgba(255,255,255,0.1), transparent 70%);
      top: -120px; left: -120px;
      border-radius: 50%;
      pointer-events: none;
    }
    .public-hero::after {
      content: '';
      position: absolute;
      width: 260px; height: 260px;
      background: radial-gradient(circle, rgba(20,184,166,0.18), transparent 70%);
      bottom: -80px; right: -80px;
      border-radius: 50%;
      pointer-events: none;
    }
    .public-hero-content {
      position: relative;
      z-index: 1;
      max-width: 720px;
      margin: 0 auto;
    }
    .public-hero h1 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.7rem;
      font-weight: 800;
      margin: 0 0 0.85rem;
      line-height: 1.25;
      color: white;
    }
    .public-hero p {
      font-size: 0.95rem;
      color: rgba(255,255,255,0.85);
      line-height: 1.65;
      margin: 0 auto 1.5rem;
      max-width: 580px;
    }
    .hero-pill {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      background: rgba(255,255,255,0.14);
      border: 1px solid rgba(255,255,255,0.22);
      padding: 0.35rem 0.9rem;
      border-radius: 999px;
      font-size: 0.78rem;
      font-weight: 600;
      color: rgba(255,255,255,0.95);
      margin-bottom: 1rem;
      backdrop-filter: blur(10px);
    }
    @media (min-width: 640px) {
      .public-hero { padding: 4.5rem 1.5rem 6rem; }
      .public-hero h1 { font-size: 2.3rem; }
      .public-hero p  { font-size: 1.02rem; }
    }

    /* ===== Public content shell ===== */
    .public-content {
      max-width: 1080px;
      margin: -3rem auto 0;
      padding: 0 1.25rem;
      position: relative;
      z-index: 10;
    }

    /* Section title */
    .public-section-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      color: var(--emerald-900);
      font-size: 1.25rem;
      margin: 2.5rem 0 1.1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      text-align: center;
    }
    .public-section-title i { color: var(--emerald-600); }
    .public-section-sub {
      text-align: center;
      color: #64748b;
      font-size: 0.9rem;
      margin-top: -0.6rem;
      margin-bottom: 1.5rem;
    }

    /* Stat grid */
    .public-stat-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }
    @media (min-width: 640px) {
      .public-stat-grid { grid-template-columns: repeat(3, 1fr); }
    }

    .public-stat {
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,0.65);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-lg);
      padding: 1.4rem 1.25rem;
      position: relative;
      overflow: hidden;
      text-align: center;
      transition: transform var(--transition-normal), box-shadow var(--transition-normal);
    }
    .public-stat:hover { transform: translateY(-3px); box-shadow: var(--shadow-xl); }
    .public-stat::after {
      content: '';
      position: absolute;
      top: -40px; right: -40px;
      width: 130px; height: 130px;
      border-radius: 50%;
      background: rgba(16,185,129,0.07);
      pointer-events: none;
    }
    .public-stat-icon {
      width: 48px; height: 48px;
      border-radius: var(--radius-md);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      margin-bottom: 0.85rem;
    }
    .public-stat-icon.balance  { background: #d1fae5; color: var(--emerald-700); }
    .public-stat-icon.income   { background: #dcfce7; color: #059669; }
    .public-stat-icon.expense  { background: #fecaca; color: #dc2626; }

    .public-stat-label {
      font-size: 0.78rem;
      font-weight: 600;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      margin-bottom: 0.4rem;
    }
    .public-stat-value {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.55rem;
      line-height: 1.2;
    }
    .public-stat-value.balance  { color: var(--emerald-800); }
    .public-stat-value.income   { color: #059669; }
    .public-stat-value.expense  { color: #dc2626; }
    .public-stat-period {
      font-size: 0.72rem;
      color: #94a3b8;
      margin-top: 0.4rem;
    }

    /* ===== Announcements ===== */
    .public-ann-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }
    @media (min-width: 720px) {
      .public-ann-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (min-width: 1024px) {
      .public-ann-grid { grid-template-columns: repeat(3, 1fr); }
    }

    .ann-card {
      background: white;
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-md);
      border-left: 4px solid var(--emerald-500);
      overflow: hidden;
      transition: transform var(--transition-normal), box-shadow var(--transition-normal);
      display: flex;
      flex-direction: column;
    }
    .ann-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }
    .ann-card-img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      background: linear-gradient(135deg, var(--emerald-100), var(--emerald-200));
    }
    .ann-card-body { padding: 1.1rem 1.25rem 1.25rem; flex: 1; display: flex; flex-direction: column; }
    .ann-card-date {
      font-size: 0.72rem;
      color: #94a3b8;
      margin-bottom: 0.4rem;
      display: flex;
      align-items: center;
      gap: 0.35rem;
    }
    .ann-card-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700;
      color: var(--emerald-900);
      font-size: 1rem;
      margin: 0 0 0.5rem;
      line-height: 1.35;
    }
    .ann-card-body p {
      color: #475569;
      font-size: 0.88rem;
      line-height: 1.6;
      margin: 0 0 0.75rem;
      flex: 1;
      display: -webkit-box;
      -webkit-line-clamp: 4;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .empty-state {
      text-align: center;
      padding: 3rem 1.5rem;
      color: #94a3b8;
      grid-column: 1 / -1;
    }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.4; }
    .empty-state h3 { font-size: 1rem; font-weight: 600; color: #64748b; margin-bottom: 0.4rem; }
    .empty-state p { font-size: 0.88rem; margin: 0; }

    /* ===== Bagan Struktur Organisasi (pure CSS org chart) ===== */
    .orgchart-wrapper {
      overflow-x: auto;
      padding: 2rem 1rem;
      background: linear-gradient(180deg, #ecfdf5 0%, #ffffff 100%);
      border-radius: var(--radius-xl);
      box-shadow: var(--shadow-lg);
      border: 1px solid rgba(16,185,129,0.12);
    }

    /* Reset list styles */
    .org-tree, .org-tree ul, .org-tree li {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    /* Tree layout */
    .org-tree {
      display: flex;
      justify-content: center;
      padding-top: 20px;
    }
    .org-tree ul {
      display: flex;
      justify-content: center;
      padding-top: 30px;
      position: relative;
    }
    .org-tree li {
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      padding: 0 8px;
    }

    /* Vertical line from parent down */
    .org-tree li::before {
      content: '';
      position: absolute;
      top: 0;
      width: 2px;
      height: 30px;
      background: linear-gradient(180deg, var(--emerald-400), var(--emerald-300));
    }

    /* Horizontal line across siblings */
    .org-tree ul::before {
      content: '';
      position: absolute;
      top: 0;
      height: 2px;
      background: var(--emerald-300);
      left: calc(50% - 50%);
      right: calc(50% - 50%);
    }
    .org-tree > li::before { display: none; } /* root has no line up */

    /* Horizontal connector: from first child center to last child center */
    .org-tree ul {
      position: relative;
    }
    .org-tree li:not(:only-child)::after {
      content: '';
      position: absolute;
      top: 0;
      height: 2px;
      background: var(--emerald-300);
    }
    /* Left half for non-first children */
    .org-tree li:not(:first-child)::after {
      left: 0;
      right: 50%;
    }
    /* Right half for non-last children */
    .org-tree li:not(:last-child)::before {
      content: '';
    }

    /* Simplify: use a single horizontal bar on the ul */
    .org-tree ul::before {
      content: '';
      position: absolute;
      top: 0;
      left: 50%;
      right: 50%;
      height: 2px;
      background: var(--emerald-300);
    }

    /* Override: proper connector lines using border approach */
    .org-tree, .org-tree ul, .org-tree li {
      list-style: none; margin: 0; padding: 0;
    }
    .org-tree {
      display: table;
      margin: 0 auto;
      padding-top: 0;
    }
    .org-tree ul { display: table; padding-top: 30px; }
    .org-tree li {
      display: table-cell;
      vertical-align: top;
      text-align: center;
      padding: 0 6px;
      position: relative;
    }

    /* Vertical line down from card */
    .org-tree li::before,
    .org-tree li::after {
      content: '';
      position: absolute;
      top: 0;
      height: 30px;
      width: 50%;
      border-top: 2px solid var(--emerald-300);
    }
    .org-tree li::before { right: 50%; border-right: 2px solid var(--emerald-300); }
    .org-tree li::after  { left: 50%; }

    .org-tree li:first-child::before { border: 0 none; }
    .org-tree li:last-child::after   { border: 0 none; }
    .org-tree li:only-child::before,
    .org-tree li:only-child::after   { display: none; }

    /* Vertical line from parent to children row */
    .org-tree ul::before {
      content: '';
      display: block;
      position: absolute;
      top: 0;
      left: 50%;
      width: 2px;
      height: 30px;
      margin-left: -1px;
      background: var(--emerald-300);
    }

    /* Root node: no lines above */
    .org-tree > li::before,
    .org-tree > li::after { display: none; }

    /* The card node */
    .org-node {
      display: inline-block;
      background: white;
      border-radius: var(--radius-lg);
      padding: 1rem 0.85rem 0.85rem;
      text-align: center;
      box-shadow: 0 2px 12px rgba(0,0,0,0.07);
      border: 1.5px solid rgba(16,185,129,0.12);
      cursor: pointer;
      transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
      position: relative;
      min-width: 120px;
      max-width: 160px;
      margin: 0 auto 20px;
    }
    .org-node:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 24px rgba(16,185,129,0.18);
      border-color: var(--emerald-400);
    }
    .org-node.org-root {
      background: linear-gradient(135deg, var(--emerald-600), var(--emerald-700));
      border-color: var(--emerald-700);
      min-width: 150px;
    }
    .org-node.org-root .org-node-jabatan,
    .org-node.org-root .org-node-nama { color: white; }
    .org-node.org-root .org-node-nama-empty { color: rgba(255,255,255,0.6); }

    .org-node-photo, .org-node-initial {
      width: 56px; height: 56px;
      border-radius: 50%;
      margin: 0 auto 0.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      object-fit: cover;
      border: 2.5px solid white;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .org-node-initial {
      background: var(--gradient-primary);
      color: white;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.3rem;
    }
    .org-node.org-root .org-node-initial {
      background: rgba(255,255,255,0.2);
      border-color: rgba(255,255,255,0.4);
    }
    .org-node-jabatan {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.68rem;
      font-weight: 700;
      color: var(--emerald-700);
      text-transform: uppercase;
      letter-spacing: 0.04em;
      margin: 0 0 0.2rem;
      line-height: 1.25;
    }
    .org-node-nama {
      font-size: 0.82rem;
      font-weight: 600;
      color: var(--emerald-900);
      margin: 0;
      line-height: 1.3;
    }
    .org-node-nama-empty {
      font-size: 0.78rem;
      font-style: italic;
      color: #94a3b8;
      font-weight: 400;
    }

    /* Responsive: scroll horizontally on mobile */
    @media (max-width: 768px) {
      .orgchart-wrapper { padding: 1rem 0.5rem; }
      .org-node { min-width: 100px; max-width: 130px; padding: 0.75rem 0.5rem 0.65rem; }
      .org-node-photo, .org-node-initial { width: 44px; height: 44px; font-size: 1rem; }
      .org-node-jabatan { font-size: 0.6rem; }
      .org-node-nama { font-size: 0.72rem; }
    }

    /* ===== Modal ===== */
    .rt-modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.55);
      backdrop-filter: blur(6px);
      -webkit-backdrop-filter: blur(6px);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 5000;
      padding: 1rem;
      animation: rtFadeIn 0.2s ease;
    }
    .rt-modal-overlay.is-open { display: flex; }
    @keyframes rtFadeIn { from { opacity: 0; } to { opacity: 1; } }

    .rt-modal-card {
      background: white;
      width: 100%;
      max-width: 460px;
      border-radius: var(--radius-xl);
      overflow: hidden;
      box-shadow: var(--shadow-xl);
      animation: rtSlideUp 0.28s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
    }
    @keyframes rtSlideUp {
      from { opacity: 0; transform: translateY(24px) scale(0.96); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    .rt-modal-head {
      background: var(--gradient-hero);
      padding: 2rem 1.5rem 3.5rem;
      text-align: center;
      color: white;
      position: relative;
      overflow: hidden;
    }
    .rt-modal-head::before {
      content: '';
      position: absolute;
      width: 220px; height: 220px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255,255,255,0.15), transparent 70%);
      top: -80px; right: -60px;
    }
    .rt-modal-close {
      position: absolute;
      top: 0.75rem; right: 0.75rem;
      background: rgba(255,255,255,0.18);
      border: 1px solid rgba(255,255,255,0.25);
      color: white;
      width: 36px; height: 36px;
      border-radius: 50%;
      cursor: pointer;
      font-size: 1rem;
      display: flex; align-items: center; justify-content: center;
      transition: all var(--transition-fast);
      z-index: 2;
    }
    .rt-modal-close:hover { background: rgba(255,255,255,0.3); transform: rotate(90deg); }
    .rt-modal-jabatan {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.05rem;
      font-weight: 800;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: rgba(255,255,255,0.92);
      margin: 0;
      position: relative;
      z-index: 1;
    }
    .rt-modal-photo {
      width: 110px; height: 110px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid white;
      box-shadow: var(--shadow-lg);
      margin: -52px auto 0.85rem;
      display: block;
      background: var(--gradient-primary);
      position: relative;
      z-index: 2;
    }
    .rt-modal-photo.initial {
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 2.5rem;
      text-transform: uppercase;
    }
    .rt-modal-body {
      padding: 0 1.5rem 1.5rem;
      text-align: center;
    }
    .rt-modal-body h3 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.35rem;
      font-weight: 800;
      color: var(--emerald-900);
      margin: 0 0 1rem;
    }
    .rt-modal-body .muted { color: #94a3b8; font-style: italic; font-weight: 500; font-size: 1rem; }
    .rt-modal-meta {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      margin-top: 0.5rem;
      text-align: left;
    }
    .rt-modal-row {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.7rem 0.9rem;
      background: var(--emerald-50);
      border-radius: var(--radius-sm);
      font-size: 0.88rem;
    }
    .rt-modal-row i {
      width: 28px; height: 28px;
      border-radius: 50%;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--emerald-700);
      flex-shrink: 0;
    }
    .rt-modal-row .lbl { color: #64748b; font-size: 0.78rem; }
    .rt-modal-row .val { color: var(--emerald-900); font-weight: 600; }
    .rt-modal-row a { color: var(--emerald-700); text-decoration: none; }
    .rt-modal-row a:hover { text-decoration: underline; }
    .rt-modal-wa-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: linear-gradient(135deg, #25d366, #128c7e);
      color: white;
      padding: 0.65rem 1.25rem;
      border-radius: var(--radius-sm);
      font-weight: 600;
      font-size: 0.9rem;
      margin-top: 1rem;
      text-decoration: none;
      transition: all var(--transition-normal);
    }
    .rt-modal-wa-btn:hover {
      color: white;
      text-decoration: none;
      transform: translateY(-1px);
      box-shadow: 0 0 15px rgba(37,211,102,0.4);
    }

    /* ===== CTA ===== */
    .public-cta {
      margin: 3rem auto 1rem;
      max-width: 720px;
      background: var(--gradient-primary);
      color: white;
      border-radius: var(--radius-xl);
      padding: 2rem 1.75rem;
      text-align: center;
      position: relative;
      overflow: hidden;
      box-shadow: var(--shadow-xl);
    }
    .public-cta::before {
      content: '';
      position: absolute;
      width: 240px; height: 240px;
      background: radial-gradient(circle, rgba(255,255,255,0.18), transparent 70%);
      top: -60px; right: -60px;
      border-radius: 50%;
      pointer-events: none;
    }
    .public-cta h3 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.3rem;
      font-weight: 800;
      margin: 0 0 0.4rem;
      color: white;
      position: relative;
    }
    .public-cta p {
      font-size: 0.92rem;
      color: rgba(255,255,255,0.9);
      margin: 0 0 1.25rem;
      position: relative;
    }
    .public-cta-btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: white;
      color: var(--emerald-700);
      font-weight: 700;
      padding: 0.75rem 1.6rem;
      border-radius: var(--radius-sm);
      text-decoration: none;
      transition: all var(--transition-normal);
      position: relative;
    }
    .public-cta-btn:hover {
      color: var(--emerald-700);
      text-decoration: none;
      transform: translateY(-1px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    /* ===== Footer ===== */
    .public-footer {
      text-align: center;
      padding: 2.5rem 1.5rem;
      color: #94a3b8;
      font-size: 0.82rem;
      margin-top: 2rem;
      border-top: 1px solid #e2e8f0;
    }
    .public-footer strong { color: var(--emerald-800); }
    .public-nav {
      display: flex; justify-content: space-between; align-items: center;
      padding: 1rem 5%; background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px); position: sticky; top: 0; z-index: 1000;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .nav-container { display: flex; justify-content: space-between; align-items: center; width: 100%; }
    .nav-links { list-style: none; display: flex; align-items: center; gap: 1.5rem; margin: 0; padding: 0; }
    .nav-links a { text-decoration: none; color: var(--emerald-800); font-weight: 600; font-size: 0.95rem; transition: color 0.3s; }
    .nav-links a:hover { color: var(--emerald-600); }
    
    @media (max-width: 992px) {
      .public-nav { flex-direction: column; padding: 1rem; }
      .mobile-menu-btn { display: block !important; }
      .nav-links { display: none; flex-direction: column; width: 100%; gap: 1rem; padding-top: 1rem; }
      .nav-links.active { display: flex; }
      .nav-links li { width: 100%; text-align: center; }
      .public-nav-cta { display: inline-block; width: auto; }
      .nav-container { width: 100%; }
    }
  </style>
</head>
<body class="landing-body">

<!-- ============================================================
     NAVBAR
     ============================================================ -->
<nav class="public-nav">
  <div class="nav-container">
    <a href="<?= base_url() ?>" class="public-nav-logo">
      <img src="<?= base_url('assets/img/logo.png') ?>" alt="RT-19" onerror="this.style.display='none'">
      <span>RT-19 Orchid Regency</span>
    </a>
    <button class="mobile-menu-btn" onclick="toggleNav()" style="background:none;border:none;font-size:1.5rem;color:var(--emerald-800);cursor:pointer;display:none;">
      <i class="fas fa-bars"></i>
    </button>
  </div>
  <ul class="nav-links" id="navLinks">
    <li><a href="#ringkasan-keuangan" onclick="closeNav()">Ringkasan Keuangan</a></li>
    <li><a href="#struktur-organisasi" onclick="closeNav()">Struktur Organisasi</a></li>
    <li><a href="#pengumuman" onclick="closeNav()">Pengumuman</a></li>
    <li><a href="#inventaris-barang" onclick="closeNav()">Inventaris Barang RT</a></li>
    <li>
      <a href="<?= base_url('auth') ?>" class="public-nav-cta">
        <i class="fas fa-sign-in-alt"></i> Login Pengurus
      </a>
    </li>
  </ul>
</nav>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="public-hero">
  <div class="public-hero-content" data-aos="fade-up" data-aos-duration="700">
    <span class="hero-pill">
      <i class="fas fa-leaf"></i> Orchid Regency Sidoarjo
    </span>
    <h1>Transparansi & Kemudahan<br>Untuk Warga RT-19</h1>
    <p>
      Sistem informasi, administrasi, dan transparansi keuangan
      lingkungan RT-19 Orchid Regency Sidoarjo &mdash; agar setiap warga
      bisa memantau kas, iuran, dan informasi terbaru kapan saja.
    </p>
  </div>
</section>

<!-- ============================================================
     CONTENT
     ============================================================ -->
<div class="public-content">

  <h2 class="public-section-title" id="ringkasan-keuangan" data-aos="fade-up">
    <i class="fas fa-chart-pie"></i> Ringkasan Keuangan
  </h2>
  <p class="public-section-sub" data-aos="fade-up" data-aos-delay="50">
    Periode pemasukan &amp; pengeluaran: <strong><?= htmlspecialchars($bulan_label, ENT_QUOTES) ?></strong>
  </p>

  <div class="public-stat-grid">
    <div class="public-stat" data-aos="fade-up" data-aos-delay="100">
      <div class="public-stat-icon balance"><i class="fas fa-wallet"></i></div>
      <div class="public-stat-label">Total Saldo Kas RT</div>
      <div class="public-stat-value balance">
        Rp <?= number_format((float)$total_kas, 0, ',', '.') ?>
      </div>
      <div class="public-stat-period">Akumulasi seluruh transaksi</div>
    </div>

    <div class="public-stat" data-aos="fade-up" data-aos-delay="200">
      <div class="public-stat-icon income"><i class="fas fa-arrow-down"></i></div>
      <div class="public-stat-label">Pemasukan Bulan Ini</div>
      <div class="public-stat-value income">
        Rp <?= number_format((float)$pemasukan_bln, 0, ',', '.') ?>
      </div>
      <div class="public-stat-period"><?= htmlspecialchars($bulan_label, ENT_QUOTES) ?></div>
    </div>

    <div class="public-stat" data-aos="fade-up" data-aos-delay="300">
      <div class="public-stat-icon expense"><i class="fas fa-arrow-up"></i></div>
      <div class="public-stat-label">Pengeluaran Bulan Ini</div>
      <div class="public-stat-value expense">
        Rp <?= number_format((float)$pengeluaran_bln, 0, ',', '.') ?>
      </div>
      <div class="public-stat-period"><?= htmlspecialchars($bulan_label, ENT_QUOTES) ?></div>
    </div>
  </div>

  <h2 class="public-section-title" id="struktur-organisasi" data-aos="fade-up">
    <i class="fas fa-sitemap"></i> Struktur Organisasi
  </h2>
  <p class="public-section-sub" data-aos="fade-up" data-aos-delay="50">
    Susunan pengurus RT-19 &mdash; klik kartu untuk melihat detail
  </p>

  <div class="public-stat" data-aos="fade-up" data-aos-delay="100" style="max-width:600px; margin: 0 auto; text-align:center;">
    <div class="public-stat-icon" style="background:#ecfdf5; color:var(--emerald-600);"><i class="fas fa-sitemap"></i></div>
    <div style="margin-bottom:1rem;">
      <h3 style="font-family:'Plus Jakarta Sans',sans-serif; color:var(--emerald-900); font-weight:800; font-size:1.15rem; margin-bottom:0.4rem;">Bagan Struktur Organisasi</h3>
      <p style="color:#64748b; font-size:0.9rem; margin:0;">Lihat bagan hierarki dan susunan lengkap pengurus RT-19 Orchid Regency.</p>
    </div>
    <a href="<?= base_url('struktur-organisasi') ?>" class="public-nav-cta" style="display:inline-flex; border-radius:99px; padding:0.6rem 1.5rem; font-size:0.95rem;">
      Lihat Bagan Fullscreen <i class="fas fa-external-link-alt" style="font-size:0.8rem;"></i>
    </a>
  </div>

  <h2 class="public-section-title" id="pengumuman" data-aos="fade-up">
    <i class="fas fa-bullhorn"></i> Pengumuman Warga
  </h2>
  <p class="public-section-sub" data-aos="fade-up" data-aos-delay="50">
    Informasi terbaru dari pengurus RT-19
  </p>

  <div class="public-ann-grid">
    <?php if (!empty($pengumuman)): ?>
      <?php foreach ($pengumuman as $i => $p):
        $img_path = !empty($p->gambar) ? FCPATH.'uploads/pengumuman/'.$p->gambar : null;
        $has_img  = $img_path && is_file($img_path);
      ?>
        <article class="ann-card" data-aos="fade-up" data-aos-delay="<?= 100 + $i * 80 ?>">
          <?php if ($has_img): ?>
            <img class="ann-card-img"
                 src="<?= base_url('uploads/pengumuman/'.$p->gambar) ?>"
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
      <div class="empty-state">
        <i class="far fa-bell-slash"></i>
        <h3>Belum ada pengumuman</h3>
        <p>Pengurus RT belum mempublikasikan pengumuman saat ini.</p>
      </div>
    <?php endif; ?>
  </div>

  <h2 class="public-section-title" id="inventaris-barang" data-aos="fade-up">
    <i class="fas fa-boxes"></i> Inventaris Barang RT
  </h2>
  <p class="public-section-sub" data-aos="fade-up" data-aos-delay="50">
    Daftar barang inventaris yang dikelola oleh pengurus RT-19
  </p>
  <div class="public-stat-grid" style="margin-bottom: 3rem;">
    <?php if (!empty($inventaris)): ?>
      <?php foreach ($inventaris as $inv): ?>
        <div class="public-stat" data-aos="fade-up">
          <div class="public-stat-icon" style="background:#f1f5f9; color:var(--emerald-600);"><i class="fas fa-box"></i></div>
          <div class="public-stat-label"><?= htmlspecialchars($inv->nama_barang, ENT_QUOTES) ?></div>
          <div class="public-stat-value" style="font-size: 1.25rem;">
            <?= (int)$inv->jumlah ?> <?= htmlspecialchars($inv->satuan, ENT_QUOTES) ?>
          </div>
          <div class="public-stat-period">Kondisi: <?= htmlspecialchars($inv->kondisi, ENT_QUOTES) ?></div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="empty-state" style="grid-column: 1 / -1;">
        <i class="fas fa-box-open"></i>
        <h3>Belum ada data inventaris</h3>
        <p>Data inventaris belum ditambahkan.</p>
      </div>
    <?php endif; ?>
  </div>

  <!-- CTA -->
  <div class="public-cta" data-aos="zoom-in" data-aos-delay="100">
    <h3>Pengurus RT-19?</h3>
    <p>Masuk untuk mengelola data warga, kas, iuran, dan surat menyurat.</p>
    <a href="<?= base_url('auth') ?>" class="public-cta-btn">
      <i class="fas fa-sign-in-alt"></i> Login Sekarang
    </a>
  </div>
</div>

<!-- ============================================================
     FOOTER
     ============================================================ -->
<footer class="public-footer">
  &copy; <?= date('Y') ?> <strong>RT-19 Orchid Regency</strong> Sidoarjo &middot; Sistem Informasi Manajemen RT
</footer>

<!-- ============================================================
     MODAL: Detail Pengurus
     ============================================================ -->
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

      <div class="rt-modal-meta" id="modalMeta">
        <!-- terisi via JS -->
      </div>

      <div id="modalWaSlot"></div>
    </div>
  </div>
</div>

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, mirror: false });

  // ============= Mobile Menu =============
  function toggleNav() {
    document.getElementById('navLinks').classList.toggle('active');
  }
  function closeNav() {
    if(window.innerWidth <= 992) {
      document.getElementById('navLinks').classList.remove('active');
    }
  }

  // ============= Modal Struktur =============
  function openStrukturModal(p) {
    var modal       = document.getElementById('strukturModal');
    var jabatan     = document.getElementById('modalJabatan');
    var nama        = document.getElementById('modalNama');
    var meta        = document.getElementById('modalMeta');
    var photoSlot   = document.getElementById('modalPhotoSlot');
    var waSlot      = document.getElementById('modalWaSlot');

    jabatan.textContent = p.jabatan || '-';

    // Photo / initial
    if (p.foto) {
      photoSlot.innerHTML = '<img class="rt-modal-photo" src="' + p.foto + '" alt="">';
    } else {
      photoSlot.innerHTML = '<div class="rt-modal-photo initial">' +
                            (p.initial || '?').replace(/[<>&"]/g, '') + '</div>';
    }

    // Nama
    if (p.nama) {
      nama.innerHTML = escapeHtml(p.nama);
    } else {
      nama.innerHTML = '<span class="muted">Belum diisi</span>';
    }

    // Meta rows
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

    // WhatsApp button
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

  // ESC closes modal
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
