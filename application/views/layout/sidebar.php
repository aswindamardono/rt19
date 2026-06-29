<?php
// Sidebar (desktop) + bottom-nav placeholder vars
$role_id     = $this->session->userdata('role_id');
$nama_user   = $this->session->userdata('nama_lengkap');
$nama_role   = $this->session->userdata('nama_role');
$user_initial= strtoupper(substr($nama_user ?: 'U', 0, 1));
$seg1 = $this->uri->segment(1);
$seg2 = $this->uri->segment(2);

$is_active = function($s1, $s2 = null) use ($seg1, $seg2) {
    if ($s2 === null) return $seg1 === $s1 ? 'active' : '';
    return ($seg1 === $s1 && $seg2 === $s2) ? 'active' : '';
};
?>

<!-- ============================================================
     SIDEBAR (Desktop)
     ============================================================ -->
<aside class="rt-sidebar">
  <a href="<?= base_url('dashboard') ?>" class="rt-sidebar-logo">
    <div class="rt-sidebar-logo-icon">
      <img src="<?= base_url('assets/img/logo.png') ?>" alt="RT-19" onerror="this.style.display='none';this.parentNode.innerHTML='🏘️';">
    </div>
    <div>
      <h1>RT-19 Orchid Regency</h1>
      <p>Sistem Manajemen RT</p>
    </div>
  </a>

  <nav class="rt-sidebar-nav">

    <a href="<?= base_url('dashboard') ?>" class="rt-sidebar-item <?= $is_active('dashboard') ?>">
      <i class="fas fa-th-large"></i> Dashboard
    </a>

    <?php if (in_array($role_id, [1, 4, 6])): // Super Admin, Sekretaris, Pengurus ?>
      <div class="rt-sidebar-section">Data Master</div>
      <a href="<?= base_url('warga') ?>" class="rt-sidebar-item <?= $is_active('warga') ?>">
        <i class="fas fa-users"></i> Data Warga
      </a>
      <a href="<?= base_url('inventaris') ?>" class="rt-sidebar-item <?= $is_active('inventaris') ?>">
        <i class="fas fa-boxes"></i> Inventaris Barang
      </a>
    <?php endif; ?>

    <?php if (in_array($role_id, [1, 3, 6])): // Super Admin, Bendahara, Pengurus ?>
      <div class="rt-sidebar-section">Keuangan & Iuran</div>
      <a href="<?= base_url('keuangan/pemasukan') ?>" class="rt-sidebar-item <?= $is_active('keuangan','pemasukan') ?>">
        <i class="fas fa-arrow-down"></i> Pemasukan Kas
      </a>
      <a href="<?= base_url('keuangan/pengeluaran') ?>" class="rt-sidebar-item <?= $is_active('keuangan','pengeluaran') ?>">
        <i class="fas fa-arrow-up"></i> Pengeluaran Kas
      </a>
      <a href="<?= base_url('keuangan/laporan') ?>" class="rt-sidebar-item <?= $is_active('keuangan','laporan') ?>">
        <i class="fas fa-file-invoice-dollar"></i> Laporan Keuangan
      </a>
      <a href="<?= base_url('iuran') ?>" class="rt-sidebar-item <?= $is_active('iuran') ?>">
        <i class="fas fa-hand-holding-usd"></i> Iuran Bulanan
      </a>
    <?php endif; ?>

    <div class="rt-sidebar-section">Layanan & Informasi</div>
    <a href="<?= base_url('surat') ?>" class="rt-sidebar-item <?= $is_active('surat') ?>">
      <i class="fas fa-envelope"></i> Surat Menyurat
    </a>
    <a href="<?= base_url('pengumuman') ?>" class="rt-sidebar-item <?= $is_active('pengumuman') ?>">
      <i class="fas fa-bullhorn"></i> Pengumuman
    </a>
    <?php if (in_array($role_id, [1, 4, 6])): // Super Admin, Sekretaris, Pengurus ?>
      <a href="<?= base_url('struktur') ?>" class="rt-sidebar-item <?= $is_active('struktur') ?>">
        <i class="fas fa-sitemap"></i> Struktur Organisasi
      </a>
    <?php endif; ?>

    <?php if (in_array($role_id, [1])): // Super Admin ?>
      <div class="rt-sidebar-section">Pengaturan</div>
      <a href="<?= base_url('users') ?>" class="rt-sidebar-item <?= $is_active('users') ?>">
        <i class="fas fa-users-cog"></i> Kelola User
      </a>
      <a href="<?= base_url('pengaturan') ?>" class="rt-sidebar-item <?= $is_active('pengaturan') ?>">
        <i class="fas fa-cogs"></i> Pengaturan Sistem
      </a>
    <?php endif; ?>

  </nav>

  <div class="rt-sidebar-user">
    <div class="rt-sidebar-user-info">
      <div class="rt-avatar"><?= htmlspecialchars($user_initial, ENT_QUOTES) ?></div>
      <div>
        <div class="rt-sidebar-user-name"><?= htmlspecialchars($nama_user ?: '-', ENT_QUOTES) ?></div>
        <div class="rt-sidebar-user-role"><?= htmlspecialchars($nama_role ?: '-', ENT_QUOTES) ?></div>
      </div>
    </div>
    <a href="<?= base_url('auth/logout') ?>" class="rt-sidebar-item"
       onclick="return confirm('Yakin ingin keluar?');"
       style="color: rgba(255,255,255,0.55);">
      <i class="fas fa-sign-out-alt"></i> Keluar
    </a>
  </div>
</aside>

<!-- ============================================================
     MAIN CONTENT WRAPPER
     ============================================================ -->
<main class="rt-main">
  <div class="rt-page-header" data-aos="fade-right" data-aos-duration="600">
    <h1>
      <?php
      // Pilih ikon berdasarkan section
      $ico = 'fa-th-large';
      switch ($seg1) {
        case 'warga':       $ico = 'fa-users'; break;
        case 'inventaris':  $ico = 'fa-boxes'; break;
        case 'keuangan':    $ico = ($seg2 === 'pengeluaran') ? 'fa-arrow-up' : (($seg2 === 'laporan') ? 'fa-file-invoice-dollar' : 'fa-arrow-down'); break;
        case 'iuran':       $ico = 'fa-hand-holding-usd'; break;
        case 'surat':       $ico = 'fa-envelope'; break;
        case 'pengumuman':  $ico = 'fa-bullhorn'; break;
        case 'struktur':    $ico = 'fa-sitemap'; break;
        case 'users':       $ico = 'fa-users-cog'; break;
        case 'pengaturan':  $ico = 'fa-cogs'; break;
      }
      ?>
      <i class="fas <?= $ico ?>"></i>
      <?= isset($title) ? htmlspecialchars($title, ENT_QUOTES) : 'Dashboard' ?>
    </h1>
    <?php if (isset($subtitle) && $subtitle): ?>
      <p><?= htmlspecialchars($subtitle, ENT_QUOTES) ?></p>
    <?php endif; ?>
  </div>

  <div data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
