<?php
/**
 * Public Landing Layout
 * Variables: $page_title, $active_menu, $page_content (view name)
 */
$active = isset($active_menu) ? $active_menu : 'keuangan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#064e3b">
  <meta name="description" content="RT-19 Orchid Regency Sidoarjo — Transparansi keuangan & informasi warga.">
  <title><?= isset($page_title) ? $page_title : 'Beranda' ?> — RT-19 Orchid Regency</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>?v=<?= @filemtime(FCPATH.'assets/css/custom.css') ?: time() ?>">

  <style>
    /* ====== Landing Layout ====== */
    :root {
      --bottom-nav-height: 64px;
    }
    .landing-body {
      background: #f8fafc;
      min-height: 100vh;
      animation: fadeIn 0.5s ease;
      padding-bottom: var(--bottom-nav-height);
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    /* ===== Top Navbar ===== */
    .pub-topnav {
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
    .pub-topnav-logo {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1rem;
      color: var(--emerald-900);
      text-decoration: none;
    }
    .pub-topnav-logo:hover { color: var(--emerald-900); text-decoration: none; }
    .pub-topnav-logo img {
      width: 32px; height: 32px;
      border-radius: 8px;
      object-fit: cover;
    }
    .pub-topnav-cta {
      display: inline-flex;
      align-items: center;
      gap: 0.45rem;
      background: var(--gradient-primary);
      color: white !important;
      font-weight: 600;
      padding: 0.55rem 1.1rem;
      border-radius: var(--radius-sm);
      text-decoration: none;
      font-size: 0.88rem;
      transition: all var(--transition-normal);
      border: none;
    }
    .pub-topnav-cta:hover {
      color: white;
      text-decoration: none;
      transform: translateY(-1px);
      box-shadow: var(--shadow-glow);
    }
    
    .pub-mobile-cta {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      background: var(--gradient-primary);
      color: white;
      font-weight: 600;
      padding: 0.45rem 0.85rem;
      border-radius: var(--radius-sm);
      text-decoration: none;
      font-size: 0.85rem;
    }
    .pub-mobile-cta:hover {
      color: white;
      text-decoration: none;
    }

    /* ===== Bottom Nav (always visible on mobile) ===== */
    .pub-bottom-nav {
      position: fixed;
      bottom: 0; left: 0; right: 0;
      background: rgba(255,255,255,0.97);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-top: 1px solid rgba(16,185,129,0.15);
      display: flex;
      justify-content: space-around;
      padding: 0.35rem 0 env(safe-area-inset-bottom, 0.35rem);
      z-index: 1020;
      box-shadow: 0 -4px 20px rgba(0,0,0,0.06);
    }
    .pub-bottom-nav a {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 0.35rem 0.4rem;
      border-radius: var(--radius-sm);
      color: #94a3b8;
      text-decoration: none;
      font-size: 0.62rem;
      font-weight: 600;
      transition: all var(--transition-fast);
      flex: 1;
      min-width: 0;
      gap: 0.2rem;
      position: relative;
    }
    .pub-bottom-nav a i {
      font-size: 1.15rem;
      transition: transform var(--transition-fast);
    }
    .pub-bottom-nav a.active {
      color: var(--emerald-600);
    }
    .pub-bottom-nav a.active::before {
      content: '';
      position: absolute;
      top: -0.35rem;
      left: 50%;
      transform: translateX(-50%);
      width: 24px;
      height: 3px;
      background: var(--gradient-primary);
      border-radius: 0 0 4px 4px;
    }
    .pub-bottom-nav a.active i { transform: scale(1.15); }
    .pub-bottom-nav a:hover { color: var(--emerald-600); text-decoration: none; }

    /* On desktop: show as horizontal top nav links instead */
    .pub-desktop-links {
      display: none;
      list-style: none;
      margin: 0;
      padding: 0;
      gap: 0.25rem;
      align-items: center;
    }
    .pub-desktop-links a {
      text-decoration: none;
      color: #64748b;
      font-weight: 600;
      font-size: 0.88rem;
      padding: 0.5rem 0.85rem;
      border-radius: var(--radius-sm);
      transition: all var(--transition-fast);
      display: flex;
      align-items: center;
      gap: 0.4rem;
    }
    .pub-desktop-links a:hover { color: var(--emerald-700); background: var(--emerald-50); text-decoration: none; }
    .pub-desktop-links a.active { color: var(--emerald-700); background: var(--emerald-50); font-weight: 700; }

    @media (min-width: 992px) {
      .pub-bottom-nav { display: none; }
      .pub-mobile-cta { display: none; }
      .pub-desktop-links { display: flex; }
      .pub-topnav { padding: 0.65rem 2rem; }
      :root { --bottom-nav-height: 0px; }
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

    /* ===== Page Content Area ===== */
    .pub-page {
      max-width: 1080px;
      margin: 0 auto;
      padding: 1.5rem 1.25rem 2rem;
    }

    /* ===== Page Header ===== */
    .pub-page-header {
      text-align: center;
      margin-bottom: 1.5rem;
    }
    .pub-page-header h1 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      color: var(--emerald-900);
      font-size: 1.35rem;
      margin: 0 0 0.4rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }
    .pub-page-header h1 i { color: var(--emerald-600); }
    .pub-page-header p {
      color: #64748b;
      font-size: 0.9rem;
      margin: 0;
    }
    @media (min-width: 640px) {
      .pub-page-header h1 { font-size: 1.6rem; }
    }

    /* ===== Stat cards (reused from old landing) ===== */
    .pub-stat-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }
    @media (min-width: 640px) {
      .pub-stat-grid { grid-template-columns: repeat(3, 1fr); }
    }
    .pub-stat {
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
    .pub-stat:hover { transform: translateY(-3px); box-shadow: var(--shadow-xl); }
    .pub-stat::after {
      content: '';
      position: absolute;
      top: -40px; right: -40px;
      width: 130px; height: 130px;
      border-radius: 50%;
      background: rgba(16,185,129,0.07);
      pointer-events: none;
    }
    .pub-stat-icon {
      width: 48px; height: 48px;
      border-radius: var(--radius-md);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      margin-bottom: 0.85rem;
    }
    .pub-stat-icon.balance  { background: #d1fae5; color: var(--emerald-700); }
    .pub-stat-icon.income   { background: #dcfce7; color: #059669; }
    .pub-stat-icon.expense  { background: #fecaca; color: #dc2626; }
    .pub-stat-label {
      font-size: 0.78rem;
      font-weight: 600;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      margin-bottom: 0.4rem;
    }
    .pub-stat-value {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.55rem;
      line-height: 1.2;
    }
    .pub-stat-value.balance  { color: var(--emerald-800); }
    .pub-stat-value.income   { color: #059669; }
    .pub-stat-value.expense  { color: #dc2626; }
    .pub-stat-period {
      font-size: 0.72rem;
      color: #94a3b8;
      margin-top: 0.4rem;
    }

    /* ===== Announcements ===== */
    .pub-ann-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }
    @media (min-width: 720px) {
      .pub-ann-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (min-width: 1024px) {
      .pub-ann-grid { grid-template-columns: repeat(3, 1fr); }
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

    /* ===== Empty state ===== */
    .pub-empty {
      text-align: center;
      padding: 3rem 1.5rem;
      color: #94a3b8;
      grid-column: 1 / -1;
    }
    .pub-empty i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.4; }
    .pub-empty h3 { font-size: 1rem; font-weight: 600; color: #64748b; margin-bottom: 0.4rem; }
    .pub-empty p { font-size: 0.88rem; margin: 0; }

    /* ===== Inventaris Table ===== */
    .pub-inv-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }
    @media (min-width: 640px) {
      .pub-inv-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (min-width: 900px) {
      .pub-inv-grid { grid-template-columns: repeat(3, 1fr); }
    }

    /* ===== Footer ===== */
    .pub-footer {
      text-align: center;
      padding: 2rem 1.5rem;
      color: #94a3b8;
      font-size: 0.82rem;
      border-top: 1px solid #e2e8f0;
    }
    .pub-footer strong { color: var(--emerald-800); }

    /* ===== CTA card ===== */
    .pub-cta {
      margin: 2rem auto 1rem;
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
    .pub-cta::before {
      content: '';
      position: absolute;
      width: 240px; height: 240px;
      background: radial-gradient(circle, rgba(255,255,255,0.18), transparent 70%);
      top: -60px; right: -60px;
      border-radius: 50%;
      pointer-events: none;
    }
    .pub-cta h3 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.3rem;
      font-weight: 800;
      margin: 0 0 0.4rem;
      color: white;
      position: relative;
    }
    .pub-cta p {
      font-size: 0.92rem;
      color: rgba(255,255,255,0.9);
      margin: 0 0 1.25rem;
      position: relative;
    }
    .pub-cta-btn {
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
    .pub-cta-btn:hover {
      color: var(--emerald-700);
      text-decoration: none;
      transform: translateY(-1px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    /* ===== Struktur Organisasi (Vertical Tree) ===== */
    .orgchart-wrapper {
      padding: 1rem 0;
      background: transparent;
    }
    .org-tree-list {
      max-width: 500px;
      margin: 0 auto;
    }
    .org-tree-node {
      position: relative;
      margin-bottom: 0.85rem;
    }
    .org-tree-children {
      margin-left: 30px;
      padding-left: 22px;
      border-left: 2px solid var(--emerald-400);
      position: relative;
      margin-top: 0.85rem;
    }
    .org-tree-children .org-tree-node::before {
      content: '';
      position: absolute;
      top: 32px;
      left: -22px;
      width: 18px;
      height: 2px;
      background-color: var(--emerald-400);
    }
    .org-card {
      display: flex;
      align-items: center;
      background: white;
      border-radius: 12px;
      padding: 10px 14px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      border: 1px solid rgba(16,185,129,0.08);
      position: relative;
      z-index: 2;
    }
    .org-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(16,185,129,0.12);
    }
    .org-card.org-root {
      background: var(--emerald-700);
      border-color: var(--emerald-800);
      box-shadow: 0 4px 12px rgba(4, 120, 87, 0.2);
    }
    .org-avatar {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: var(--emerald-600);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 800;
      font-size: 1.25rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      margin-right: 14px;
      flex-shrink: 0;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      object-fit: cover;
    }
    .org-card.org-root .org-avatar {
      background: rgba(255,255,255,0.2);
      border: 1.5px solid rgba(255,255,255,0.4);
      box-shadow: none;
    }
    .org-info {
      display: flex;
      flex-direction: column;
      flex: 1;
      overflow: hidden;
      text-align: left;
    }
    .org-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.65rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--emerald-700);
      margin-bottom: 2px;
      line-height: 1.2;
    }
    .org-card.org-root .org-title {
      color: rgba(255,255,255,0.85);
    }
    .org-name {
      font-size: 0.88rem;
      font-weight: 600;
      color: #1e293b;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      margin: 0;
      line-height: 1.3;
    }
    .org-card.org-root .org-name {
      color: white;
    }
    .org-name-empty {
      font-style: italic;
      font-weight: 400;
      color: #94a3b8;
    }
    .org-card.org-root .org-name-empty {
      color: rgba(255,255,255,0.6);
    }

    /* ===== Modal ===== */
    .rt-modal-overlay {
      position: fixed; inset: 0;
      background: rgba(15, 23, 42, 0.55);
      backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
      display: none; align-items: center; justify-content: center;
      z-index: 5000; padding: 1rem;
      animation: rtFadeIn 0.2s ease;
    }
    .rt-modal-overlay.is-open { display: flex; }
    @keyframes rtFadeIn { from { opacity: 0; } to { opacity: 1; } }
    .rt-modal-card {
      background: white; width: 100%; max-width: 460px;
      border-radius: var(--radius-xl); overflow: hidden;
      box-shadow: var(--shadow-xl);
      animation: rtSlideUp 0.28s cubic-bezier(0.16, 1, 0.3, 1);
      position: relative;
    }
    @keyframes rtSlideUp {
      from { opacity: 0; transform: translateY(24px) scale(0.96); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    .rt-modal-head { background: var(--gradient-hero); padding: 2rem 1.5rem 3.5rem; text-align: center; color: white; position: relative; overflow: hidden; }
    .rt-modal-head::before { content: ''; position: absolute; width: 220px; height: 220px; border-radius: 50%; background: radial-gradient(circle, rgba(255,255,255,0.15), transparent 70%); top: -80px; right: -60px; }
    .rt-modal-close { position: absolute; top: 0.75rem; right: 0.75rem; background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.25); color: white; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: all var(--transition-fast); z-index: 2; }
    .rt-modal-close:hover { background: rgba(255,255,255,0.3); transform: rotate(90deg); }
    .rt-modal-jabatan { font-family: 'Plus Jakarta Sans',sans-serif; font-size: 1.05rem; font-weight: 800; letter-spacing: 0.06em; text-transform: uppercase; color: rgba(255,255,255,0.92); margin: 0; position: relative; z-index: 1; }
    .rt-modal-photo { width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 4px solid white; box-shadow: var(--shadow-lg); margin: -52px auto 0.85rem; display: block; background: var(--gradient-primary); position: relative; z-index: 2; }
    .rt-modal-photo.initial { display: flex; align-items: center; justify-content: center; color: white; font-family: 'Plus Jakarta Sans',sans-serif; font-weight: 800; font-size: 2.5rem; text-transform: uppercase; }
    .rt-modal-body { padding: 0 1.5rem 1.5rem; text-align: center; }
    .rt-modal-body h3 { font-family: 'Plus Jakarta Sans',sans-serif; font-size: 1.35rem; font-weight: 800; color: var(--emerald-900); margin: 0 0 1rem; }
    .rt-modal-body .muted { color: #94a3b8; font-style: italic; font-weight: 500; font-size: 1rem; }
    .rt-modal-meta { display: flex; flex-direction: column; gap: 0.5rem; margin-top: 0.5rem; text-align: left; }
    .rt-modal-row { display: flex; align-items: center; gap: 0.75rem; padding: 0.7rem 0.9rem; background: var(--emerald-50); border-radius: var(--radius-sm); font-size: 0.88rem; }
    .rt-modal-row i { width: 28px; height: 28px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; color: var(--emerald-700); flex-shrink: 0; }
    .rt-modal-row .lbl { color: #64748b; font-size: 0.78rem; }
    .rt-modal-row .val { color: var(--emerald-900); font-weight: 600; }
    .rt-modal-row a { color: var(--emerald-700); text-decoration: none; }
    .rt-modal-row a:hover { text-decoration: underline; }
    .rt-modal-wa-btn { display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #25d366, #128c7e); color: white; padding: 0.65rem 1.25rem; border-radius: var(--radius-sm); font-weight: 600; font-size: 0.9rem; margin-top: 1rem; text-decoration: none; transition: all var(--transition-normal); }
    .rt-modal-wa-btn:hover { color: white; text-decoration: none; transform: translateY(-1px); box-shadow: 0 0 15px rgba(37,211,102,0.4); }
  </style>
</head>
<body class="landing-body">

<!-- ============================================================
     TOP NAVBAR
     ============================================================ -->
<nav class="pub-topnav">
  <a href="<?= base_url() ?>" class="pub-topnav-logo">
    <img src="<?= base_url('assets/img/logo.png') ?>" alt="RT-19" onerror="this.style.display='none'">
    <span>RT-19</span>
  </a>
  <a href="<?= base_url('auth') ?>" class="pub-mobile-cta">
    <i class="fas fa-sign-in-alt"></i> Login
  </a>
  <ul class="pub-desktop-links">
    <li>
      <a href="<?= base_url() ?>" class="<?= $active === 'keuangan' ? 'active' : '' ?>">
        <i class="fas fa-chart-pie"></i> Keuangan
      </a>
    </li>
    <li>
      <a href="<?= base_url('info/struktur') ?>" class="<?= $active === 'struktur' ? 'active' : '' ?>">
        <i class="fas fa-sitemap"></i> Struktur
      </a>
    </li>
    <li>
      <a href="<?= base_url('info/pengumuman') ?>" class="<?= $active === 'pengumuman' ? 'active' : '' ?>">
        <i class="fas fa-bullhorn"></i> Pengumuman
      </a>
    </li>
    <li>
      <a href="<?= base_url('info/inventaris') ?>" class="<?= $active === 'inventaris' ? 'active' : '' ?>">
        <i class="fas fa-boxes"></i> Inventaris
      </a>
    </li>
    <li>
      <a href="<?= base_url('auth') ?>" class="pub-topnav-cta">
        <i class="fas fa-sign-in-alt"></i> Login Pengurus
      </a>
    </li>
  </ul>
</nav>

<!-- ============================================================
     PAGE CONTENT (loaded from sub-view)
     ============================================================ -->
<?php $this->load->view('landing/pages/' . $page_content); ?>

<!-- ============================================================
     FOOTER
     ============================================================ -->
<footer class="pub-footer">
  &copy; <?= date('Y') ?>  Sistem Informasi Manajemen RT &middot; By <strong>ArasITC</strong>
</footer>

<!-- ============================================================
     BOTTOM NAV (Mobile)
     ============================================================ -->
<nav class="pub-bottom-nav">
  <a href="<?= base_url() ?>" class="<?= $active === 'keuangan' ? 'active' : '' ?>">
    <i class="fas fa-chart-pie"></i><span>Keuangan</span>
  </a>
  <a href="<?= base_url('info/struktur') ?>" class="<?= $active === 'struktur' ? 'active' : '' ?>">
    <i class="fas fa-sitemap"></i><span>Struktur</span>
  </a>
  <a href="<?= base_url('info/pengumuman') ?>" class="<?= $active === 'pengumuman' ? 'active' : '' ?>">
    <i class="fas fa-bullhorn"></i><span>Pengumuman</span>
  </a>
  <a href="<?= base_url('info/inventaris') ?>" class="<?= $active === 'inventaris' ? 'active' : '' ?>">
    <i class="fas fa-boxes"></i><span>Inventaris</span>
  </a>
</nav>

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, mirror: false });
</script>

<?php if(isset($custom_js)): ?>
  <?= $custom_js ?>
<?php endif; ?>

</body>
</html>
