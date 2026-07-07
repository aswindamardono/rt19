<?php
$role_id     = $this->session->userdata('role_id');
$nama_user   = $this->session->userdata('nama_lengkap');
$nama_role   = $this->session->userdata('nama_role');
$user_initial= strtoupper(substr($nama_user ?: 'U', 0, 1));
$active_seg1 = $this->uri->segment(1);
$active_seg2 = $this->uri->segment(2);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="RT-19 Orchid Regency — Sistem Informasi Manajemen RT, Keuangan, Iuran, Surat, dan Pengumuman.">
  <meta name="theme-color" content="#064e3b">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <title><?= isset($title) ? $title.' — ' : '' ?>RT-19 Orchid Regency</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">
  <link rel="apple-touch-icon" href="<?= base_url('assets/img/favicon.png') ?>">

  <!-- Preconnect -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.min.css">

  <!-- Bootstrap 4 (komponen utk view lama: modal, dropdown, custom-file, dll) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

  <!-- AdminLTE (untuk small-box, products-list dipakai di view lama) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>?v=<?= @filemtime(FCPATH.'assets/css/custom.css') ?: time() ?>">

  <script>
    const BASE_URL = '<?= base_url() ?>';
  </script>
</head>
<body>

<!-- ============================================================
     MOBILE HEADER
     ============================================================ -->
<header class="rt-mobile-header">
  <a href="<?= base_url('dashboard') ?>" class="rt-mobile-header-logo">
    <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo" onerror="this.style.display='none'">
    <span>RT-19 Orchid Regency</span>
  </a>
  <a href="<?= base_url('auth/logout') ?>" class="rt-mobile-avatar"
     onclick="return confirm('Yakin ingin keluar?');" title="Logout">
    <?= htmlspecialchars($user_initial, ENT_QUOTES) ?>
  </a>
</header>
